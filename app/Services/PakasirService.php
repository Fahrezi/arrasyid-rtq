<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PakasirService
{
    private string $apiKey;
    private string $baseUrl;
    private string $project;

    public function __construct()
    {
        $this->apiKey  = config('services.pakasir.api_key');
        $this->baseUrl = rtrim(config('services.pakasir.base_url'), '/');
        $this->project = config('services.pakasir.project');
    }

    public function createPayment(string $orderId, int $amount, array $customer): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept'        => 'application/json',
        ])->post($this->baseUrl . '/v1/payment', [
            'order_id'     => $orderId,
            'amount'       => $amount,
            'project'      => $this->project,
            'name'         => $customer['name'],
            'email'        => $customer['email'] ?? null,
            'phone'        => $customer['phone'] ?? null,
            'callback_url' => route('webhook.pakasir'),
            'redirect_url' => url('/'),
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Pakasir API error: ' . $response->body());
        }

        return $response->json();
    }
}
