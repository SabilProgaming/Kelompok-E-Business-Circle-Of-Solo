<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductScentDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            'Noir de Noir'          => ['top' => 'Saffron, Lavender',       'mid' => 'Rose, Black Truffle',         'base' => 'Oud, Vanilla, Patchouli',     'lon' => 5, 'sil' => 4],
            'Sauvage Elixir'        => ['top' => 'Cinnamon, Cardamom',      'mid' => 'Lavender, Nutmeg',            'base' => 'Sandalwood, Amber, Vetiver',  'lon' => 5, 'sil' => 5],
            'Coco Mademoiselle'     => ['top' => 'Orange, Bergamot',        'mid' => 'Rose, Jasmine, Lychee',       'base' => 'Patchouli, Vanilla, Musk',    'lon' => 4, 'sil' => 3],
            'Black Opium'           => ['top' => 'Pink Pepper, Pear',       'mid' => 'Coffee, Jasmine, Bitter Almond','base' => 'Vanilla, Cedar, Cashmere',  'lon' => 4, 'sil' => 4],
            'Eros'                  => ['top' => 'Mint, Green Apple, Lemon','mid' => 'Tonka Bean, Ambroxan',        'base' => 'Vanilla, Vetiver, Cedar',     'lon' => 4, 'sil' => 4],
            'Acqua di Giò Profondo' => ['top' => 'Bergamot, Marine Notes',  'mid' => 'Rosemary, Cypress, Lavender', 'base' => 'Amber, Musk, Patchouli',      'lon' => 4, 'sil' => 3],
            'Aventus'               => ['top' => 'Pineapple, Bergamot, Blackcurrant','mid' => 'Birch, Rose, Jasmine','base' => 'Musk, Oak Moss, Ambergris',  'lon' => 5, 'sil' => 4],
            'Peony & Blush Suede'   => ['top' => 'Red Apple',               'mid' => 'Peony, Jasmine, Rose',        'base' => 'Suede, Musk',                 'lon' => 3, 'sil' => 2],
            'Replica Jazz Club'     => ['top' => 'Pink Pepper, Lemon',      'mid' => 'Clary Sage, Rum, Neroli',     'base' => 'Tobacco, Vanilla, Vetiver',   'lon' => 4, 'sil' => 3],
            'Gypsy Water'           => ['top' => 'Bergamot, Lemon, Pepper', 'mid' => 'Incense, Pine Needle, Orris', 'base' => 'Sandalwood, Vanilla, Amber',  'lon' => 3, 'sil' => 3],
            'Bleu de Chanel'        => ['top' => 'Grapefruit, Lemon, Mint', 'mid' => 'Ginger, Nutmeg, Jasmine',     'base' => 'Sandalwood, Cedar, Incense',  'lon' => 4, 'sil' => 4],
            'La Vie Est Belle'      => ['top' => 'Blackcurrant, Pear',      'mid' => 'Iris, Jasmine, Orange Blossom','base' => 'Praline, Vanilla, Patchouli','lon' => 4, 'sil' => 3],
            'Oud Wood'              => ['top' => 'Rosewood, Cardamom',      'mid' => 'Oud, Sandalwood, Vetiver',    'base' => 'Tonka Bean, Amber',           'lon' => 5, 'sil' => 3],
            'Mon Paris'             => ['top' => 'Raspberry, Strawberry',   'mid' => 'Peony, Datura',               'base' => 'White Musk, Patchouli, Ambroxan','lon' => 4, 'sil' => 3],
            'Dylan Blue'            => ['top' => 'Calabrian Bergamot, Grapefruit','mid' => 'Violet, Papyrus, Ambroxan','base' => 'Musk, Tonka Bean, Incense', 'lon' => 4, 'sil' => 4],
            'English Pear & Freesia'=> ['top' => 'King William Pear',       'mid' => 'Freesia, Rose',               'base' => 'Patchouli, Amber, Musk',      'lon' => 3, 'sil' => 2],
            'Replica By The Fireplace'=> ['top' => 'Clove, Pink Pepper, Orange','mid' => 'Chestnut, Guaiacwood',    'base' => 'Vanilla, Cashmeran, Peru Balsam','lon' => 4, 'sil' => 3],
            'Silver Mountain Water' => ['top' => 'Bergamot, Mandarin, Green Tea','mid' => 'Black Currant, Galbanum','base' => 'Musk, Sandalwood, Milk Notes','lon' => 3, 'sil' => 3],
            "Bal d'Afrique"         => ['top' => 'Bergamot, Lemon, Neroli', 'mid' => 'African Marigold, Jasmine, Cyclamen','base' => 'Vetiver, Moroccan Cedar, Amber','lon' => 4, 'sil' => 3],
            'Sì Passione'           => ['top' => 'Blackcurrant, Pink Pepper','mid' => 'Rose, Jasmine, Heliotrope',  'base' => 'Vanilla, Cedar, Ambroxan',    'lon' => 4, 'sil' => 3],
        ];

        foreach ($details as $name => $d) {
            Product::where('name', $name)->update([
                'top_notes' => $d['top'],
                'middle_notes' => $d['mid'],
                'base_notes' => $d['base'],
                'longevity' => $d['lon'],
                'sillage' => $d['sil'],
            ]);
        }
    }
}
