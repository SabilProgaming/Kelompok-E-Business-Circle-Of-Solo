<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiRecommendationService
{
    private string $apiKey;
    private string $apiUrl;
    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key', '');
        $this->apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
        $this->model = config('services.groq.model', 'llama-3.3-70b-versatile');
    }

    /**
     * Build a comprehensive catalog context string from all available products.
     */
    public function buildCatalogContext(): string
    {
        $products = Product::query()
            ->with(['brand', 'category', 'scents', 'variants', 'images'])
            ->get();

        if ($products->isEmpty()) {
            return "Saat ini belum ada produk parfum yang tersedia di katalog Sanctum.";
        }

        $catalogLines = [];
        $catalogLines[] = "=== KATALOG PRODUK PARFUM SANCTUM ===\n";

        foreach ($products as $index => $product) {
            $num = $index + 1;
            $brandName = $product->brand->name ?? 'Unknown Brand';
            $categoryName = $product->category->name ?? 'Uncategorized';
            $scents = $product->scents->pluck('name')->join(', ') ?: 'Tidak disebutkan';
            $description = $product->description ?: 'Tidak ada deskripsi.';

            $catalogLines[] = "--- Produk #{$num} ---";
            $catalogLines[] = "Nama: {$product->name}";
            $catalogLines[] = "Brand: {$brandName}";
            $catalogLines[] = "Kategori: {$categoryName}";
            $catalogLines[] = "Aroma/Scent Notes: {$scents}";
            $catalogLines[] = "Deskripsi: {$description}";

            // Variants (sizes/prices/stock)
            if ($product->variants->isNotEmpty()) {
                $variantLines = [];
                foreach ($product->variants as $variant) {
                    $stock = $variant->stock ?? 0;
                    $availability = $stock > 0 ? "Tersedia (stok: {$stock})" : "Habis";
                    $variantLines[] = "  - {$variant->name}: Rp " . number_format($variant->price, 0, ',', '.') . " | {$availability}";
                }
                $catalogLines[] = "Ukuran & Harga:";
                $catalogLines = array_merge($catalogLines, $variantLines);
            }

            // Product URL
            $catalogLines[] = "Link Produk: /product/{$product->id}";
            $catalogLines[] = "";
        }

        return implode("\n", $catalogLines);
    }

    /**
     * Build the system instruction for the AI model.
     */
    private function buildSystemInstruction(string $catalogContext): string
    {
        return <<<PROMPT
Kamu adalah "Sanctum AI Concierge" — asisten parfum premium dan eksklusif dari toko parfum online Sanctum.

PERAN & KEPRIBADIAN:
- Kamu adalah konsultan parfum yang ahli, ramah, dan elegan
- Gaya bahasa: campuran Bahasa Indonesia yang sopan dengan sentuhan mewah
- Kamu menjawab dengan hangat tapi tetap profesional
- Gunakan emoji secukupnya untuk kesan friendly (🌸✨🌿💫)
- Jawab dengan ringkas dan informatif (maksimal 3-4 paragraf per respons)

TUGAS UTAMA:
1. Memberikan rekomendasi parfum berdasarkan preferensi pengguna (aroma, suasana, budget, gender, dll)
2. Menjelaskan detail produk: brand, scent notes, harga, ketersediaan stok
3. Membantu user memilih parfum yang cocok berdasarkan situasi (meeting, kencan, kasual, dll)
4. Hanya merekomendasikan produk yang ADA di katalog Sanctum dan masih tersedia stoknya
5. Jika tidak ada produk yang cocok, katakan dengan jujur dan sarankan alternatif terdekat

ATURAN PENTING:
- JANGAN pernah merekomendasikan parfum yang TIDAK ADA di katalog di bawah
- Jika stok habis, informasikan dan rekomendasikan alternatif yang tersedia
- Sertakan harga dalam format Rupiah
- Jika user bertanya di luar topik parfum, arahkan kembali ke topik parfum dengan sopan
- Jika katalog kosong, informasikan bahwa stok sedang diperbarui

KATALOG PRODUK:
{$catalogContext}
PROMPT;
    }

    /**
     * Send a chat message and get AI recommendation response.
     *
     * @param array $conversationHistory Array of ['role' => 'user'|'model', 'text' => '...']
     * @return array{success: bool, message: string, products?: array}
     */
    public function chat(array $conversationHistory): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'API key Groq belum dikonfigurasi. Silakan tambahkan GROQ_API_KEY di file .env',
            ];
        }

        $catalogContext = $this->buildCatalogContext();
        $systemInstruction = $this->buildSystemInstruction($catalogContext);

        // Build the messages array for Groq API (OpenAI-compatible format)
        $messages = [
            [
                'role' => 'system',
                'content' => $systemInstruction,
            ],
        ];

        foreach ($conversationHistory as $msg) {
            // Map 'model' role to 'assistant' for OpenAI-compatible API
            $role = $msg['role'] === 'model' ? 'assistant' : $msg['role'];
            $messages[] = [
                'role' => $role,
                'content' => $msg['text'],
            ];
        }

        try {
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => $messages,
                    'temperature' => 0.8,
                    'top_p' => 0.95,
                    'max_tokens' => 1024,
                    'stream' => false,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiText = $data['choices'][0]['message']['content'] ?? 'Maaf, saya tidak bisa memberikan respons saat ini.';

                // Extract product IDs mentioned in the response for product cards
                $mentionedProducts = $this->extractMentionedProducts($aiText);

                return [
                    'success' => true,
                    'message' => $aiText,
                    'products' => $mentionedProducts,
                ];
            }

            Log::error('Groq API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Maaf, layanan AI sedang tidak tersedia. Silakan coba lagi nanti. 🙏',
            ];
        } catch (\Exception $e) {
            Log::error('Groq API exception', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi. Silakan coba lagi. 🙏',
            ];
        }
    }

    /**
     * Extract product data for products mentioned in the AI response.
     */
    private function extractMentionedProducts(string $aiText): array
    {
        $products = Product::query()
            ->with(['brand', 'variants', 'images'])
            ->get();

        $mentioned = [];
        foreach ($products as $product) {
            if (stripos($aiText, $product->name) !== false) {
                $firstImage = $product->images->first();
                $imageUrl = null;
                if ($firstImage) {
                    $url = $firstImage->image_url;
                    $imageUrl = str_starts_with($url, 'http') || str_starts_with($url, '/')
                        ? $url
                        : asset('storage/' . ltrim($url, '/'));
                }

                $variant = $product->variants->first();
                $mentioned[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand->name ?? 'Unknown',
                    'price' => $variant ? 'Rp ' . number_format($variant->price, 0, ',', '.') : '-',
                    'image' => $imageUrl,
                    'url' => "/product/{$product->id}",
                    'in_stock' => $variant && ($variant->stock ?? 0) > 0,
                ];
            }
        }

        return $mentioned;
    }
}
