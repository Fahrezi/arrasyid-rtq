<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class DuitkuService
{
    private string $merchantCode;
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->merchantCode = config('services.duitku.merchant_code');
        $this->apiKey       = config('services.duitku.api_key');
        $this->baseUrl      = rtrim(config('services.duitku.base_url'), '/');
    }

    public function createInvoice(string $merchantOrderId, int $amount, array $customer, string $paymentMethod = 'VC'): array
    {
        $signature = md5($this->merchantCode . $merchantOrderId . $amount . $this->apiKey);

        $response = Http::post($this->baseUrl . '/api/merchant/v2/inquiry', [
            'merchantCode'    => $this->merchantCode,
            'paymentAmount'   => $amount,
            'paymentMethod'   => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails'  => 'Donasi RTQ Ar-Rasyid',
            'email'           => $customer['email'] ?? '',
            'customerVaName'  => $customer['name'],
            'phoneNumber'     => $customer['phone'] ?? '',
            'callbackUrl'     => route('callback.duitku'),
            'returnUrl'       => route('donation.return'),
            'expiryPeriod'    => 60,
            'signature'       => $signature,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Duitku API error: ' . $response->body());
        }

        $data = $response->json();

        if (! isset($data['paymentUrl'])) {
            throw new RuntimeException('Duitku API error: ' . json_encode($data));
        }

        return $data;
    }

    public function verifyCallbackSignature(string $merchantCode, int $amount, string $merchantOrderId, string $signature): bool
    {
        $expected = md5($merchantCode . $amount . $merchantOrderId . $this->apiKey);

        return hash_equals($expected, $signature);
    }
}
