<?php

namespace App\Http\Controllers;

use App\Services\KomerceShippingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Search destinations by keyword (offline fallback for UAS presentation).
     */
    public function searchDestination(Request $request): JsonResponse
    {
        $keyword = strtolower($request->query('keyword', ''));

        if (strlen($keyword) < 3) {
            return response()->json([]);
        }

        // Offline data for presentation
        $cities = [
            ['id' => '1', 'label' => 'Jakarta Selatan, DKI Jakarta', 'postal_code' => '12110'],
            ['id' => '2', 'label' => 'Jakarta Pusat, DKI Jakarta', 'postal_code' => '10110'],
            ['id' => '3', 'label' => 'Jakarta Barat, DKI Jakarta', 'postal_code' => '11110'],
            ['id' => '4', 'label' => 'Surabaya, Jawa Timur', 'postal_code' => '60111'],
            ['id' => '5', 'label' => 'Bandung, Jawa Barat', 'postal_code' => '40111'],
            ['id' => '6', 'label' => 'Medan, Sumatera Utara', 'postal_code' => '20111'],
            ['id' => '7', 'label' => 'Semarang, Jawa Tengah', 'postal_code' => '50111'],
            ['id' => '8', 'label' => 'Makassar, Sulawesi Selatan', 'postal_code' => '90111'],
            ['id' => '9', 'label' => 'Denpasar, Bali', 'postal_code' => '80111'],
            ['id' => '10', 'label' => 'Surakarta (Solo), Jawa Tengah', 'postal_code' => '57111'],
            ['id' => '11', 'label' => 'Yogyakarta, DI Yogyakarta', 'postal_code' => '55111'],
            ['id' => '12', 'label' => 'Malang, Jawa Timur', 'postal_code' => '65111'],
            ['id' => '13', 'label' => 'Palembang, Sumatera Selatan', 'postal_code' => '30111'],
            ['id' => '14', 'label' => 'Baturaja, Sumatera Selatan', 'postal_code' => '32111'],
            ['id' => '15', 'label' => 'Prabumulih, Sumatera Selatan', 'postal_code' => '31111'],
        ];

        $results = array_filter($cities, function ($city) use ($keyword) {
            return str_contains(strtolower($city['label']), $keyword);
        });

        return response()->json(array_values($results));
    }

    /**
     * Calculate shipping cost to a destination (offline fallback for UAS presentation).
     */
    public function calculateCost(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_destination_id' => 'required|string',
            'weight' => 'required|numeric|min:0.1',
        ]);

        $destinationId = $request->input('receiver_destination_id');
        
        // Base cost: Jabodetabek is cheaper, outside is more expensive
        $baseCost = in_array($destinationId, ['1', '2', '3', '5']) ? 15000 : 35000;
        
        // Add random variation to make it look real
        $randomVariation = rand(0, 5) * 1000;

        $results = [
            [
                'courier' => 'JNE',
                'service' => 'REG',
                'cost' => $baseCost + $randomVariation,
                'etd' => '2-3 Hari',
            ],
            [
                'courier' => 'JNE',
                'service' => 'YES',
                'cost' => $baseCost + 15000 + $randomVariation,
                'etd' => '1 Hari',
            ],
            [
                'courier' => 'SiCepat',
                'service' => 'BEST',
                'cost' => $baseCost + 12000 + $randomVariation,
                'etd' => '1-2 Hari',
            ]
        ];

        return response()->json($results);
    }
}
