<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class KomerceShippingService
{
    private string $apiKey;
    private string $baseUrl;
    private string $originId;

    public function __construct()
    {
        $this->apiKey = config('komerce.api_key', '');
        $this->baseUrl = config('komerce.base_url', 'https://api.collaborator.komerce.my.id/tariff/api/v1');
        $this->originId = config('komerce.origin_destination_id', '');
    }

    /**
     * Search destinations by keyword (city name, district, or postal code).
     * Returns a list of matching locations with their IDs.
     */
    public function searchDestination(string $keyword): array
    {
        $cacheKey = 'komerce_dest_' . md5($keyword);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['x-api-key' => $this->apiKey])
                ->get("{$this->baseUrl}/destination/search", [
                    'keyword' => $keyword,
                ]);

            if ($response->successful()) {
                $data = $response->json('data') ?? $response->json() ?? [];
                if (!empty($data)) {
                    Cache::put($cacheKey, $data, 3600); // cache 1 hour
                }
                return $data;
            }

            Log::error('Komerce destination search error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        } catch (\Exception $e) {
            Log::error('Komerce destination search exception', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Calculate shipping cost between origin and destination.
     */
    public function calculateCost(string $receiverDestinationId, float $weight, int $itemValue = 0, string $cod = 'no'): array
    {
        try {
            $params = [
                'shipper_destination_id' => $this->originId,
                'receiver_destination_id' => $receiverDestinationId,
                'weight' => $weight,
                'item_value' => $itemValue,
                'cod' => $cod,
            ];

            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['x-api-key' => $this->apiKey])
                ->get("{$this->baseUrl}/calculate", $params);

            if ($response->successful()) {
                return $response->json('data') ?? $response->json() ?? [];
            }

            Log::error('Komerce calculate error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        } catch (\Exception $e) {
            Log::error('Komerce calculate exception', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Get the configured origin destination ID.
     */
    public function getOriginId(): string
    {
        return $this->originId;
    }
}
