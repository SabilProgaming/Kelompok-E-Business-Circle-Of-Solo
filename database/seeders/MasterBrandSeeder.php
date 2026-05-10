<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class MasterBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Sanctum Parfumerie',
            'House of Sanctum',
            'Sanctum Private Blend'
        ];

        foreach ($brands as $brandName) {
            Brand::firstOrCreate(['name' => $brandName]);
        }
    }
}
