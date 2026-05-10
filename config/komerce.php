<?php

return [
    'api_key' => env('KOMERCE_API_KEY', ''),
    'base_url' => env('KOMERCE_BASE_URL', 'https://api.collaborator.komerce.my.id/tariff/api/v1'),
    'origin_destination_id' => env('KOMERCE_ORIGIN_ID', ''), // Will be set after searching origin city
];
