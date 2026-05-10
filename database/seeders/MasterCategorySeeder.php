<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class MasterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Concentration Types
            'Extrait de Parfum',
            'Eau de Parfum (EDP)',
            'Eau de Toilette (EDT)',
            'Eau de Cologne (EDC)',
            'Hair Mist',
            'Solid Perfume',
            
            // Fragrance Families (if they want to categorize by family instead)
            'Floral Collection',
            'Woody Collection',
            'Oriental Collection',
            'Fresh & Aquatic Collection',
            'Citrus Collection',
            'Gourmand Collection',
            'Chypre Collection',
            'Fougère Collection',
            
            // Special Collections
            'Signature Series',
            'Private Blend',
            'Limited Edition',
            'Unisex Collection',
            'Pour Homme',
            'Pour Femme'
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }
    }
}
