<?php

namespace App\Http\Controllers;

use App\Models\DuitkuPayment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DonationReturnController extends Controller
{
    public function loading(Request $request): View
    {
        $redirectUrl = $request->query('redirect');

        Log::info('Donation loading page hit', ['redirect' => $redirectUrl]);

        $parsed = parse_url($redirectUrl ?? '');
        $host   = $parsed['host'] ?? '';

        if (! str_ends_with($host, 'duitku.com')) {
            Log::warning('Donation loading rejected invalid redirect', [
                'redirect' => $redirectUrl,
                'host'     => $host,
            ]);
            abort(400, 'Invalid redirect URL.');
        }

        return view('donation.loading', compact('redirectUrl'));
    }

    public function handle(Request $request): View
    {
        $merchantOrderId = $request->query('merchantOrderId');
        $resultCode      = $request->query('resultCode');
        $reference       = $request->query('reference');

        $payment = $merchantOrderId
            ? DuitkuPayment::with('donation.donor')
                ->where('merchant_order_id', $merchantOrderId)
                ->first()
            : null;

        $success = $resultCode === '00';

        return view('donation.return', compact('payment', 'success', 'reference'));
    }
}
