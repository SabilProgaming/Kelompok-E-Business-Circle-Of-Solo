<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    private string $apiKey;
    private string $baseUrl;
    private string $originCityId;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key', '');
        $this->baseUrl = config('rajaongkir.base_url', 'https://api.rajaongkir.com/starter');
        $this->originCityId = config('rajaongkir.origin_city_id', '152');
    }

    /**
     * Get all provinces (cached for 24 hours).
     */
    public function getProvinces(): array
    {
        if (Cache::has('rajaongkir_provinces')) {
            return Cache::get('rajaongkir_provinces');
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['key' => $this->apiKey])
                ->get("{$this->baseUrl}/province");

            if ($response->successful()) {
                $data = $response->json('rajaongkir.results') ?? [];
                if (!empty($data)) {
                    Cache::put('rajaongkir_provinces', $data, 86400);
                }
                return $data;
            }

            Log::error('RajaOngkir provinces error', ['body' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir provinces exception', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Get cities by province ID (cached for 24 hours).
     */
    public function getCities(?string $provinceId = null): array
    {
        $cacheKey = 'rajaongkir_cities_' . ($provinceId ?? 'all');

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $params = [];
            if ($provinceId) {
                $params['province'] = $provinceId;
            }

            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders(['key' => $this->apiKey])
                ->get("{$this->baseUrl}/city", $params);

            if ($response->successful()) {
                $data = $response->json('rajaongkir.results') ?? [];
                if (!empty($data)) {
                    Cache::put($cacheKey, $data, 86400);
                }
                return $data;
            }

            Log::error('RajaOngkir cities error', ['body' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir cities exception', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Calculate shipping cost.
     */
    public function getCost(string $destinationCityId, int $weight, string $courier): array
    {
        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['key' => $this->apiKey])
                ->post("{$this->baseUrl}/cost", [
                    'origin' => $this->originCityId,
                    'destination' => $destinationCityId,
                    'weight' => $weight,
                    'courier' => $courier,
                ]);

            if ($response->successful()) {
                return $response->json('rajaongkir.results') ?? [];
            }

            Log::error('RajaOngkir cost error', ['body' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir cost exception', ['error' => $e->getMessage()]);
            return [];
        }
    }
}
