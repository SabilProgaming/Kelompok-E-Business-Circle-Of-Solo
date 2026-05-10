<?php

namespace Database\Seeders;

use App\Models\Scent;
use Illuminate\Database\Seeder;

class MasterScentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scents = [
            // Floral
            'Rose', 'Jasmine', 'Lavender', 'Ylang-Ylang', 'Peony', 'Geranium', 'Iris', 'Lily of the Valley', 'Tuberose', 'Orchid', 'Lotus', 'Neroli', 'Magnolia', 'Freesia', 'Orange Blossom',
            
            // Woody & Earthy
            'Oud', 'Sandalwood', 'Cedarwood', 'Patchouli', 'Vetiver', 'Oakmoss', 'Pine', 'Cypress', 'Guaiac Wood', 'Rosewood', 'Cashmere Wood', 'Birch',
            
            // Citrus
            'Bergamot', 'Lemon', 'Mandarin', 'Grapefruit', 'Sweet Orange', 'Lime', 'Yuzu', 'Petitgrain', 'Pomelo', 'Blood Orange',
            
            // Oriental / Resins / Sweet
            'Vanilla', 'Amber', 'Tonka Bean', 'Benzoin', 'Myrrh', 'Frankincense (Olibanum)', 'Labdanum', 'Musk', 'White Musk', 'Praline', 'Caramel', 'Honey', 'Chocolate', 'Coffee',
            
            // Fruity (Non-Citrus)
            'Peach', 'Apple', 'Plum', 'Pear', 'Raspberry', 'Blackcurrant', 'Cherry', 'Coconut', 'Fig', 'Pineapple', 'Melon', 'Passionfruit', 'Strawberry',
            
            // Spicy
            'Cardamom', 'Cinnamon', 'Clove', 'Nutmeg', 'Black Pepper', 'Pink Pepper', 'Saffron', 'Ginger', 'Coriander', 'Star Anise',
            
            // Green & Herbal
            'Mint', 'Basil', 'Rosemary', 'Sage', 'Thyme', 'Eucalyptus', 'Galbanum', 'Violet Leaf', 'Tea', 'Green Tea', 'Bamboo',
            
            // Leather & Tobacco
            'Leather', 'Tobacco', 'Suede',
            
            // Aquatic & Fresh
            'Sea Salt', 'Water Lily', 'Seaweed', 'Ambergris', 'Ozone', 'Rain'
        ];

        foreach ($scents as $scentName) {
            Scent::firstOrCreate(['name' => $scentName]);
        }
    }
}
