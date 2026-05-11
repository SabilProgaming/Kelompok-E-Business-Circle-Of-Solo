<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Scent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // === BRANDS ===
        $brands = [];
        $brandData = [
            ['name' => 'Mykonos', 'logo_url' => null],
            ['name' => 'HMNS', 'logo_url' => null],
            ['name' => 'Saff & Co', 'logo_url' => null],
            ['name' => 'Velixir', 'logo_url' => null],
        ];
        foreach ($brandData as $b) {
            $brands[$b['name']] = Brand::create($b);
        }

        // === CATEGORIES ===
        $categories = [];
        $categoryData = ['Eau de Parfum', 'Eau de Toilette', 'Cologne', 'Extrait de Parfum', 'Body Mist'];
        foreach ($categoryData as $c) {
            $categories[$c] = Category::create(['name' => $c]);
        }

        // === SCENTS ===
        $scents = [];
        $scentData = [
            'Woody', 'Floral', 'Citrus', 'Spicy', 'Musk',
            'Amber', 'Vanilla', 'Oud', 'Fresh', 'Aquatic',
            'Rose', 'Jasmine', 'Sandalwood', 'Bergamot', 'Patchouli',
            'Leather', 'Tobacco', 'Lavender', 'Vetiver', 'Fruity',
            'Powdery', 'Gourmand', 'Green', 'Coffee', 'Coconut', 'Aromatic', 'Earthy',
        ];
        foreach ($scentData as $s) {
            $scents[$s] = Scent::create(['name' => $s]);
        }

        // === PRODUCTS ===
        $productsData = [
            // HMNS
            [
                'name' => 'Alpha',
                'brand' => 'HMNS',
                'category' => 'Eau de Parfum',
                'description' => 'Fresh, calming, dan energizing. Mengandung esensi green tea yang memiliki efek terapeutik. Sering disebut sebagai "The O.G" dari HMNS dengan aroma yang fresh dan cocok dipakai sehari-hari untuk pria maupun wanita.',
                'scents' => ['Fresh', 'Citrus', 'Woody', 'Green'],
                'top_notes' => 'Grass, Citruses',
                'middle_notes' => 'Woodsy Notes, Green Tea',
                'base_notes' => 'Cedar, Vetiver',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '100ml', 'price' => 320000, 'stock' => 50],
                ],
                'image' => 'https://images.unsplash.com/photo-1594035910387-fbd1a485b12e?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Orgsm',
                'brand' => 'HMNS',
                'category' => 'Eau de Parfum',
                'description' => 'Parfum best-seller dengan aroma manis dan fruity-floral. Menggabungkan tiga bunga populer: Rose, Peony, dan Jasmine ke dalam satu botol. Memberikan kesan feminin, segar, dan diakhiri dengan sentuhan hangat vanilla.',
                'scents' => ['Floral', 'Fruity', 'Vanilla', 'Amber'],
                'top_notes' => 'Red Apple',
                'middle_notes' => 'Rose, Peony, Jasmine',
                'base_notes' => 'Amber, Vanilla Beans',
                'longevity' => 4,
                'sillage' => 4,
                'variants' => [
                    ['name' => '100ml', 'price' => 323000, 'stock' => 45],
                ],
                'image' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Farhampton',
                'brand' => 'HMNS',
                'category' => 'Extrait de Parfum',
                'description' => 'Aromatic Fougere Fruity yang memikat. Segar di awal dari bergamot, dilanjut nuansa aromatik elegan dari lavender, dan diakhiri dengan kesan earthy yang tahan lama. Cocok untuk semua gender.',
                'scents' => ['Aromatic', 'Fruity', 'Woody', 'Bergamot', 'Lavender'],
                'top_notes' => 'Bergamot, Ripe Fruit',
                'middle_notes' => 'Lavender, Orange Blossom',
                'base_notes' => 'Labdanum, Cedar Wood, Tonka Bean',
                'longevity' => 5,
                'sillage' => 4,
                'variants' => [
                    ['name' => '100ml', 'price' => 369000, 'stock' => 30],
                ],
                'image' => 'https://images.unsplash.com/photo-1595425964272-fc617fa2b4aa?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Essence of the Sun (EOS)',
                'brand' => 'HMNS',
                'category' => 'Eau de Parfum',
                'description' => 'Parfum Oriental Floral yang menangkap kehangatan matahari. Perpaduan unik antara rempah, bunga-bungaan tropis seperti Tiare Flower, dan sentuhan vanilla yang sensual.',
                'scents' => ['Floral', 'Spicy', 'Vanilla', 'Bergamot'],
                'top_notes' => 'Coriander, Bergamot, Pink Pepper',
                'middle_notes' => 'Jasmine Sambac, Tiaré Flower, Turkish Rose, Solar Accord',
                'base_notes' => 'Vanilla, Tonka Bean, Ambrette, Cedarwood',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '100ml', 'price' => 369000, 'stock' => 25],
                ],
                'image' => 'https://images.unsplash.com/photo-1547887538-e3a2f32cb1cc?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Unrosed',
                'brand' => 'HMNS',
                'category' => 'Eau de Parfum',
                'description' => 'Soliflore unik yang merangkai ilusi aroma mawar tanpa benar-benar menggunakan minyak mawar. Menggunakan Palmarosa untuk menciptakan karakter Floral Woody Musk yang earthy dan intim.',
                'scents' => ['Floral', 'Woody', 'Musk', 'Earthy'],
                'top_notes' => 'Floral Rose Accord',
                'middle_notes' => 'Earthy Accents',
                'base_notes' => 'Musky Undertones',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '100ml', 'price' => 374000, 'stock' => 20],
                ],
                'image' => 'https://images.unsplash.com/photo-1619994403073-2cec844b8c63?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'SORE Eterna',
                'brand' => 'HMNS',
                'category' => 'Eau de Parfum',
                'description' => 'Aroma senja yang menenangkan. Menggabungkan kesegaran citrus di awal, diakhiri dengan kelembutan bunga dan sentuhan powdery dari sandalwood serta musk.',
                'scents' => ['Floral', 'Fruity', 'Citrus', 'Musk'],
                'top_notes' => 'Petitgrain, Bergamot, Orange',
                'middle_notes' => 'Ylang-Ylang, Rose, Peach',
                'base_notes' => 'Sandalwood, Cedarwood, Musk',
                'longevity' => 4,
                'sillage' => 4,
                'variants' => [
                    ['name' => '100ml', 'price' => 385000, 'stock' => 15],
                ],
                'image' => 'https://images.unsplash.com/photo-1600612253971-422b1a834e03?auto=format&fit=crop&q=80&w=800',
            ],

            // Mykonos
            [
                'name' => 'Baby Love',
                'brand' => 'Mykonos',
                'category' => 'Eau de Parfum',
                'description' => 'Membawa kembali kenangan masa kecil namun dalam nuansa yang lebih dewasa dan mewah. Dominasi aroma powdery, floral dari violet dan rose, serta balutan white musk yang clean dan comforting.',
                'scents' => ['Powdery', 'Floral', 'Musk', 'Rose'],
                'top_notes' => 'Musk, Violet, Rose',
                'middle_notes' => 'Violet, Rose',
                'base_notes' => 'Musk, Violet',
                'longevity' => 3,
                'sillage' => 2,
                'variants' => [
                    ['name' => '50ml', 'price' => 150000, 'stock' => 50],
                    ['name' => '100ml', 'price' => 250000, 'stock' => 30],
                ],
                'image' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Vanilla Clouds',
                'brand' => 'Mykonos',
                'category' => 'Eau de Parfum',
                'description' => 'Aroma gourmand yang hangat, manis, dan sangat memeluk. Seperti berada di atas awan dengan sentuhan vanilla, marshmallow, heliotrope, dan caramel yang lezat.',
                'scents' => ['Vanilla', 'Gourmand', 'Floral', 'Musk'],
                'top_notes' => 'Vanilla, Heliotrope, White Floral Accord',
                'middle_notes' => 'Vanilla, Marshmallow, Iris',
                'base_notes' => 'Caramel, White Musk, Vanilla',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '50ml', 'price' => 165000, 'stock' => 40],
                    ['name' => '100ml', 'price' => 265000, 'stock' => 25],
                ],
                'image' => 'https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Black Opera',
                'brand' => 'Mykonos',
                'category' => 'Eau de Parfum',
                'description' => 'Sisi gelap yang menggoda dan misterius. Memadukan letupan kopi, licorice, patchouli, dengan kemewahan bunga putih dan vanilla. Cocok untuk acara malam dan kencan romantis.',
                'scents' => ['Coffee', 'Vanilla', 'Spicy', 'Floral'],
                'top_notes' => 'Pink Pepper, Orange Blossom, Vanilla',
                'middle_notes' => 'Licorice, Coffee, Jasmine, Almond',
                'base_notes' => 'Jasmine, Vanilla, Patchouli, Cashmere Wood',
                'longevity' => 4,
                'sillage' => 4,
                'variants' => [
                    ['name' => '50ml', 'price' => 175000, 'stock' => 35],
                    ['name' => '100ml', 'price' => 275000, 'stock' => 20],
                ],
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Utopia',
                'brand' => 'Mykonos',
                'category' => 'Extrait de Parfum',
                'description' => 'Ketenangan dalam wujud cair. Citrus dan teh putih yang mencerahkan pikiran, dilanjutkan dengan bunga-bunga elegan seperti iris, yang mengendap pada clean musk dan cedarwood.',
                'scents' => ['Citrus', 'Fresh', 'Floral', 'Woody'],
                'top_notes' => 'Calabrian Bergamot, White Tea, Fruits',
                'middle_notes' => 'Iris, Jasmine Sambac, Ylang-Ylang',
                'base_notes' => 'Cedarwood, White Musk',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '50ml', 'price' => 195000, 'stock' => 20],
                    ['name' => '100ml', 'price' => 295000, 'stock' => 15],
                ],
                'image' => 'https://images.unsplash.com/photo-1594913503975-830e23994e18?auto=format&fit=crop&q=80&w=800',
            ],

            // Saff & Co
            [
                'name' => 'S.O.T.B (Summer On The Beach)',
                'brand' => 'Saff & Co',
                'category' => 'Extrait de Parfum',
                'description' => 'Pelarian ke pantai tropis yang hangat dan memukau. Perpaduan sempurna antara galbanum segar, tuberose sensual, jasmine, dan dasar vanilla serta tonka bean yang memberikan kesan sun-kissed skin.',
                'scents' => ['Floral', 'Vanilla', 'Fresh', 'Citrus'],
                'top_notes' => 'Mandarin, Galbanum, Ylang',
                'middle_notes' => 'Tuberose, Jasmine, Orange Flower',
                'base_notes' => 'Tonka Bean, Vanilla, Musk',
                'longevity' => 5,
                'sillage' => 4,
                'variants' => [
                    ['name' => '30ml', 'price' => 220000, 'stock' => 40],
                ],
                'image' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Loui',
                'brand' => 'Saff & Co',
                'category' => 'Extrait de Parfum',
                'description' => 'Bagaikan berjalan di kebun yang rimbun sehabis hujan. Aroma hijau dari verbena dan daun violet bersatu dengan rose dan lily of the valley, diakhiri dengan sentuhan woody dan musk.',
                'scents' => ['Green', 'Floral', 'Fresh', 'Musk'],
                'top_notes' => 'Verbena, Violet Leaf, Aldehyde',
                'middle_notes' => 'Rose, Peony, Muguet',
                'base_notes' => 'Cedarwood, Musk',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '30ml', 'price' => 199000, 'stock' => 45],
                ],
                'image' => 'https://images.unsplash.com/photo-1587017539504-67cfbddac569?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Omnia',
                'brand' => 'Saff & Co',
                'category' => 'Extrait de Parfum',
                'description' => 'Kelembutan embun pagi dalam profil floral dan musky. Bunga-bunga mewah seperti hyacinth dan iris dibalut dengan pelukan hangat dari cashmere wood dan heliotrope.',
                'scents' => ['Floral', 'Woody', 'Musk', 'Powdery'],
                'top_notes' => 'Grapefruit, Green Accord',
                'middle_notes' => 'Rose, Hyacinth, Iris',
                'base_notes' => 'Heliotrope, Musk, Cashmere Wood',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '30ml', 'price' => 189000, 'stock' => 35],
                ],
                'image' => 'https://images.unsplash.com/photo-1612654945090-47db42553e04?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Xocolatl',
                'brand' => 'Saff & Co',
                'category' => 'Extrait de Parfum',
                'description' => 'Manjakan diri dalam kenikmatan gourmand yang unik. Perpaduan antara buah-buahan segar seperti mandarin, dengan sisi lezat dari maltol dan diakhiri kelembutan coconut serta sandalwood.',
                'scents' => ['Gourmand', 'Fruity', 'Coconut', 'Woody'],
                'top_notes' => 'Mandarin, Pear, Apple',
                'middle_notes' => 'Gardenia, Plumeria, Heliotrope, Maltol',
                'base_notes' => 'Coconut, Sandalwood, Musk',
                'longevity' => 5,
                'sillage' => 4,
                'variants' => [
                    ['name' => '30ml', 'price' => 249000, 'stock' => 20],
                ],
                'image' => 'https://images.unsplash.com/photo-1610461888750-10bfc601b874?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Ostara',
                'brand' => 'Saff & Co',
                'category' => 'Extrait de Parfum',
                'description' => 'Merayakan kebangkitan musim semi. Profil Fruity Chypre yang meledak dengan raspberry dan passionfruit di awal, kemudian menyatu dengan lily of the valley dan dasar patchouli serta amber yang elegan.',
                'scents' => ['Fruity', 'Floral', 'Patchouli', 'Amber'],
                'top_notes' => 'Raspberry, Pear, Passionfruit',
                'middle_notes' => 'Lily of the Valley, Cassis',
                'base_notes' => 'Heliotrope, Amber, Patchouli',
                'longevity' => 4,
                'sillage' => 4,
                'variants' => [
                    ['name' => '30ml', 'price' => 220000, 'stock' => 25],
                ],
                'image' => 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?auto=format&fit=crop&q=80&w=800',
            ],

            // Velixir
            [
                'name' => 'Ares',
                'brand' => 'Velixir',
                'category' => 'Extrait de Parfum',
                'description' => 'Terinspirasi dari dewa perang Yunani, Ares memancarkan aura keberanian. Karakter woody yang sangat kaya, dibuka dengan ledakan citrus segar lalu menjejak kuat dengan sandalwood, cedar, dan patchouli.',
                'scents' => ['Woody', 'Citrus', 'Patchouli', 'Musk'],
                'top_notes' => 'Grapefruit, Citrus, Mandarin Orange',
                'middle_notes' => 'Sandalwood, Cedarwood',
                'base_notes' => 'Amber, Patchouli, Musk',
                'longevity' => 5,
                'sillage' => 4,
                'variants' => [
                    ['name' => '35ml', 'price' => 149000, 'stock' => 30],
                    ['name' => '100ml', 'price' => 349000, 'stock' => 15],
                ],
                'image' => 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Adonis',
                'brand' => 'Velixir',
                'category' => 'Extrait de Parfum',
                'description' => 'Gourmand misterius yang memadukan kesejukan lavender dan mint dengan kehangatan madagascar vanilla, tobacco, serta madu. Aroma kontras yang melambangkan keindahan yang adiktif.',
                'scents' => ['Vanilla', 'Gourmand', 'Tobacco', 'Lavender'],
                'top_notes' => 'Lavender, Mint',
                'middle_notes' => 'Madagascar Vanilla, Benzoin',
                'base_notes' => 'Tonka Bean, Tobacco, Honey',
                'longevity' => 5,
                'sillage' => 5,
                'variants' => [
                    ['name' => '35ml', 'price' => 159000, 'stock' => 25],
                    ['name' => '100ml', 'price' => 379000, 'stock' => 10],
                ],
                'image' => 'https://images.unsplash.com/photo-1590736704728-f4730bb30770?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Apollo',
                'brand' => 'Velixir',
                'category' => 'Extrait de Parfum',
                'description' => 'Pesona sang dewa cahaya. Woody Aromatic yang tajam dengan paduan apel hijau, jahe, dan clary sage. Diakhiri dengan jejak elegan dari vetiver, cedar, dan olibanum.',
                'scents' => ['Woody', 'Aromatic', 'Fresh', 'Vetiver'],
                'top_notes' => 'Green Apple, Ginger, Bergamot',
                'middle_notes' => 'Clary Sage, Juniper Berries',
                'base_notes' => 'Amberwood, Cedar, Tonka Bean, Olibanum, Vetiver',
                'longevity' => 4,
                'sillage' => 4,
                'variants' => [
                    ['name' => '35ml', 'price' => 149000, 'stock' => 30],
                    ['name' => '100ml', 'price' => 359000, 'stock' => 15],
                ],
                'image' => 'https://images.unsplash.com/photo-1563170351-be82bc888aa4?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Icarus',
                'brand' => 'Velixir',
                'category' => 'Extrait de Parfum',
                'description' => 'Terbang tinggi menuju matahari. Woody Aromatic yang memberikan sensasi terbang dengan mandarin, orange blossom, dan georgywood, diikat kuat oleh ambrofix dan cedarwood.',
                'scents' => ['Woody', 'Citrus', 'Musk', 'Fresh'],
                'top_notes' => 'Pear, Calabrian Bergamot, Mandarin Orange',
                'middle_notes' => 'Mandarin Orange, Orange Blossom, Georgywood, Ginger',
                'base_notes' => 'Musk, Ambrofix, Akigalawood, Cedarwood',
                'longevity' => 4,
                'sillage' => 3,
                'variants' => [
                    ['name' => '35ml', 'price' => 159000, 'stock' => 20],
                    ['name' => '100ml', 'price' => 399000, 'stock' => 10],
                ],
                'image' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Aphrodite',
                'brand' => 'Velixir',
                'category' => 'Extrait de Parfum',
                'description' => 'Sang dewi cinta yang memukau. Floral Fruity dengan karakter manis dan sensual. Membuka dengan lychee dan bergamot, menuju hati peony dan mawar, lalu tenggelam dalam pelukan patchouli.',
                'scents' => ['Floral', 'Fruity', 'Rose', 'Patchouli'],
                'top_notes' => 'Bergamot, Litchi, Ginger',
                'middle_notes' => 'Peony, Rose, Cacao',
                'base_notes' => 'Patchouli',
                'longevity' => 4,
                'sillage' => 4,
                'variants' => [
                    ['name' => '35ml', 'price' => 169000, 'stock' => 25],
                    ['name' => '100ml', 'price' => 419000, 'stock' => 12],
                ],
                'image' => 'https://images.unsplash.com/photo-1608528577891-eb055944f2e7?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($productsData as $pData) {
            $product = Product::create([
                'name' => $pData['name'],
                'description' => $pData['description'],
                'brand_id' => $brands[$pData['brand']]->id,
                'category_id' => $categories[$pData['category']]->id,
                'top_notes' => $pData['top_notes'],
                'middle_notes' => $pData['middle_notes'],
                'base_notes' => $pData['base_notes'],
                'longevity' => $pData['longevity'],
                'sillage' => $pData['sillage'],
            ]);

            // Attach scents
            $scentIds = collect($pData['scents'])->map(fn($s) => $scents[$s]->id)->all();
            $product->scents()->attach($scentIds);

            // Create variants
            foreach ($pData['variants'] as $v) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $v['name'],
                    'price' => $v['price'],
                    'stock' => $v['stock'],
                ]);
            }

            // Create image
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $pData['image'],
            ]);
        }
    }
}
