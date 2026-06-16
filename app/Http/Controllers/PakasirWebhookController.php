<?php

namespace App\Http\Controllers;

use App\Models\PakasirPayment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PakasirWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::channel('stack')->info('Pakasir webhook received', $payload);

        $validated = $request->validate([
            'order_id'       => 'required|string',
            'amount'         => 'required|numeric',
            'project'        => 'required|string',
            'status'         => 'required|string',
            'payment_method' => 'nullable|string',
            'completed_at'   => 'nullable|string',
        ]);

        $payment = PakasirPayment::where('order_id', $validated['order_id'])->first();

        if (! $payment) {
            return response()->json(['message' => 'order not found'], 404);
        }

        // Guard: amount must match to prevent spoofed webhooks
        if ((float) $validated['amount'] !== (float) $payment->amount) {
            Log::warning('Pakasir webhook amount mismatch', [
                'order_id' => $validated['order_id'],
                'expected' => $payment->amount,
                'received' => $validated['amount'],
            ]);

            return response()->json(['message' => 'amount mismatch'], 422);
        }

        // Skip if already finalized
        if ($payment->status === 'completed' || $payment->status === 'failed') {
            return response()->json(['message' => 'already processed']);
        }

        $payment->update([
            'status'          => $this->mapStatus($validated['status']),
            'payment_method'  => $validated['payment_method'] ?? $payment->payment_method,
            'webhook_payload' => $payload,
            'completed_at'    => isset($validated['completed_at'])
                ? now()->parse($validated['completed_at'])
                : null,
        ]);

        return response()->json(['message' => 'ok']);
    }

    private function mapStatus(string $status): string
    {
        return match (strtolower($status)) {
            'completed', 'paid', 'success' => 'completed',
            'failed', 'cancelled'           => 'failed',
            'expired'                       => 'expired',
            default                         => 'pending',
        };
    }
}
