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
            ['name' => 'Tom Ford', 'logo_url' => null],
            ['name' => 'Dior', 'logo_url' => null],
            ['name' => 'Chanel', 'logo_url' => null],
            ['name' => 'Yves Saint Laurent', 'logo_url' => null],
            ['name' => 'Versace', 'logo_url' => null],
            ['name' => 'Giorgio Armani', 'logo_url' => null],
            ['name' => 'Creed', 'logo_url' => null],
            ['name' => 'Jo Malone', 'logo_url' => null],
            ['name' => 'Maison Margiela', 'logo_url' => null],
            ['name' => 'Byredo', 'logo_url' => null],
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
        ];
        foreach ($scentData as $s) {
            $scents[$s] = Scent::create(['name' => $s]);
        }

        // === PRODUCTS ===
        $productsData = [
            [
                'name' => 'Noir de Noir',
                'brand' => 'Tom Ford',
                'category' => 'Eau de Parfum',
                'description' => 'Sebuah mahakarya oriental yang memikat dengan paduan oud, rose, dan vanilla. Noir de Noir adalah definisi kemewahan dalam botol — gelap, misterius, dan sangat memukau. Cocok untuk malam spesial dan acara formal.',
                'scents' => ['Oud', 'Rose', 'Vanilla', 'Patchouli'],
                'variants' => [
                    ['name' => '50ml', 'price' => 3250000, 'stock' => 12],
                    ['name' => '100ml', 'price' => 4850000, 'stock' => 8],
                ],
                'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Sauvage Elixir',
                'brand' => 'Dior',
                'category' => 'Extrait de Parfum',
                'description' => 'Kekuatan maskulin yang tak tertandingi. Sauvage Elixir menggabungkan rempah-rempah oriental dengan kayu yang hangat, menciptakan aura kharismatik yang bertahan sepanjang hari. Parfum signature untuk pria modern.',
                'scents' => ['Spicy', 'Amber', 'Woody', 'Lavender'],
                'variants' => [
                    ['name' => '60ml', 'price' => 2750000, 'stock' => 15],
                    ['name' => '100ml', 'price' => 3950000, 'stock' => 10],
                ],
                'image' => 'https://images.unsplash.com/photo-1594035910387-fbd1a485b12e?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Coco Mademoiselle',
                'brand' => 'Chanel',
                'category' => 'Eau de Parfum',
                'description' => 'Feminin, elegan, dan penuh percaya diri. Coco Mademoiselle memadukan jeruk segar dengan sentuhan jasmine dan patchouli yang lembut. Parfum ikonik yang tidak pernah ketinggalan zaman.',
                'scents' => ['Citrus', 'Jasmine', 'Patchouli', 'Musk'],
                'variants' => [
                    ['name' => '35ml', 'price' => 2100000, 'stock' => 20],
                    ['name' => '50ml', 'price' => 2850000, 'stock' => 14],
                    ['name' => '100ml', 'price' => 4200000, 'stock' => 7],
                ],
                'image' => 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Black Opium',
                'brand' => 'Yves Saint Laurent',
                'category' => 'Eau de Parfum',
                'description' => 'Adiktif dan berani. Black Opium adalah parfum rock-and-roll dengan aroma kopi, vanilla, dan bunga putih. Sempurna untuk wanita yang ingin meninggalkan kesan tak terlupakan.',
                'scents' => ['Vanilla', 'Floral', 'Amber', 'Fruity'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1350000, 'stock' => 25],
                    ['name' => '50ml', 'price' => 1950000, 'stock' => 18],
                    ['name' => '90ml', 'price' => 2750000, 'stock' => 11],
                ],
                'image' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Eros',
                'brand' => 'Versace',
                'category' => 'Eau de Toilette',
                'description' => 'Terinspirasi dari dewa cinta Yunani. Eros meledak dengan kesegaran mint dan citrus, diimbangi oleh tonka bean dan vanilla yang sensual. Parfum yang membuat kepala menoleh.',
                'scents' => ['Fresh', 'Vanilla', 'Citrus', 'Woody'],
                'variants' => [
                    ['name' => '50ml', 'price' => 1250000, 'stock' => 30],
                    ['name' => '100ml', 'price' => 1750000, 'stock' => 22],
                    ['name' => '200ml', 'price' => 2450000, 'stock' => 5],
                ],
                'image' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Acqua di Giò Profondo',
                'brand' => 'Giorgio Armani',
                'category' => 'Eau de Parfum',
                'description' => 'Kedalaman lautan dalam sebotol parfum. Acqua di Giò Profondo menghadirkan kesegaran aquatic dengan sentuhan amber dan musk. Ideal untuk pria aktif yang menghargai kesederhanaan elegan.',
                'scents' => ['Aquatic', 'Bergamot', 'Amber', 'Musk'],
                'variants' => [
                    ['name' => '40ml', 'price' => 1450000, 'stock' => 16],
                    ['name' => '75ml', 'price' => 2150000, 'stock' => 12],
                    ['name' => '125ml', 'price' => 2850000, 'stock' => 6],
                ],
                'image' => 'https://images.unsplash.com/photo-1547887538-e3a2f32cb1cc?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Aventus',
                'brand' => 'Creed',
                'category' => 'Eau de Parfum',
                'description' => 'Legenda di dunia parfum niche. Aventus menggabungkan nanas dan birch smoke yang unik, menciptakan aroma kekuasaan dan kesuksesan. Dipakai oleh para pemimpin dan visioner dunia.',
                'scents' => ['Fruity', 'Woody', 'Musk', 'Bergamot'],
                'variants' => [
                    ['name' => '50ml', 'price' => 5250000, 'stock' => 5],
                    ['name' => '100ml', 'price' => 7850000, 'stock' => 3],
                ],
                'image' => 'https://images.unsplash.com/photo-1595425964272-fc617fa2b4aa?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Peony & Blush Suede',
                'brand' => 'Jo Malone',
                'category' => 'Cologne',
                'description' => 'Kelembutan yang mempesona. Paduan peony merah muda yang memukau dengan sentuhan suede yang lembut dan apple yang segar. Parfum yang memancarkan keanggunan feminin tanpa berlebihan.',
                'scents' => ['Floral', 'Fruity', 'Musk', 'Leather'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1150000, 'stock' => 20],
                    ['name' => '100ml', 'price' => 2450000, 'stock' => 10],
                ],
                'image' => 'https://images.unsplash.com/photo-1587017539504-67cfbddac569?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Replica Jazz Club',
                'brand' => 'Maison Margiela',
                'category' => 'Eau de Toilette',
                'description' => 'Perjalanan sensorik ke jazz club Brooklyn tahun 1920-an. Aroma tobacco, rum, dan kulit yang hangat membungkus Anda dalam atmosfer intim penuh cerita. Unik dan memorable.',
                'scents' => ['Tobacco', 'Leather', 'Vanilla', 'Spicy'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1050000, 'stock' => 18],
                    ['name' => '100ml', 'price' => 2250000, 'stock' => 9],
                ],
                'image' => 'https://images.unsplash.com/photo-1590736704728-f4730bb30770?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Gypsy Water',
                'brand' => 'Byredo',
                'category' => 'Eau de Parfum',
                'description' => 'Kebebasan dalam aroma. Gypsy Water merayakan jiwa pengembara dengan paduan pine needle, sandalwood, dan vanilla. Parfum unisex yang terasa seperti angin segar di hutan pinus.',
                'scents' => ['Woody', 'Vanilla', 'Sandalwood', 'Fresh'],
                'variants' => [
                    ['name' => '50ml', 'price' => 3450000, 'stock' => 7],
                    ['name' => '100ml', 'price' => 4950000, 'stock' => 4],
                ],
                'image' => 'https://images.unsplash.com/photo-1594913503975-830e23994e18?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Bleu de Chanel',
                'brand' => 'Chanel',
                'category' => 'Eau de Parfum',
                'description' => 'Maskulinitas modern yang timeless. Bleu de Chanel memadukan citrus segar, mint, dan sandalwood yang hangat. Parfum versatile yang cocok untuk segala occasion — dari kantor hingga dinner date.',
                'scents' => ['Citrus', 'Woody', 'Sandalwood', 'Fresh'],
                'variants' => [
                    ['name' => '50ml', 'price' => 2350000, 'stock' => 15],
                    ['name' => '100ml', 'price' => 3250000, 'stock' => 10],
                    ['name' => '150ml', 'price' => 4350000, 'stock' => 4],
                ],
                'image' => 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'La Vie Est Belle',
                'brand' => 'Giorgio Armani',
                'category' => 'Eau de Parfum',
                'description' => 'Kebahagiaan dalam setiap semprotan. La Vie Est Belle menggabungkan iris, jasmine, dan praline yang manis. Parfum yang memancarkan optimisme dan joie de vivre untuk wanita yang merayakan kehidupan.',
                'scents' => ['Floral', 'Vanilla', 'Jasmine', 'Fruity'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1450000, 'stock' => 22],
                    ['name' => '50ml', 'price' => 2050000, 'stock' => 16],
                    ['name' => '100ml', 'price' => 2950000, 'stock' => 8],
                ],
                'image' => 'https://images.unsplash.com/photo-1615634260167-c8cdede054de?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Oud Wood',
                'brand' => 'Tom Ford',
                'category' => 'Eau de Parfum',
                'description' => 'Kemewahan oud yang tidak berlebihan. Oud Wood menyajikan oud eksotis yang dihaluskan oleh rosewood dan cardamom. Elegan, sopan, dan sangat addictive — parfum signature sejati.',
                'scents' => ['Oud', 'Woody', 'Sandalwood', 'Spicy'],
                'variants' => [
                    ['name' => '50ml', 'price' => 4150000, 'stock' => 6],
                    ['name' => '100ml', 'price' => 6250000, 'stock' => 3],
                ],
                'image' => 'https://images.unsplash.com/photo-1600612253971-422b1a834e03?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Mon Paris',
                'brand' => 'Yves Saint Laurent',
                'category' => 'Eau de Parfum',
                'description' => 'Cinta yang menggairahkan di kota cahaya. Mon Paris mengalirkan raspberry, peony, dan white musk dalam harmoni yang romantis. Parfum untuk jiwa yang sedang jatuh cinta.',
                'scents' => ['Fruity', 'Floral', 'Musk', 'Vanilla'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1250000, 'stock' => 20],
                    ['name' => '50ml', 'price' => 1750000, 'stock' => 15],
                    ['name' => '90ml', 'price' => 2350000, 'stock' => 9],
                ],
                'image' => 'https://images.unsplash.com/photo-1619994403073-2cec844b8c63?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Dylan Blue',
                'brand' => 'Versace',
                'category' => 'Eau de Toilette',
                'description' => 'Mediterania dalam botol biru. Dylan Blue memadukan citrus Calabria, violet, dan incense untuk menciptakan aroma maskulin yang elegan. Fresh namun dalam — parfum harian yang sempurna.',
                'scents' => ['Citrus', 'Aquatic', 'Woody', 'Amber'],
                'variants' => [
                    ['name' => '50ml', 'price' => 1150000, 'stock' => 28],
                    ['name' => '100ml', 'price' => 1550000, 'stock' => 18],
                    ['name' => '200ml', 'price' => 2150000, 'stock' => 7],
                ],
                'image' => 'https://images.unsplash.com/photo-1528740561666-dc2479dc08ab?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'English Pear & Freesia',
                'brand' => 'Jo Malone',
                'category' => 'Cologne',
                'description' => 'Musim gugur Inggris yang mempesona. Kesegaran pir matang berpadu dengan freesia putih dan patchouli lembut. Parfum yang elegan untuk sehari-hari, cocok digunakan berlapis dengan koleksi Jo Malone lainnya.',
                'scents' => ['Fruity', 'Floral', 'Patchouli', 'Fresh'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1100000, 'stock' => 15],
                    ['name' => '100ml', 'price' => 2350000, 'stock' => 8],
                ],
                'image' => 'https://images.unsplash.com/photo-1612654945090-47db42553e04?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Replica By The Fireplace',
                'brand' => 'Maison Margiela',
                'category' => 'Eau de Toilette',
                'description' => 'Kehangatan perapian di malam bersalju. Aroma chestnut panggang, smoky wood, dan vanilla yang comforting. Parfum yang membuat Anda merasa aman dan nyaman di mana pun berada.',
                'scents' => ['Woody', 'Vanilla', 'Spicy', 'Amber'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1050000, 'stock' => 14],
                    ['name' => '100ml', 'price' => 2250000, 'stock' => 7],
                ],
                'image' => 'https://images.unsplash.com/photo-1610461888750-10bfc601b874?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Silver Mountain Water',
                'brand' => 'Creed',
                'category' => 'Eau de Parfum',
                'description' => 'Kesegaran puncak gunung bersalju. Silver Mountain Water memadukan teh hitam, bergamot, dan musk putih yang bersih. Parfum yang memancarkan kemewahan understated untuk jiwa petualang.',
                'scents' => ['Fresh', 'Bergamot', 'Musk', 'Citrus'],
                'variants' => [
                    ['name' => '50ml', 'price' => 4750000, 'stock' => 4],
                    ['name' => '100ml', 'price' => 7250000, 'stock' => 2],
                ],
                'image' => 'https://images.unsplash.com/photo-1563170351-be82bc888aa4?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Bal d\'Afrique',
                'brand' => 'Byredo',
                'category' => 'Eau de Parfum',
                'description' => 'Afrika yang penuh warna dan kehidupan. Bal d\'Afrique menari dengan bergamot, jasmine Afrika, dan vetiver. Parfum unisex yang merayakan kreativitas dan kebebasan ekspresi.',
                'scents' => ['Bergamot', 'Jasmine', 'Vetiver', 'Sandalwood'],
                'variants' => [
                    ['name' => '50ml', 'price' => 3550000, 'stock' => 6],
                    ['name' => '100ml', 'price' => 5050000, 'stock' => 3],
                ],
                'image' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Sì Passione',
                'brand' => 'Giorgio Armani',
                'category' => 'Eau de Parfum',
                'description' => 'Gairah dalam warna merah. Sì Passione menyatukan blackcurrant nectar, rose, dan vanilla bourbon. Parfum untuk wanita yang hidup dengan penuh semangat dan tidak takut menjadi pusat perhatian.',
                'scents' => ['Fruity', 'Rose', 'Vanilla', 'Patchouli'],
                'variants' => [
                    ['name' => '30ml', 'price' => 1350000, 'stock' => 19],
                    ['name' => '50ml', 'price' => 1850000, 'stock' => 13],
                    ['name' => '100ml', 'price' => 2650000, 'stock' => 6],
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
            ]);

            // Attach scents
            $scentIds = collect($pData['scents'])->map(fn ($s) => $scents[$s]->id)->all();
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
