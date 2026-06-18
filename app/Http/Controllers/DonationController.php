<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\PakasirPayment;
use App\Models\Program;
use App\Services\PakasirService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function store(Request $request, PakasirService $pakasir): JsonResponse
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email|max:255',
            'phone'  => 'nullable|string|max:20',
            'amount' => 'required|integer|min:10000',
            'notes'  => 'nullable|string|max:1000',
        ]);

        $program = Program::where('status', 'active')->first();

        if (! $program) {
            return response()->json(['message' => 'Tidak ada program aktif saat ini.'], 422);
        }

        try {
            $result = DB::transaction(function () use ($data, $program, $pakasir) {
                $donor = Donor::firstOrCreate(
                    ['email' => $data['email'] ?? null, 'name' => $data['name']],
                    [
                        'name'   => $data['name'],
                        'email'  => $data['email'] ?? null,
                        'phone'  => $data['phone'] ?? null,
                        'type'   => 'non_fix',
                        'status' => 'active',
                    ]
                );

                $donation = Donation::create([
                    'donor_id'       => $donor->id,
                    'program_id'     => $program->id,
                    'amount'         => $data['amount'],
                    'donated_at'     => now(),
                    'payment_method' => 'e_wallet',
                    'status'         => 'pending',
                    'notes'          => $data['notes'] ?? null,
                ]);

                $orderId = PakasirPayment::generateOrderId();

                $apiResponse = $pakasir->createPayment($orderId, (int) $data['amount'], [
                    'name'  => $data['name'],
                    'email' => $data['email'] ?? null,
                    'phone' => $data['phone'] ?? null,
                ]);

                PakasirPayment::create([
                    'order_id'    => $orderId,
                    'donation_id' => $donation->id,
                    'amount'      => $data['amount'],
                    'project'     => config('services.pakasir.project'),
                    'status'      => 'pending',
                    'payment_url' => $apiResponse['payment_url'] ?? null,
                    'qr_string'   => $apiResponse['qr_string'] ?? null,
                    'va_number'   => $apiResponse['va_number'] ?? null,
                ]);

                return $apiResponse['payment_url'] ?? null;
            });

            return response()->json(['payment_url' => $result]);
        } catch (\Throwable $e) {
            Log::error('Donation store failed', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Gagal memproses donasi. Silakan coba lagi.'], 500);
        }
    }
}
