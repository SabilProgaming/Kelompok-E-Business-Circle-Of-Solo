<?php

namespace App\Services;

use App\Models\Product;

class PersonaExpertService
{
    /**
     * Persona definitions with their characteristics and matching scent profiles.
     */
    private array $personas = [
        'the_romantic' => [
            'name' => 'The Romantic',
            'title' => 'Si Pencinta Keindahan',
            'emoji' => '🌹',
            'color' => '#C45B7D',
            'description' => 'Anda adalah jiwa yang penuh kelembutan dan keindahan. Anda menghargai momen-momen intim, keanggunan, dan emosi yang mendalam. Parfum yang cocok untuk Anda adalah yang memancarkan kehangatan, sensualitas, dan keanggunan feminin.',
            'traits' => ['Sensitif', 'Penuh Kasih', 'Elegan', 'Emosional'],
            'ideal_occasions' => ['Kencan romantis', 'Anniversary dinner', 'Pesta malam'],
            'scent_affinity' => ['Rose', 'Jasmine', 'Vanilla', 'Floral', 'Musk', 'Amber'],
            'icon' => 'heart',
        ],
        'the_bold_leader' => [
            'name' => 'The Bold Leader',
            'title' => 'Si Pemimpin Berani',
            'emoji' => '👑',
            'color' => '#1A1A1A',
            'description' => 'Anda adalah sosok yang memancarkan kharisma dan kepercayaan diri. Anda memimpin dengan visi, mengambil keputusan tegas, dan selalu ingin menjadi yang terbaik. Parfum Anda harus setangguh ambisi Anda.',
            'traits' => ['Percaya Diri', 'Ambisius', 'Tegas', 'Kharismatik'],
            'ideal_occasions' => ['Meeting bisnis', 'Networking event', 'Presentasi penting'],
            'scent_affinity' => ['Oud', 'Leather', 'Woody', 'Spicy', 'Tobacco', 'Amber'],
            'icon' => 'crown',
        ],
        'the_free_spirit' => [
            'name' => 'The Free Spirit',
            'title' => 'Si Jiwa Bebas',
            'emoji' => '🌿',
            'color' => '#4A8C6F',
            'description' => 'Anda adalah pengembara yang mencintai kebebasan dan alam. Kreativitas mengalir dalam diri Anda, dan Anda tidak terikat oleh konvensi. Parfum Anda harus segar, natural, dan penuh petualangan.',
            'traits' => ['Kreatif', 'Spontan', 'Petualang', 'Otentik'],
            'ideal_occasions' => ['Weekend getaway', 'Hangout santai', 'Outdoor adventure'],
            'scent_affinity' => ['Fresh', 'Citrus', 'Aquatic', 'Bergamot', 'Vetiver', 'Sandalwood'],
            'icon' => 'leaf',
        ],
        'the_sophisticate' => [
            'name' => 'The Sophisticate',
            'title' => 'Si Pecinta Kemewahan',
            'emoji' => '✨',
            'color' => '#C5A059',
            'description' => 'Anda menghargai hal-hal terbaik dalam hidup — seni, fashion, kuliner, dan tentu saja parfum. Selera Anda refined dan Anda selalu mencari kualitas tertinggi. Parfum niche dan ekslusif adalah pilihan Anda.',
            'traits' => ['Refined', 'Kultured', 'Eksklusif', 'Detail-Oriented'],
            'ideal_occasions' => ['Gala dinner', 'Art exhibition', 'Fine dining'],
            'scent_affinity' => ['Oud', 'Patchouli', 'Sandalwood', 'Amber', 'Rose', 'Vanilla'],
            'icon' => 'gem',
        ],
        'the_energizer' => [
            'name' => 'The Energizer',
            'title' => 'Si Penuh Energi',
            'emoji' => '⚡',
            'color' => '#E07B3C',
            'description' => 'Anda adalah sumber energi positif di manapun Anda berada. Aktif, optimis, dan selalu siap beraksi. Parfum Anda harus mencerminkan semangat hidup yang tak pernah padam — segar, vibrant, dan penuh vitalitas.',
            'traits' => ['Energik', 'Optimis', 'Sporty', 'Fun'],
            'ideal_occasions' => ['Gym & olahraga', 'Beach day', 'Casual hangout'],
            'scent_affinity' => ['Citrus', 'Aquatic', 'Fresh', 'Fruity', 'Bergamot', 'Lavender'],
            'icon' => 'zap',
        ],
        'the_mysterious' => [
            'name' => 'The Mysterious',
            'title' => 'Si Penuh Misteri',
            'emoji' => '🌙',
            'color' => '#2C2C54',
            'description' => 'Anda adalah enigma yang memikat. Tenang di permukaan namun penuh kedalaman. Orang-orang tertarik pada aura misterius Anda. Parfum Anda harus dalam, kompleks, dan meninggalkan jejak tak terlupakan.',
            'traits' => ['Misterius', 'Introspektif', 'Mendalam', 'Memikat'],
            'ideal_occasions' => ['Night out', 'Private gathering', 'Concert malam'],
            'scent_affinity' => ['Oud', 'Tobacco', 'Leather', 'Spicy', 'Patchouli', 'Woody'],
            'icon' => 'moon',
        ],
    ];

    /**
     * The questionnaire structure.
     */
    public function getQuestions(): array
    {
        return [
            [
                'id' => 1,
                'question' => 'Bagaimana teman-teman biasanya mendeskripsikan Anda?',
                'subtitle' => 'Pilih yang paling mendekati kepribadian Anda',
                'options' => [
                    ['value' => 'A', 'text' => 'Hangat, penuh perhatian, dan romantis', 'icon' => '💕', 'persona_scores' => ['the_romantic' => 3, 'the_sophisticate' => 1]],
                    ['value' => 'B', 'text' => 'Tegas, percaya diri, dan inspiratif', 'icon' => '🔥', 'persona_scores' => ['the_bold_leader' => 3, 'the_mysterious' => 1]],
                    ['value' => 'C', 'text' => 'Bebas, kreatif, dan penuh kejutan', 'icon' => '🎨', 'persona_scores' => ['the_free_spirit' => 3, 'the_energizer' => 1]],
                    ['value' => 'D', 'text' => 'Elegan, selalu tampil sempurna', 'icon' => '👔', 'persona_scores' => ['the_sophisticate' => 3, 'the_romantic' => 1]],
                    ['value' => 'E', 'text' => 'Ceria, energik, selalu jadi mood booster', 'icon' => '🌟', 'persona_scores' => ['the_energizer' => 3, 'the_free_spirit' => 1]],
                    ['value' => 'F', 'text' => 'Tenang tapi memikat, penuh kedalaman', 'icon' => '🌑', 'persona_scores' => ['the_mysterious' => 3, 'the_bold_leader' => 1]],
                ],
            ],
            [
                'id' => 2,
                'question' => 'Apa aktivitas favorit Anda di akhir pekan?',
                'subtitle' => 'Weekend ideal menurut Anda',
                'options' => [
                    ['value' => 'A', 'text' => 'Candle-lit dinner atau menonton film romantis', 'icon' => '🕯️', 'persona_scores' => ['the_romantic' => 3, 'the_mysterious' => 1]],
                    ['value' => 'B', 'text' => 'Networking event atau merencanakan bisnis', 'icon' => '💼', 'persona_scores' => ['the_bold_leader' => 3, 'the_sophisticate' => 1]],
                    ['value' => 'C', 'text' => 'Hiking, traveling, atau eksplorasi tempat baru', 'icon' => '🏔️', 'persona_scores' => ['the_free_spirit' => 3, 'the_energizer' => 1]],
                    ['value' => 'D', 'text' => 'Mengunjungi galeri seni atau fine dining', 'icon' => '🎭', 'persona_scores' => ['the_sophisticate' => 3, 'the_romantic' => 1]],
                    ['value' => 'E', 'text' => 'Olahraga, beach party, atau hangout seru', 'icon' => '🏄', 'persona_scores' => ['the_energizer' => 3, 'the_free_spirit' => 1]],
                    ['value' => 'F', 'text' => 'Membaca buku, meditasi, atau menikmati kopi sendirian', 'icon' => '📚', 'persona_scores' => ['the_mysterious' => 3, 'the_sophisticate' => 1]],
                ],
            ],
            [
                'id' => 3,
                'question' => 'Jika Anda adalah sebuah musim, Anda adalah...',
                'subtitle' => 'Musim mana yang paling mewakili diri Anda?',
                'options' => [
                    ['value' => 'A', 'text' => 'Musim semi — penuh bunga dan harapan baru', 'icon' => '🌸', 'persona_scores' => ['the_romantic' => 2, 'the_free_spirit' => 2]],
                    ['value' => 'B', 'text' => 'Musim panas — terik, panas, dan penuh energi', 'icon' => '☀️', 'persona_scores' => ['the_energizer' => 3, 'the_bold_leader' => 1]],
                    ['value' => 'C', 'text' => 'Musim gugur — hangat, cozy, dan penuh warna', 'icon' => '🍂', 'persona_scores' => ['the_sophisticate' => 2, 'the_mysterious' => 2]],
                    ['value' => 'D', 'text' => 'Musim dingin — misterius, tenang, dan mendalam', 'icon' => '❄️', 'persona_scores' => ['the_mysterious' => 3, 'the_romantic' => 1]],
                ],
            ],
            [
                'id' => 4,
                'question' => 'Aroma apa yang langsung menarik perhatian Anda?',
                'subtitle' => 'Ikuti insting pertama Anda',
                'options' => [
                    ['value' => 'A', 'text' => 'Bunga segar yang baru mekar di taman', 'icon' => '🌺', 'persona_scores' => ['the_romantic' => 3, 'the_free_spirit' => 1]],
                    ['value' => 'B', 'text' => 'Kayu mahal dan kulit di ruang eksklusif', 'icon' => '🪵', 'persona_scores' => ['the_bold_leader' => 2, 'the_mysterious' => 2]],
                    ['value' => 'C', 'text' => 'Angin laut dan jeruk segar di pagi hari', 'icon' => '🍊', 'persona_scores' => ['the_energizer' => 2, 'the_free_spirit' => 2]],
                    ['value' => 'D', 'text' => 'Vanilla hangat dan rempah eksotis', 'icon' => '🧁', 'persona_scores' => ['the_sophisticate' => 2, 'the_romantic' => 2]],
                    ['value' => 'E', 'text' => 'Asap perapian dan tobacco di malam hari', 'icon' => '🔥', 'persona_scores' => ['the_mysterious' => 3, 'the_bold_leader' => 1]],
                ],
            ],
            [
                'id' => 5,
                'question' => 'Kapan Anda paling sering memakai parfum?',
                'subtitle' => 'Momen paling penting untuk tampil wangi',
                'options' => [
                    ['value' => 'A', 'text' => 'Saat kencan atau momen romantis', 'icon' => '💑', 'persona_scores' => ['the_romantic' => 3]],
                    ['value' => 'B', 'text' => 'Saat meeting atau acara profesional', 'icon' => '🏢', 'persona_scores' => ['the_bold_leader' => 2, 'the_sophisticate' => 1]],
                    ['value' => 'C', 'text' => 'Setiap hari, kapanpun dan dimanapun', 'icon' => '🌞', 'persona_scores' => ['the_energizer' => 2, 'the_free_spirit' => 1]],
                    ['value' => 'D', 'text' => 'Acara spesial dan formal saja', 'icon' => '🎩', 'persona_scores' => ['the_sophisticate' => 3]],
                    ['value' => 'E', 'text' => 'Malam hari — clubbing atau gathering', 'icon' => '🌃', 'persona_scores' => ['the_mysterious' => 3]],
                ],
            ],
            [
                'id' => 6,
                'question' => 'Apa yang paling penting buat Anda dalam sebuah parfum?',
                'subtitle' => 'Prioritas utama saat memilih parfum',
                'options' => [
                    ['value' => 'A', 'text' => 'Aroma yang membuat orang terpikat', 'icon' => '💫', 'persona_scores' => ['the_romantic' => 2, 'the_mysterious' => 2]],
                    ['value' => 'B', 'text' => 'Proyeksi kuat dan tahan lama seharian', 'icon' => '💪', 'persona_scores' => ['the_bold_leader' => 3, 'the_energizer' => 1]],
                    ['value' => 'C', 'text' => 'Unik dan tidak pasaran', 'icon' => '🦋', 'persona_scores' => ['the_free_spirit' => 2, 'the_sophisticate' => 2]],
                    ['value' => 'D', 'text' => 'Brand premium dan eksklusivitas', 'icon' => '💎', 'persona_scores' => ['the_sophisticate' => 3, 'the_bold_leader' => 1]],
                    ['value' => 'E', 'text' => 'Segar dan nyaman dipakai sehari-hari', 'icon' => '🌬️', 'persona_scores' => ['the_energizer' => 2, 'the_free_spirit' => 2]],
                ],
            ],
            [
                'id' => 7,
                'question' => 'Warna apa yang paling mewakili kepribadian Anda?',
                'subtitle' => 'Pilih warna yang paling Anda resonate',
                'options' => [
                    ['value' => 'A', 'text' => 'Merah muda — lembut dan romantis', 'icon' => '🩷', 'persona_scores' => ['the_romantic' => 3]],
                    ['value' => 'B', 'text' => 'Hitam — powerful dan elegan', 'icon' => '🖤', 'persona_scores' => ['the_bold_leader' => 2, 'the_mysterious' => 2]],
                    ['value' => 'C', 'text' => 'Hijau — natural dan grounded', 'icon' => '💚', 'persona_scores' => ['the_free_spirit' => 3]],
                    ['value' => 'D', 'text' => 'Emas — mewah dan berkelas', 'icon' => '💛', 'persona_scores' => ['the_sophisticate' => 3]],
                    ['value' => 'E', 'text' => 'Biru — segar dan vibrant', 'icon' => '💙', 'persona_scores' => ['the_energizer' => 3]],
                    ['value' => 'F', 'text' => 'Ungu — misterius dan dalam', 'icon' => '💜', 'persona_scores' => ['the_mysterious' => 3]],
                ],
            ],
        ];
    }

    /**
     * Calculate persona from answers.
     *
     * @param array $answers Array of selected option values indexed by question ID
     * @return array{persona: array, scores: array, products: \Illuminate\Support\Collection}
     */
    public function calculatePersona(array $answers): array
    {
        $questions = $this->getQuestions();
        $scores = array_fill_keys(array_keys($this->personas), 0);

        foreach ($answers as $questionId => $selectedValue) {
            $question = collect($questions)->firstWhere('id', (int) $questionId);
            if (!$question) continue;

            $option = collect($question['options'])->firstWhere('value', $selectedValue);
            if (!$option || !isset($option['persona_scores'])) continue;

            foreach ($option['persona_scores'] as $personaKey => $score) {
                $scores[$personaKey] = ($scores[$personaKey] ?? 0) + $score;
            }
        }

        // Get the winning persona
        arsort($scores);
        $winnerKey = array_key_first($scores);
        $persona = $this->personas[$winnerKey];
        $persona['key'] = $winnerKey;

        // Calculate percentage
        $totalScore = array_sum($scores);
        $persona['match_percentage'] = $totalScore > 0
            ? round(($scores[$winnerKey] / $totalScore) * 100)
            : 0;

        // Get recommended products based on scent affinity
        $products = $this->getRecommendedProducts($persona['scent_affinity']);

        return [
            'persona' => $persona,
            'scores' => $scores,
            'products' => $products,
        ];
    }

    /**
     * Get products that match the given scent affinities.
     */
    private function getRecommendedProducts(array $scentNames): \Illuminate\Support\Collection
    {
        return Product::query()
            ->with(['brand', 'category', 'scents', 'variants', 'images'])
            ->whereHas('scents', function ($query) use ($scentNames) {
                $query->whereIn('name', $scentNames);
            })
            ->get()
            ->sortByDesc(function ($product) use ($scentNames) {
                // Score: how many matching scents this product has
                return $product->scents->whereIn('name', $scentNames)->count();
            })
            ->take(6)
            ->values();
    }

    /**
     * Get all persona definitions.
     */
    public function getAllPersonas(): array
    {
        return $this->personas;
    }
}
