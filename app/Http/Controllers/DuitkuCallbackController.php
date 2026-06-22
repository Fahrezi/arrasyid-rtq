<?php

namespace App\Http\Controllers;

use App\Models\DuitkuPayment;
use App\Services\DuitkuService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DuitkuCallbackController extends Controller
{
    public function handle(Request $request, DuitkuService $duitku): Response
    {
        $payload = $request->all();

        Log::channel('stack')->info('Duitku callback received', $payload);

        $validated = $request->validate([
            'merchantCode'    => 'required|string',
            'amount'          => 'required|numeric',
            'merchantOrderId' => 'required|string',
            'productDetail'   => 'nullable|string',
            'additionalParam' => 'nullable|string',
            'paymentCode'     => 'nullable|string',
            'resultCode'      => 'required|string',
            'merchantUserId'  => 'nullable|string',
            'reference'       => 'required|string',
            'signature'       => 'required|string',
        ]);

        if (! $duitku->verifyCallbackSignature(
            $validated['merchantCode'],
            (int) $validated['amount'],
            $validated['merchantOrderId'],
            $validated['signature']
        )) {
            Log::warning('Duitku callback signature mismatch', ['merchantOrderId' => $validated['merchantOrderId']]);

            return response('invalid signature', 400);
        }

        $payment = DuitkuPayment::where('merchant_order_id', $validated['merchantOrderId'])->first();

        if (! $payment) {
            return response('order not found', 404);
        }

        if ((float) $validated['amount'] !== (float) $payment->amount) {
            Log::warning('Duitku callback amount mismatch', [
                'merchantOrderId' => $validated['merchantOrderId'],
                'expected'        => $payment->amount,
                'received'        => $validated['amount'],
            ]);

            return response('amount mismatch', 422);
        }

        if ($payment->status === 'completed' || $payment->status === 'failed') {
            return response('SUCCESS', 200);
        }

        $newStatus = $this->mapResultCode($validated['resultCode']);

        $payment->update([
            'status'           => $newStatus,
            'payment_method'   => $validated['paymentCode'] ?? $payment->payment_method,
            'reference'        => $validated['reference'],
            'callback_payload' => $payload,
            'completed_at'     => $newStatus === 'completed' ? now() : null,
        ]);

        if ($newStatus === 'completed') {
            $payment->donation()->update(['status' => 'approved']);
        }

        return response('SUCCESS', 200);
    }

    private function mapResultCode(string $resultCode): string
    {
        return match ($resultCode) {
            '00'    => 'completed',
            '01'    => 'failed',
            default => 'pending',
        };
    }
}
