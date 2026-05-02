# 📝 Log Perubahan — Website Sanctum

---

## 2026-05-01 — Bug Fixing Session: Dark Mode, CSS Scoping & Layout Fixes

### Bug yang Diperbaiki:

| Bug | Penyebab | Solusi |
|-----|----------|--------|
| **Dark Mode toggle tidak bekerja** | Lucide `createIcons()` menghancurkan Alpine.js `x-show` binding pada elemen `<i>` karena diganti menjadi `<svg>`. Juga `x-data` pada `<body>` tidak reliable di Alpine.js | Ganti ikon Lucide moon/sun dengan inline SVG, pindahkan `x-data` ke `<div>` wrapper |
| **Seluruh input form situs rusak** | CSS global `input[type="text"] { all: revert; }` me-*override* semua Tailwind class pada input di Checkout/Compare | Scope CSS menjadi `.auth-form input[...]` saja |
| **Dark mode: bg-white tetap putih** | Banyak view menggunakan `bg-white` hardcoded yang tidak berubah saat dark mode | Tambah CSS override `body.dark-theme .bg-white { background: #1c1c1c }` |
| **Dark mode: FOUC (Flash of light)** | Saat reload, halaman sempat tampil terang sebentar | Tambah inline `<script>` di `<head>` untuk apply class `dark-theme-preload` sebelum CSS render |
| **luxury-button kontras rendah di dark mode** | `text-white` menjadi tidak terlihat saat charcoal↔cream di-swap | Ubah `text-white` menjadi `text-luxury-cream` agar ikut CSS variable |
| **Navbar tidak ada akses My Orders** | User yang login tidak punya link ke dashboard pesanan | Tambah link "My Orders" di navbar untuk semua user yang login |

### File Diubah:
| File | Perubahan |
|------|-----------|
| `resources/views/layouts/app.blade.php` | Pindah `x-data` ke wrapper div, inline SVG toggle, tambah "My Orders" link |
| `resources/css/app.css` | Scope `.auth-form`, dark mode CSS overrides, smooth transitions |
| `tailwind.config.js` | CSS variable-based colors: `rgb(var(--color-X) / <alpha-value>)` |
| `resources/views/storefront/home.blade.php` | Ganti semua `bg-white` → `bg-luxury-cream` untuk dark mode |
| `resources/views/auth/login.blade.php` | Tambah class `.auth-form` pada form |
| `resources/views/auth/register.blade.php` | Tambah class `.auth-form` pada form |
| `app/Http/Controllers/CheckoutController.php` | Fix relasi Cart → CartItem yang salah |

---

## 2026-05-01 — 4 Killer Features: Checkout, Dashboard, Comparison & Dark Mode

### File Baru:
| File | Deskripsi |
|------|-----------|
| `database/migrations/2026_05_01_xxxxxx_add_checkout_fields_to_orders_table.php` | Menambah kolom checkout (alamat, nomor order, dll) pada tabel `orders` |
| `app/Http/Controllers/CheckoutController.php` | Controller checkout & pemrosesan invoice (pembuatan Order dan OrderItem dari Cart) |
| `app/Http/Controllers/UserDashboardController.php` | Controller dashboard pengguna untuk melihat riwayat order |
| `app/Http/Controllers/ComparisonController.php` | Controller fitur *side-by-side comparison* parfum |
| `resources/views/storefront/checkout/index.blade.php` | Halaman form checkout elegan (Shipping & Payment) |
| `resources/views/storefront/checkout/success.blade.php` | Halaman invoice/struk sukses |
| `resources/views/storefront/dashboard/index.blade.php` | Halaman User Dashboard (Order History & Profil) |
| `resources/views/storefront/comparison/index.blade.php` | Halaman Compare Fragrances (Scent Pyramid & Performance visualizer side-by-side) |

### File Diubah:
| File | Perubahan |
|------|-----------|
| `app/Models/Order.php` | Update *fillable* atribut untuk checkout fields baru |
| `routes/web.php` | Menambahkan rute `/checkout`, `/user/dashboard`, dan `/compare` |
| `resources/views/layouts/app.blade.php` | Menambah navigasi `Compare` dan Toggle *Dark Mode* di Header |
| `tailwind.config.js` | Modifikasi skema *colors* menggunakan CSS variables `<R> <G> <B>` untuk transisi mode terang/gelap dinamis |
| `resources/css/app.css` | Mendefinisikan CSS root variables dan `.dark-theme` colors |
| `resources/views/storefront/carts/index.blade.php` | Menyambungkan tombol "Proceed to Checkout" ke rute baru |

### Fitur:
- **Sistem Checkout & Invoice:** Flow e-commerce lengkap (Cart -> Form Alamat/Pembayaran -> Invoice Sukses). Data pesanan tersimpan rapi dan mengosongkan keranjang.
- **User Dashboard:** Member *Sanctum* dapat melihat riwayat pesanan (Order History), status paket, dan akses cepat ke Wishlist.
- **Comparison Tool:** Pengguna dapat membandingkan dua parfum secara sejajar (Harga, Scent Pyramid, Longevity, Sillage) dalam 1 layar.
- **Exclusive Dark Mode:** Tombol sakelar *(toggle)* cerdas berbasis Alpine.js di Navbar untuk mengubah tampilan web menjadi mewah versi malam (*Dark Charcoal Theme*) tanpa reload halaman (menyimpan preferensi di *localStorage*).

---

## 2026-05-01 — Konversi Rupiah & Detail Product Enchancement (Wishlist, Review, Scent Pyramid)

### File Baru:
| File | Deskripsi |
|------|-----------|
| `database/migrations/2026_05_01_xxxxxx_add_scent_details_to_products_table.php` | Menambah kolom `top_notes`, `middle_notes`, `base_notes`, `longevity`, `sillage` di tabel products |
| `database/migrations/2026_05_01_xxxxxx_create_wishlists_table.php` | Migrasi tabel wishlists dengan relasi user dan product |
| `database/migrations/2026_05_01_xxxxxx_create_reviews_table.php` | Migrasi tabel reviews dengan relasi user dan product, kolom rating dan comment |
| `app/Models/Wishlist.php` | Model Wishlist |
| `app/Models/Review.php` | Model Review |
| `database/seeders/ProductScentDetailsSeeder.php` | Seeder untuk mengisi data top, middle, base notes serta longevity dan sillage produk yang sudah ada |
| `app/Http/Controllers/WishlistController.php` | Controller untuk halaman wishlist dan fungsi toggle wishlist AJAX |
| `app/Http/Controllers/ReviewController.php` | Controller untuk menyimpan dan update review dari user |
| `resources/views/storefront/wishlist/index.blade.php` | Halaman frontend untuk menampilkan wishlist pengguna |

### File Diubah:
| File | Perubahan |
|------|-----------|
| `resources/views/storefront/home.blade.php` | Mengubah format harga USD menjadi Rupiah (Rp) |
| `resources/views/storefront/products/index.blade.php` | Mengubah format harga USD menjadi Rupiah (Rp) |
| `resources/views/storefront/carts/index.blade.php` | Mengubah format harga USD menjadi Rupiah (Rp) |
| `app/Models/Product.php` | Menambah relasi `wishlists()`, `reviews()`, fungsi `averageRating()`, dan field `fillable` baru |
| `routes/web.php` | Menambahkan route `/wishlist`, `/wishlist/toggle` (AJAX), dan `/reviews` (di dalam middleware auth) |
| `app/Http/Controllers/StorefrontController.php` | Memuat data reviews dan wishlist logic pada function `detail()` |
| `resources/views/storefront/products/show.blade.php` | Format harga Rupiah. Merombak total dengan menambahkan fitur: Wishlist button (AJAX), Scent Pyramid (Top, Middle, Base), Longevity & Sillage bars, Scent Family tags, dan Reviews & Ratings system (Bintang & Komentar) |

### Fitur:
- **Lokalisasi**: Konversi seluruh tampilan harga di Home, Catalog, Product Detail, dan Shopping Cart ke format Rupiah (`Rp X.XXX.XXX`).
- **Scent Architecture**: Visualisasi Scent Pyramid dan progress bar animatif untuk Longevity & Sillage pada detail produk.
- **Wishlist**: Pengguna yang login dapat menambah/menghapus produk dari wishlist secara realtime via AJAX tanpa reload halaman.
- **Review System**: Pengguna yang login dapat memberikan rating (1-5 bintang) dan komentar per produk.

---

## 2026-05-01 — Sistem Pakar Persona Parfum

### File Baru:
| File | Deskripsi |
|------|-----------|
| `app/Services/PersonaExpertService.php` | Service sistem pakar dengan 7 pertanyaan, 6 persona, scoring algorithm, dan rekomendasi produk berdasarkan scent affinity matching |
| `app/Http/Controllers/PersonaQuizController.php` | Controller untuk halaman quiz dan endpoint kalkulasi persona via AJAX |
| `resources/views/storefront/persona/index.blade.php` | View multi-step quiz: intro screen → 7 pertanyaan animasi → analyzing screen → halaman hasil dengan rekomendasi produk |

### File Diubah:
| File | Perubahan |
|------|-----------|
| `routes/web.php` | Tambah import `PersonaQuizController`, route `GET /persona-quiz` dan `POST /persona-quiz/calculate` |
| `resources/views/layouts/app.blade.php` | Tambah link navigasi "Persona Quiz" di navbar antara Collections dan About |

### Fitur:
- 7 pertanyaan tentang kepribadian, gaya hidup, preferensi aroma, dan warna
- 6 persona: The Romantic, The Bold Leader, The Free Spirit, The Sophisticate, The Energizer, The Mysterious
- Scoring algorithm berbasis bobot per jawaban
- Rekomendasi produk otomatis dari katalog berdasarkan scent affinity
- UI multi-step dengan animasi transisi, progress bar, dan analyzing screen

---

## 2026-05-01 — Seed 20 Produk Parfum

### File Baru:
| File | Deskripsi |
|------|-----------|
| `database/seeders/ProductSeeder.php` | Seeder 20 produk parfum premium dari 10 brand dengan 5 kategori, 20 scent notes, 52 variant, dan 20 foto Unsplash |

### Data yang Di-seed:
- 10 brand: Tom Ford, Dior, Chanel, YSL, Versace, Armani, Creed, Jo Malone, Maison Margiela, Byredo
- 5 kategori: EDP, EDT, Cologne, Extrait de Parfum, Body Mist
- 20 scent notes: Woody, Floral, Citrus, Spicy, Musk, Amber, Vanilla, Oud, dll
- 20 produk dengan deskripsi Bahasa Indonesia dan harga Rp 1.050.000 – Rp 7.850.000
- 52 variant (ukuran 30ml–200ml)
- 20 foto berbeda dari Unsplash

---

## 2026-04-30 — Sistem AI Rekomendasi Parfum (Groq API)

### File Baru:
| File | Deskripsi |
|------|-----------|
| `app/Services/AiRecommendationService.php` | Service yang membaca katalog produk dari database dan mengirimnya ke Groq API (Llama 3.3 70B) sebagai konteks untuk chatbot AI |
| `app/Http/Controllers/AiChatController.php` | Controller endpoint `POST /ai/chat` untuk menangani request chat |
| `resources/views/components/ai-chat-widget.blade.php` | Floating chat widget premium dengan welcome message, suggestion chips, typing indicator, product cards |

### File Diubah:
| File | Perubahan |
|------|-----------|
| `routes/web.php` | Tambah import `AiChatController`, route `POST /ai/chat` |
| `config/services.php` | Tambah konfigurasi `groq.api_key` dan `groq.model` |
| `resources/views/layouts/app.blade.php` | Include `@include('components.ai-chat-widget')` sebelum `</div>` penutup |
| `.env` | Tambah `GROQ_API_KEY=gsk_...` |

### Fitur:
- Chatbot AI menggunakan Groq API + Llama 3.3 70B
- Context-aware: membaca seluruh katalog (nama, brand, scent, harga, stok)
- Multi-turn conversation dengan memory riwayat chat
- Product cards clickable ke halaman detail
- Quick suggestion chips untuk memulai percakapan
- SSL fix dengan `withoutVerifying()` untuk development

---

## 2026-04-30 — Perbaikan Error & Setup Awal

### File Diubah:
| File | Perubahan |
|------|-----------|
| `package.json` | Hapus `@tailwindcss/vite` v4 yang konflik dengan Tailwind CSS v3 |

### Perbaikan:
- Buat database `website_db`, jalankan migrasi dan seed admin
- Fix konflik Tailwind v3 vs v4
- Fix konflik port 5173 Vite dev server
- Verifikasi halaman Home, Katalog, Login berjalan normal
