<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\DuitkuPayment;
use App\Models\Program;
use App\Services\DuitkuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function store(Request $request, DuitkuService $duitku): JsonResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'amount'         => 'required|integer|min:10000',
            'notes'          => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:BC,M2,BT,OV,DA,SL,VC,I1,BV,M1,A1,LT',
        ]);

        $program = Program::where('status', 'active')->first();

        if (! $program) {
            return response()->json(['message' => 'Tidak ada program aktif saat ini.'], 422);
        }

        Log::info('Donation store initiated', [
            'name'           => $data['name'],
            'amount'         => $data['amount'],
            'payment_method' => $data['payment_method'],
        ]);

        try {
            $result = DB::transaction(function () use ($data, $program, $duitku) {
                $donor = Donor::create([
                    'name'   => $data['name'],
                    'email'  => $data['email'] ?? null,
                    'phone'  => $data['phone'] ?? null,
                    'type'   => 'non_fix',
                    'status' => 'active',
                ]);

                $donation = Donation::create([
                    'donor_id'       => $donor->id,
                    'program_id'     => $program->id,
                    'amount'         => $data['amount'],
                    'donated_at'     => now(),
                    'payment_method' => 'e_wallet',
                    'status'         => 'pending',
                    'notes'          => $data['notes'] ?? null,
                ]);

                $merchantOrderId = DuitkuPayment::generateOrderId();

                $apiResponse = $duitku->createInvoice($merchantOrderId, (int) $data['amount'], [
                    'name'  => $data['name'],
                    'email' => $data['email'] ?? null,
                    'phone' => $data['phone'] ?? null,
                ], $data['payment_method']);

                DuitkuPayment::create([
                    'merchant_order_id' => $merchantOrderId,
                    'donation_id'       => $donation->id,
                    'amount'            => $data['amount'],
                    'status'            => 'pending',
                    'payment_url'       => $apiResponse['paymentUrl'] ?? null,
                    'va_number'         => $apiResponse['vaNumber'] ?? null,
                    'qr_string'         => $apiResponse['qrString'] ?? null,
                    'reference'         => $apiResponse['reference'] ?? null,
                ]);

                Log::info('Duitku invoice created', [
                    'merchant_order_id' => $merchantOrderId,
                    'payment_url'       => $apiResponse['paymentUrl'] ?? null,
                    'reference'         => $apiResponse['reference'] ?? null,
                ]);

                return $apiResponse['paymentUrl'] ?? null;
            });

            Log::info('Donation store success', ['payment_url' => $result]);

            return response()->json(['payment_url' => $result]);
        } catch (\Throwable $e) {
            Log::error('Donation store failed', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Gagal memproses donasi. Silakan coba lagi.'], 500);
        }
    }
}
