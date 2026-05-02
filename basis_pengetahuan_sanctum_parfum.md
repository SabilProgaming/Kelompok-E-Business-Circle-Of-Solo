

**BASIS PENGETAHUAN**

PROJECT

**SANCTUM PARFUM**

*Platform E-Commerce Parfum Berbasis AI & Sistem Pakar*

Disusun untuk Mata Kuliah Entrepreneurship Business

Berbasis Referensi Jurnal Ilmiah Terindeks Scopus & IEEE

**Tim Kelompok Sanctum Parfum**

2025

# **BAB I — PENDAHULUAN**

## **1.1 Latar Belakang Project**

Industri parfum global terus berkembang pesat, namun tantangan utama dalam penjualan parfum secara online adalah ketidakmampuan konsumen untuk mencium produk secara langsung sebelum membeli. Kondisi ini menciptakan hambatan signifikan dalam pengambilan keputusan pembelian, terutama di platform e-commerce.

Berdasarkan penelitian Hao et al. (2025) yang dipublikasikan di Springer Artificial Intelligence Review (Q1 Scopus), kecerdasan buatan (AI) telah merevolusi cara industri parfum memahami dan memprediksi preferensi konsumen. Penelitian tersebut menemukan bahwa evolusi AI dalam bidang olfaksi (penciuman) telah berkembang dari sistem pakar berbasis aturan (1990-an), kemudian Support Vector Machine dan decision tree (2000-an), hingga deep learning yang digunakan saat ini.

Di sisi lain, Chintalapudi et al. (2025) dalam Issues in Information Systems mencatat bahwa penjualan e-commerce global pada 2024 mencapai USD 1.192,6 miliar dengan pertumbuhan 8,1% dari tahun sebelumnya. Dalam konteks ini, integrasi AI chatbot dan sistem rekomendasi personal menjadi faktor kunci keunggulan kompetitif platform e-commerce.

Sanctum Parfum hadir sebagai respons terhadap tantangan ini. Terinspirasi dari filosofi 'Sanctum' dalam mitologi Latin yang berarti ruang suci penyimpan harta para dewa, platform ini dirancang bukan sekadar sebagai toko parfum biasa, melainkan sebagai perbendaharaan digital parfum terbaik dunia yang dilengkapi dengan teknologi AI untuk membantu konsumen menemukan wangi yang paling sesuai dengan kepribadian dan gaya hidup mereka.

## **1.2 Rumusan Masalah**

**Masalah utama yang diidentifikasi:**

| No | Masalah | Dampak | Solusi Sanctum Parfum |
| ----- | ----- | ----- | ----- |
| 1 | Konsumen tidak bisa mencium parfum secara langsung saat belanja online | Tingginya tingkat keraguan sebelum beli | Visualisasi Scent Wheel & Mood Board mendalam |
| 2 | Terlalu banyak pilihan parfum menyebabkan information overload | Keputusan pembelian menjadi sulit | Sistem Pakar & Quiz Persona berbasis AI |
| 3 | Informasi parfum di platform umum sangat minim | Konsumen tidak bisa membedakan parfum | Penjelasan lengkap: top/middle/base notes, longevity, sillage |
| 4 | Tidak ada platform yang merekomendasikan parfum berdasarkan kepribadian | Pembelian tidak sesuai ekspektasi | AI Chatbot \+ SPK dengan pendekatan persona |
| 5 | Sulit membandingkan parfum lintas brand dalam satu tempat | Konsumen harus buka banyak website | Fitur comparison & filter multi-kriteria |

## **1.3 Tujuan Project**

* Membangun platform e-commerce parfum yang menjual semua brand dalam satu tempat

* Mengembangkan sistem pakar berbasis AI untuk merekomendasikan parfum sesuai persona pengguna

* Menyediakan visualisasi mendalam (scent wheel, mood board) untuk menggantikan pengalaman mencium langsung

* Mengintegrasikan AI Chatbot sebagai asisten personal dalam pemilihan parfum

* Membangun pengalaman belanja yang personal, informatif, dan menyenangkan

## **1.4 Filosofi & Nama Brand**

| *"Sanctum Parfum terinspirasi dari konsep Sanctum dalam mitologi kuno — sebuah tempat suci di mana para dewa menyimpan koleksi harta dan benda paling berharga mereka. Kami mengadopsi filosofi ini sebagai fondasi platform kami, di mana Sanctum Parfum hadir sebagai perbendaharaan parfum terbaik dari seluruh dunia — dikurasi, dijaga kualitasnya, dan siap membantu setiap orang menemukan wangi yang paling cocok untuk mereka."* |
| :---- |

| Elemen Filosofi | Makna | Wujud di Platform |
| ----- | ----- | ----- |
| Sanctum \= Ruang Suci | Hanya yang terbaik yang masuk | Kurasi parfum dari brand terpilih |
| Penjaga Harta | Dijaga, dijelaskan, disajikan dengan hormat | Visualisasi & informasi lengkap tiap parfum |
| Tamu Istimewa | Setiap pengguna diperlakukan personal | Sistem rekomendasi berbasis persona unik |

# **BAB II — LANDASAN TEORI**

## **2.1 E-Commerce dan Sistem Rekomendasi**

E-commerce merupakan platform utama bisnis modern. Berdasarkan Chintalapudi et al. (2025), e-commerce memiliki delapan fitur teknologi unik yang membedakannya dari ritel tradisional:

| Fitur E-Commerce | Definisi | Implementasi di Sanctum Parfum |
| ----- | ----- | ----- |
| Ubiquity | Tersedia kapan saja, di mana saja | Website responsif, dapat diakses 24/7 |
| Global Reach | Menjangkau konsumen lintas negara | Katalog parfum dari brand internasional |
| Universal Standards | Standar teknologi yang seragam | Laravel framework, standar REST API |
| Interactivity | Komunikasi dua arah real-time | AI Chatbot & sistem review interaktif |
| Personalization | Pengalaman disesuaikan preferensi | Quiz persona & rekomendasi AI personal |
| Information Richness | Kompleksitas dan kedalaman informasi | Scent wheel, mood board, detail notes parfum |
| Information Density | Kemampuan menyimpan & analisis data besar | Database parfum lengkap, filter multi-kriteria |
| Social Technology | Interaksi & kolaborasi sosial | Review, rating, wishlist komunitas |

Liu & Ding (2022) dalam Frontiers in Psychology (Q2 Scopus) memperkenalkan Syntactic Data Inquiring Scheme (SDIS) — sistem rekomendasi berbasis analisis emosi semantik dari komentar pengguna. Penelitian ini menemukan bahwa dengan meningkatnya frekuensi sesi, sistem SDIS mampu meningkatkan akurasi rekomendasi sebesar 15,1% dan rasio analisis data sebesar 9,41%.

## **2.2 Sistem Pakar (Expert System) dalam Parfum**

Sistem Pakar adalah program komputer yang meniru kemampuan pengambilan keputusan seorang pakar manusia dalam bidang tertentu. Dalam konteks parfum, sistem pakar sangat dibutuhkan karena jumlah perfumer (ahli parfum) di seluruh dunia hanya sekitar 5.000 orang — jumlah yang sangat terbatas untuk melayani jutaan konsumen global.

| *Hanafizdeh et al. (2010) dalam Expert Systems with Applications (Q1 Scopus, Elsevier) mengembangkan expert system untuk menilai kepuasan konsumen terhadap aroma parfum menggunakan Fuzzy Delphi Method dan Backpropagation Neural Network. Dengan 2.303 data training dan 583 data testing, sistem mencapai classification rate 70,33% — membuktikan bahwa sistem pakar mampu menggantikan peran perfumer manusia secara digital.* |
| :---- |

### **2.2.1 Arsitektur Sistem Pakar**

* Knowledge Base: Basis pengetahuan berisi fakta dan aturan tentang karakteristik parfum (top/middle/base notes, famili wangi, longevity, sillage)

* Inference Engine: Mesin inferensi yang memproses input pengguna dan mencocokan dengan knowledge base menggunakan metode forward chaining atau backward chaining

* User Interface: Antarmuka berupa quiz / chatbot yang mengumpulkan preferensi dan persona pengguna

* Explanation Facility: Penjelasan mengapa parfum tertentu direkomendasikan untuk pengguna

### **2.2.2 Persona Pengguna sebagai Input SPK**

| Persona | Karakteristik | Aktivitas | Rekomendasi Wangi |
| ----- | ----- | ----- | ----- |
| The Professional | Terorganisir, formal, ambisius | Kerja kantoran, meeting klien | Woody, Aquatic, Clean, Leather |
| The Romantic | Hangat, ekspresif, intim | Date, acara spesial, dinner | Floral, Oriental, Musk, Vanilla |
| The Adventurer | Aktif, outdoor, bebas | Olahraga, travelling, hiking | Fresh, Citrus, Aquatic, Fougere |
| The Artist | Kreatif, unik, eksentrik | Studio, galeri, gathering seni | Niche, Gourmand, Smoky, Incense |
| The Minimalist | Simple, efisien, subtle | WFH, casual everyday | White Musk, Powdery, Light Floral |
| The Socialite | Energik, bold, percaya diri | Party, clubbing, hangout | Spicy, Sweet, Intense, Amber |

## **2.3 AI Chatbot dalam E-Commerce**

Caldarini et al. (2022) dalam Information — MDPI (Q2 Scopus) mendefinisikan chatbot sebagai sistem dialog komputer yang meniru percakapan manusia dalam bentuk naturalnya. Chatbot memanfaatkan dua domain AI utama: Natural Language Processing (NLP) dan Machine Learning (ML).

### **2.3.1 Keunggulan Chatbot dibandingkan FAQ Statis**

| Aspek | FAQ Statis | AI Chatbot |
| ----- | ----- | ----- |
| Interaktivitas | Satu arah (pengguna baca) | Dua arah (dialog natural) |
| Personalisasi | Tidak ada | Disesuaikan profil & histori pengguna |
| Kapasitas | Satu pengguna sekaligus | Ribuan pengguna serentak |
| Pembaruan | Manual oleh admin | Belajar dari interaksi (ML) |
| Konteks | Tidak memahami konteks | Memahami konteks percakapan |
| Rekomendasi | Tidak bisa | Aktif merekomendasikan produk |

Chintalapudi et al. (2025) dalam studinya menggunakan PRISMA framework menemukan bahwa AI chatbot dalam e-commerce terutama meningkatkan tiga fitur: interactivity (dialog real-time), information richness (respons kontekstual kaya makna), dan personalization (rekomendasi berdasarkan preferensi individual). Teknologi kunci yang digunakan meliputi NLP, transfer learning, knowledge graph, dan domain ontology.

## **2.4 UI/UX Design untuk Konversi E-Commerce**

Husna & Wibowo (2024) dalam International Journal of Economics Development Research melakukan Systematic Literature Review terhadap 6 paper dan menemukan lima elemen UX yang paling signifikan mempengaruhi conversion rate e-commerce:

| Elemen UX | Definisi | Dampak terhadap Konversi | Implementasi di Sanctum |
| ----- | ----- | ----- | ----- |
| Navigasi Intuitif | Kemudahan menemukan produk & fitur | Mengurangi bounce rate, meningkatkan engagement | Menu terstruktur: Katalog, Quiz, Chatbot, Wishlist |
| Loading Speed | Kecepatan loading halaman \< 3 detik | Setiap 1 detik delay \= 7% penurunan konversi | Optimasi gambar, lazy loading, CDN |
| Responsive Design | Tampilan optimal di semua perangkat | 45% pengguna expect tampilan cross-device | Mobile-first design dengan Laravel Blade \+ Bootstrap |
| Content Personalization | Konten disesuaikan preferensi pengguna | Meningkatkan engagement & repeat purchase | Rekomendasi personal berdasarkan riwayat & persona |
| Ease of Checkout | Proses beli yang mudah & aman | Mengurangi cart abandonment rate | Checkout 3 langkah: Cart \> Payment \> Confirmation |

## **2.5 Sistem Rekomendasi Berbasis Quiz Persona**

Lutan & Badica (2023) dalam Springer ICCCI (Scopus Indexed) memperkenalkan pendekatan quiz-based perfume recommender system yang menggunakan data sosial dari platform Fragrantica. Metode ini mengumpulkan preferensi pengguna melalui antarmuka quiz, kemudian mencocokkan dengan dataset parfum untuk menghasilkan rekomendasi top-N yang dipersonalisasi.

| *Pendekatan ini relevan langsung dengan fitur Quiz Persona Sanctum Parfum. Dataset dari Fragrantica — ensiklopedia parfum online terbesar — dapat menjadi basis data pengetahuan tentang karakteristik parfum, famili wangi, dan preferensi komunitas, sehingga sistem rekomendasi memiliki fondasi data yang kuat dan tervalidasi.* |
| :---- |

# **BAB III — BUSINESS MODEL CANVAS (BMC)**

## **3.1 Business Model Canvas Sanctum Parfum**

| Blok BMC | Isi |
| ----- | ----- |
| 1\. Customer Segments | Mahasiswa & Fresh Graduate (18-25 th, budget terbatas, suka eksplorasi)Profesional Muda (25-35 th, cari parfum yang representatif)Kolektor Parfum (semua usia, cari niche & rare fragrance)Gift Buyer (mencari parfum sebagai hadiah) |
| 2\. Value Propositions | Satu platform untuk semua brand parfumVisualisasi mendalam (scent wheel, mood board, notes)Rekomendasi personal via AI & Sistem PakarPengalaman discovery wangi yang belum ada di platform lain |
| 3\. Channels | Website Sanctum Parfum (Laravel)Media sosial (Instagram, TikTok)WhatsApp Business untuk follow-upEmail marketing untuk repeat buyer |
| 4\. Customer Relationships | AI Chatbot sebagai asisten personal 24/7Quiz persona untuk onboarding pengguna baruSistem review & community ratingLoyalty program untuk repeat buyer |
| 5\. Revenue Streams | Penjualan langsung parfum (margin produk)Fitur premium (extended recommendation history)Komisi brand partner (featured placement)Affiliate program dengan influencer parfum |
| 6\. Key Resources | Platform Laravel (website)Database parfum multi-brandAlgoritma AI & SPKKonten visual (foto, mood board) |
| 7\. Key Activities | Pengembangan & maintenance websiteKurasi & update katalog parfumPengembangan algoritma rekomendasiMarketing konten & community building |
| 8\. Key Partners | Brand parfum lokal & internasionalSupplier & distributor parfumContent creator & beauty influencerJasa pengiriman (JNE, J\&T, SiCepat) |
| 9\. Cost Structure | Hosting & infrastruktur serverBiaya pengembangan (development cost)Marketing & iklan digitalOperasional (packaging, pengiriman) |

## **3.2 Value Proposition Canvas**

### **3.2.1 Customer Profile**

* **Customer Jobs**: Menemukan parfum yang cocok dengan kepribadian tanpa bisa menciumnya langsung

* **Customer Pains**: Bingung memilih dari ratusan pilihan, informasi minim, takut salah beli, tidak tahu bedanya parfum A dan B

* **Customer Gains**: Bisa menemukan parfum yang benar-benar 'milik' mereka, merasa dipahami, pembelian yang memuaskan

### **3.2.2 Value Map**

* **Pain Relievers**: Quiz persona \+ AI mengurangi kebingungan, visualisasi scent wheel menjelaskan karakter parfum tanpa perlu mencium

* **Gain Creators**: Pengalaman discovery personal, rekomendasi akurat, penjelasan mendalam yang membuat konsumen merasa menjadi ahli parfum

* **Products & Services**: Katalog multi-brand, quiz persona, AI chatbot, scent wheel, mood board, comparison tool, wishlist, review system

# **BAB IV — METODOLOGI PENGEMBANGAN (SDLC AGILE)**

## **4.1 Framework Pengembangan**

Project Sanctum Parfum menggunakan metodologi Agile-Scrum dengan 5 Sprint dalam 5 minggu. Pendekatan ini dipilih karena tim kecil (3 orang) membutuhkan fleksibilitas tinggi, kemampuan adaptasi cepat, dan fokus pada deliverable nyata setiap minggu.

| Fase | Minggu | Deliverable Utama | PIC |
| ----- | ----- | ----- | ----- |
| Fase 1: Business & Planning | Minggu 1 | BMC, Identifikasi Masalah, Use Case (Garis Besar), KPI, Slide Presentasi | Ketua \+ Tim |
| Fase 2: Design & Architecture | Minggu 2 | ERD, Wireframe, Mockup UI, Setup Laravel, Database Migration | Anggota 1 (Dev) \+ Anggota 2 (Design) |
| Fase 3: Sprint 1 — Core Feature | Minggu 3 | Auth (Login/Register), Katalog Produk, Detail Parfum \+ Scent Wheel, Filter & Search | Tim Full |
| Fase 4: Sprint 2 — AI Features | Minggu 4 | Quiz Persona, SPK Rekomendasi, AI Chatbot, Cart & Checkout, Dashboard Admin | Tim Full |
| Fase 5: Testing & Launch | Minggu 5 | UAT, Bug Fixing, Deployment, Dokumentasi, Presentasi Akhir | Tim Full |

## **4.2 Sprint Definition**

### **Sprint 1 — Core E-Commerce (Minggu 3\)**

* Authentication: Register, Login, Logout, Edit Profil

* Katalog Parfum: Tampil semua produk, pagination

* Filter & Search: Brand, harga, gender, scent family, occasion

* Detail Parfum: Informasi lengkap \+ Scent Wheel interaktif \+ Mood Board

* Wishlist: Tambah & kelola wishlist

### **Sprint 2 — AI & Transaksi (Minggu 4\)**

* Quiz Persona: Form multi-step, kalkulasi hasil persona

* SPK Rekomendasi: Decision tree berdasarkan persona, output top-3 parfum

* AI Chatbot: Integrasi API, dialog rekomendasi natural

* Keranjang & Checkout: Cart management, proses order

* Dashboard Admin: CRUD produk, kelola order, laporan penjualan

## **4.3 KPI (Key Performance Indicator)**

### **4.3.1 KPI Bisnis**

| KPI | Target Awal | Cara Mengukur |
| ----- | ----- | ----- |
| Jumlah produk terdaftar | Min. 20 parfum | Hitung di database |
| Conversion rate | Min. 2-3% | (Jumlah order / jumlah pengunjung) x 100% |
| Jumlah transaksi | Min. 10 order/bulan | Dashboard admin |
| Repeat buyer rate | Min. 20% | User yang order lebih dari 1x |
| Rating kepuasan user | Min. 4/5 | Form feedback setelah transaksi |
| Quiz completion rate | Min. 60% | User yang menyelesaikan quiz vs yang mulai |

### **4.3.2 KPI Teknis**

| KPI | Target | Cara Mengukur |
| ----- | ----- | ----- |
| Page load speed | \< 3 detik | Google PageSpeed Insights |
| Uptime website | 99%+ | Monitoring tools |
| Bug setelah launch | 0 critical bug | UAT testing report |
| Mobile responsiveness | Semua halaman optimal | Manual test di berbagai device |
| Quiz accuracy | Rekomendasi relevan | User feedback rating per rekomendasi |

### **4.3.3 KPI Per Sprint**

| Sprint | KPI | Kondisi Lulus |
| ----- | ----- | ----- |
| Sprint 1 | Auth selesai 100% | Login, Register, Logout berfungsi tanpa error |
| Sprint 1 | Katalog tampil semua produk | Filter & search menghasilkan hasil akurat |
| Sprint 2 | Checkout end-to-end berhasil | Order tersimpan di database & admin menerima notifikasi |
| Sprint 2 | Quiz menghasilkan rekomendasi | Output persona \+ 3 parfum rekomendasi tampil dengan benar |
| Sprint 2 | Chatbot merespons relevan | Min. 80% respons dianggap relevan oleh penguji |
| Sprint 2 (Admin) | Admin CRUD produk berhasil | Tambah, edit, hapus produk tercermin di katalog |

# **BAB V — USE CASE DIAGRAM**

## **5.1 Actor**

| Actor | Deskripsi | Hak Akses |
| ----- | ----- | ----- |
| Guest | Pengunjung yang belum login | Lihat katalog, filter, detail parfum, quiz persona (tanpa simpan), chatbot |
| User (Member) | Pembeli yang sudah registrasi & login | Semua fitur Guest \+ Cart, Checkout, Wishlist, Review, Riwayat Order, Profil |
| Admin | Pengelola toko | Login Admin Panel, CRUD Produk, Kelola Order, Kelola User, Laporan |
| AI System | Sistem rekomendasi otomatis | Menerima input quiz/chatbot → output rekomendasi parfum |

## **5.2 Use Case per Modul**

### **Modul 1: Authentication**

| ID | Use Case | Actor | Deskripsi |
| ----- | ----- | ----- | ----- |
| UC-01 | Register Akun | Guest | Pendaftaran akun baru dengan nama, email, password |
| UC-02 | Login | Guest | Masuk ke sistem menggunakan email & password |
| UC-03 | Logout | User | Keluar dari sistem |
| UC-04 | Edit Profil | User | Ubah nama, foto, preferensi wangi, persona |
| UC-05 | Ubah Password | User | Ganti password akun |

### **Modul 2: Katalog & Produk**

| ID | Use Case | Actor | Deskripsi |
| ----- | ----- | ----- | ----- |
| UC-06 | Lihat Katalog Parfum | Guest, User | Menampilkan semua produk parfum dengan pagination |
| UC-07 | Filter Parfum | Guest, User | Filter berdasarkan brand, harga, gender, scent family, occasion, konsentrasi |
| UC-08 | Cari Parfum | Guest, User | Pencarian berdasarkan nama, brand, atau scent notes |
| UC-09 | Lihat Detail Parfum | Guest, User | Halaman detail: deskripsi, top/middle/base notes, longevity, sillage, mood board |
| UC-10 | Lihat Scent Wheel | Guest, User | Visualisasi interaktif keluarga wangi dan turunannya |
| UC-11 | Bandingkan Parfum | Guest, User | Perbandingan side-by-side maksimal 2 parfum |

### **Modul 3: Rekomendasi & AI**

| ID | Use Case | Actor | Deskripsi |
| ----- | ----- | ----- | ----- |
| UC-12 | Isi Quiz Persona | Guest, User | Menjawab pertanyaan tentang kepribadian, aktivitas, budget, preferensi wangi |
| UC-13 | Lihat Hasil Persona | Guest, User | Menampilkan tipe persona pengguna dan penjelasannya |
| UC-14 | Terima Rekomendasi dari Quiz | Guest, User | Top-3 parfum yang direkomendasikan berdasarkan persona |
| UC-15 | Chat dengan AI Chatbot | Guest, User | Dialog natural untuk tanya jawab seputar parfum |
| UC-16 | Terima Rekomendasi dari Chatbot | AI System | Output rekomendasi parfum dari chatbot berdasarkan dialog |

### **Modul 4: Transaksi**

| ID | Use Case | Actor | Deskripsi |
| ----- | ----- | ----- | ----- |
| UC-17 | Tambah ke Keranjang | User | Menambahkan parfum ke shopping cart |
| UC-18 | Edit Keranjang | User | Ubah jumlah item atau hapus item dari cart |
| UC-19 | Checkout | User | Proses pemesanan: pilih alamat, pilih pengiriman |
| UC-20 | Pilih Metode Pembayaran | User | Transfer bank, e-wallet, atau COD |
| UC-21 | Konfirmasi Pembayaran | User | Upload bukti pembayaran |
| UC-22 | Lihat Riwayat Order | User | Daftar semua transaksi beserta status |

### **Modul 5: Review & Wishlist**

| ID | Use Case | Actor | Deskripsi |
| ----- | ----- | ----- | ----- |
| UC-23 | Beri Rating & Review | User | Penilaian bintang dan ulasan teks untuk parfum yang sudah dibeli |
| UC-24 | Lihat Review | Guest, User | Membaca review dari pengguna lain |
| UC-25 | Tambah ke Wishlist | User | Menyimpan parfum ke daftar keinginan |
| UC-26 | Kelola Wishlist | User | Hapus atau pindahkan wishlist ke cart |

### **Modul 6: Admin Panel**

| ID | Use Case | Actor | Deskripsi |
| ----- | ----- | ----- | ----- |
| UC-27 | Login Admin | Admin | Autentikasi ke panel admin |
| UC-28 | Tambah Produk | Admin | Input data parfum baru: nama, brand, notes, harga, stok, foto |
| UC-29 | Edit Produk | Admin | Memperbarui informasi produk yang sudah ada |
| UC-30 | Hapus Produk | Admin | Menghapus produk dari katalog |
| UC-31 | Kelola Kategori & Brand | Admin | CRUD untuk kategori dan brand parfum |
| UC-32 | Lihat & Kelola Order | Admin | Melihat daftar order, update status pengiriman |
| UC-33 | Konfirmasi Pembayaran | Admin | Verifikasi bukti pembayaran dari user |
| UC-34 | Kelola User | Admin | Melihat dan menonaktifkan akun user jika diperlukan |
| UC-35 | Laporan Penjualan | Admin | Dashboard statistik penjualan, produk terlaris, pendapatan |

# **BAB VI — ARSITEKTUR TEKNIS**

## **6.1 Technology Stack**

| Layer | Teknologi | Keterangan |
| ----- | ----- | ----- |
| Backend Framework | Laravel (PHP) | MVC framework, routing, ORM Eloquent |
| Database | MySQL | Relational database untuk produk, user, transaksi |
| Frontend | Blade Template \+ Bootstrap 5 | Templating engine Laravel \+ CSS framework responsif |
| AI Chatbot | OpenAI API / Gemini API | Integrasi LLM untuk percakapan natural |
| Authentication | Laravel Sanctum / Breeze | Token-based auth untuk API, session auth untuk web |
| Payment | Midtrans / Xendit | Payment gateway Indonesia |
| Storage | Local Storage / S3 | Penyimpanan foto produk |
| Visualization | Chart.js / D3.js | Scent wheel interaktif, grafik admin |

## **6.2 Database Schema (ERD — Tabel Utama)**

### **Tabel Users**

| Field | Type | Keterangan |
| ----- | ----- | ----- |
| id | BIGINT (PK) | Primary key auto increment |
| name | VARCHAR(100) | Nama lengkap pengguna |
| email | VARCHAR(150) UNIQUE | Email unik sebagai username |
| password | VARCHAR(255) | Hashed password (bcrypt) |
| persona\_type | ENUM | Hasil quiz: professional, romantic, adventurer, dll |
| role | ENUM (user/admin) | Hak akses pengguna |
| created\_at | TIMESTAMP | Waktu registrasi |

### **Tabel Products (Parfum)**

| Field | Type | Keterangan |
| ----- | ----- | ----- |
| id | BIGINT (PK) | Primary key |
| name | VARCHAR(150) | Nama parfum |
| brand\_id | BIGINT (FK) | Relasi ke tabel brands |
| category\_id | BIGINT (FK) | Relasi ke tabel categories (gender) |
| description | TEXT | Deskripsi lengkap parfum |
| top\_notes | TEXT | Daftar top notes (pisah koma) |
| middle\_notes | TEXT | Daftar middle notes (pisah koma) |
| base\_notes | TEXT | Daftar base notes (pisah koma) |
| scent\_family | VARCHAR(100) | Famili wangi: Floral, Woody, Fresh, Oriental, dll |
| longevity | TINYINT(1-5) | Ketahanan wangi: 1 (lemah) \- 5 (sangat kuat) |
| sillage | TINYINT(1-5) | Daya sebar wangi: 1 (dekat) \- 5 (sangat jauh) |
| concentration | ENUM | EDP, EDT, EDP, Parfum, Body Mist |
| price | DECIMAL(10,2) | Harga dalam Rupiah |
| stock | INT | Jumlah stok tersedia |
| image | VARCHAR(255) | Path foto produk |

### **Tabel Orders**

| Field | Type | Keterangan |
| ----- | ----- | ----- |
| id | BIGINT (PK) | Primary key |
| user\_id | BIGINT (FK) | Relasi ke tabel users |
| total\_amount | DECIMAL(12,2) | Total harga transaksi |
| status | ENUM | pending, paid, shipped, delivered, cancelled |
| payment\_method | VARCHAR(50) | Metode pembayaran yang dipilih |
| shipping\_address | TEXT | Alamat pengiriman |
| created\_at | TIMESTAMP | Waktu order dibuat |

## **6.3 Struktur Folder Laravel**

Berikut struktur folder project Laravel Sanctum Parfum yang direkomendasikan:

* app/Models/ — Model Eloquent (User, Product, Order, Review, Brand, dll)

* app/Http/Controllers/ — Controller untuk setiap modul

* app/Http/Controllers/Admin/ — Controller khusus admin panel

* app/Services/ — Business logic SPK & Chatbot (RecommendationService, ChatbotService)

* resources/views/ — Blade templates (layouts, pages, components)

* routes/web.php — Route untuk halaman web

* routes/api.php — Route untuk API (chatbot, quiz)

* database/migrations/ — Semua migration tabel

* database/seeders/ — Data awal parfum & brand

* public/assets/ — CSS, JS, dan gambar publik

# **BAB VII — REFERENSI JURNAL & PETUNJUK PENGGUNAAN**

## **7.1 Daftar Jurnal Referensi**

### **Jurnal Prioritas Tinggi (★★★)**

| *\[REF-1\] Lutan, E.R. & Badica, C. (2023). Personalized Quiz-Based Perfume Recommender System Using Social Data. In: Advances in Computational Collective Intelligence. ICCCI 2023\. Communications in Computer and Information Science, vol 1864\. Springer, Cham. DOI: 10.1007/978-3-031-41774-0\_3* |
| :---- |

**Digunakan untuk:** Landasan fitur Quiz Persona \+ algoritma rekomendasi parfum (Bab 2.5, Bab 5 Modul 3\)

**Temuan kunci:** Sistem quiz berbasis gaya hidup \+ dataset Fragrantica menghasilkan rekomendasi top-N parfum yang personal

| *\[REF-2\] Hanafizdeh, P. et al. (2010). The Expert System for Assessing Customer Satisfaction on Fragrance Notes: Using Artificial Neural Networks. Expert Systems with Applications, 37(12), 8879-8887. DOI: 10.1016/j.eswa.2010.05.008. (Q1 Scopus, Elsevier)* |
| :---- |

**Digunakan untuk:** Landasan teori Sistem Pakar (SPK) parfum (Bab 2.2)

**Temuan kunci:** Expert system dengan ANN mencapai 70.33% classification rate dalam mengidentifikasi preferensi parfum konsumen dari 2.303 data training

| *\[REF-3\] Hao, Z., Li, H., Guo, J. & Xu, Y. (2025). Advances in artificial intelligence for olfaction and gustation: a comprehensive review. Artificial Intelligence Review, 58, 306\. DOI: 10.1007/s10462-025-11309-4. (Q1 Scopus, Springer — Open Access)* |
| :---- |

**Digunakan untuk:** Latar belakang tren AI dalam industri parfum global (Bab 1.1, Bab 2.2)

**Temuan kunci:** Evolusi AI untuk olfaksi: rule-based (1990s) → ML/SVM (2000s) → Deep Learning (sekarang). AI memungkinkan personalized scent creation skala besar.

### **Jurnal Prioritas Menengah (★★)**

\[REF-4\] Caldarini, G., Jaf, S. & McGarry, K. (2022). A Literature Survey of Recent Advances in Chatbots. Information, 13(1), 41\. DOI: 10.3390/info13010041. (Q2 Scopus, MDPI — Open Access)

**Digunakan untuk:** Landasan teori AI Chatbot (Bab 2.3)

**Temuan kunci:** Chatbot \= NLP \+ ML. Lebih engaging dari FAQ statis. Bisa melayani ribuan user serentak. Tantangan: pemahaman konteks & emosi.

\[REF-5\] Chintalapudi, S.M., El-Gayar, O. & Noteboom, C. (2025). A systematic literature review on AI chatbots in automating customer support for e-commerce. Issues in Information Systems, 26(1), 403-417. DOI: 10.48009/1\_iis\_130

**Digunakan untuk:** Konteks chatbot dalam fitur e-commerce (Bab 2.3, Bab 3.1)

**Temuan kunci:** AI chatbot meningkatkan interactivity, information richness, dan personalization e-commerce. E-commerce global 2024 \= USD 1.192,6 miliar (+8.1%).

\[REF-6\] Liu, Y. & Ding, Z. (2022). Personalized Recommendation Model of Electronic Commerce Based on Semantic Emotion Analysis. Frontiers in Psychology, 13, 952622\. DOI: 10.3389/fpsyg.2022.952622. (Q2 Scopus — Open Access PMC)

**Digunakan untuk:** Landasan sistem rekomendasi berbasis analisis komentar/review (Bab 2.1)

**Temuan kunci:** Sistem SDIS berbasis emosi semantik meningkatkan akurasi rekomendasi 15.1% dan rasio analisis data 9.41%.

### **Jurnal Pendukung (★)**

\[REF-7\] Husna, W.A. & Wibowo, A.P.W. (2024). Analysis of the Impact of UX Design on E-Commerce Website Conversion. International Journal of Economics Development Research, 5(4), 3773-3781. DOI: 10.37385/ijedr.v5i4.6394. (Open Access)

**Digunakan untuk:** Panduan perancangan UI/UX e-commerce (Bab 2.4)

**Temuan kunci:** Lima elemen UX terpenting: navigasi intuitif, loading speed, responsive design, content personalization, kemudahan checkout.

## **7.2 Panduan Mengutip untuk Laporan**

Saat menggunakan referensi di atas dalam laporan project, gunakan format APA 7th Edition:

| *Format APA 7: Nama, I. (Tahun). Judul artikel. Nama Jurnal, Volume(Nomor), Halaman. https://doi.org/xxxxx* |
| :---- |

## **7.3 Pemetaan Referensi ke Bagian Laporan**

| Bagian Laporan | Referensi yang Digunakan |
| ----- | ----- |
| BAB I — Latar Belakang | \[REF-3\] Hao et al. (2025) untuk tren AI parfum; \[REF-5\] Chintalapudi (2025) untuk data pasar e-commerce |
| BAB II — Landasan Teori Chatbot | \[REF-4\] Caldarini et al. (2022); \[REF-5\] Chintalapudi et al. (2025) |
| BAB II — Landasan Teori SPK | \[REF-2\] Hanafizdeh et al. (2010); \[REF-3\] Hao et al. (2025) |
| BAB II — Sistem Rekomendasi | \[REF-1\] Lutan & Badica (2023); \[REF-6\] Liu & Ding (2022) |
| BAB II — UI/UX Design | \[REF-7\] Husna & Wibowo (2024) |
| BAB III — BMC & Value Prop | \[REF-5\] Chintalapudi (2025) untuk fitur e-commerce; \[REF-3\] Hao (2025) untuk konteks industri |
| BAB V — Use Case AI/SPK | \[REF-1\] Lutan & Badica (2023); \[REF-2\] Hanafizdeh (2010) |

# **BAB VIII — PEMBAGIAN TUGAS TIM**

## **8.1 Struktur Tim**

| Posisi | Nama | Tanggung Jawab Utama |
| ----- | ----- | ----- |
| Ketua Kelompok | (Nama Ketua) | Koordinasi tim, arsitektur sistem, fitur AI & SPK, dokumentasi, slide presentasi |
| Anggota 1 | (Nama Anggota 1\) | Backend Laravel (routing, controller, model, database), integrasi payment |
| Anggota 2 | (Nama Anggota 2\) | Frontend (Blade template, UI/UX, Scent Wheel visualisasi), riset pasar & BMC |

## **8.2 Pembagian Tugas per Minggu**

### **Minggu 1 — Perencanaan & Presentasi**

| Tugas | PIC | Deadline |
| ----- | ----- | ----- |
| Finalisasi nama, filosofi, konsep Sanctum Parfum | Ketua | Hari 1 |
| Identifikasi masalah \+ solusi (min. 5\) | Anggota 1 | H+2 |
| Analisis kompetitor (min. 3 platform) | Anggota 1 | H+2 |
| BMC lengkap 9 blok | Anggota 2 | H+2 |
| Persona pengguna (min. 3 tipe) | Anggota 2 | H+2 |
| Use Case garis besar (7 modul) | Ketua | H+2 |
| KPI bisnis & teknis | Ketua | H+3 |
| Slide presentasi final | Ketua \+ Tim | H+4 |

### **Minggu 2 — Design & Setup**

| Tugas | PIC | Deadline |
| ----- | ----- | ----- |
| ERD (Entity Relationship Diagram) | Anggota 1 | H+2 |
| Wireframe semua halaman utama | Anggota 2 | H+2 |
| Mockup UI (Figma/Canva) | Anggota 2 | H+3 |
| Setup project Laravel \+ konfigurasi | Anggota 1 | H+2 |
| Database migration semua tabel | Anggota 1 | H+3 |
| Seeder data parfum awal (min. 20\) | Anggota 1 | H+4 |
| Setup layout Blade template (header, footer, navbar) | Anggota 2 | H+4 |

### **Minggu 3 — Sprint 1**

| Tugas | PIC | Deadline |
| ----- | ----- | ----- |
| Auth: Register, Login, Logout (controller \+ view) | Anggota 1 | H+2 |
| Katalog parfum dengan pagination | Anggota 1 | H+3 |
| Filter & Search produk | Anggota 1 | H+4 |
| Halaman detail parfum | Anggota 1 | H+4 |
| Scent Wheel interaktif (Chart.js/D3.js) | Anggota 2 | H+4 |
| Mood Board per parfum | Anggota 2 | H+4 |
| Wishlist (tambah & hapus) | Anggota 1 | H+5 |

### **Minggu 4 — Sprint 2**

| Tugas | PIC | Deadline |
| ----- | ----- | ----- |
| Quiz Persona (form multi-step \+ kalkulasi) | Ketua | H+2 |
| SPK Rekomendasi (decision tree \+ output 3 parfum) | Ketua | H+3 |
| Integrasi AI Chatbot (API call) | Ketua | H+4 |
| Cart & Checkout | Anggota 1 | H+3 |
| Integrasi payment (simulasi) | Anggota 1 | H+4 |
| Dashboard Admin (CRUD produk) | Anggota 1 | H+4 |
| Admin: Kelola order & laporan | Anggota 1 | H+5 |
| Review & Rating system | Anggota 2 | H+4 |

### **Minggu 5 — Testing & Presentasi**

| Tugas | PIC | Deadline |
| ----- | ----- | ----- |
| UAT (User Acceptance Testing) semua fitur | Tim Full | H+2 |
| Bug fixing berdasarkan hasil UAT | Anggota 1 | H+3 |
| Deployment ke hosting / localhost demo | Anggota 1 | H+3 |
| Dokumentasi teknis (README) | Ketua | H+4 |
| Laporan akhir project | Tim Full | H+4 |
| Slide presentasi akhir | Ketua \+ Anggota 2 | H+4 |
| Gladi resik presentasi | Tim Full | H+5 |

# **DAFTAR PUSTAKA**

Caldarini, G., Jaf, S., & McGarry, K. (2022). A Literature Survey of Recent Advances in Chatbots. Information, 13(1), 41\. https://doi.org/10.3390/info13010041

Chintalapudi, S. M., El-Gayar, O., & Noteboom, C. (2025). A systematic literature review on AI chatbots in automating customer support for e-commerce. Issues in Information Systems, 26(1), 403-417. https://doi.org/10.48009/1\_iis\_130

Hanafizdeh, P., Badie, K., Ghodrat, A., & Taghavifard, M. T. (2010). The expert system for assessing customer satisfaction on fragrance notes: Using artificial neural networks. Expert Systems with Applications, 37(12), 8879-8887. https://doi.org/10.1016/j.eswa.2010.05.008

Hao, Z., Li, H., Guo, J., & Xu, Y. (2025). Advances in artificial intelligence for olfaction and gustation: a comprehensive review. Artificial Intelligence Review, 58, 306\. https://doi.org/10.1007/s10462-025-11309-4

Husna, W. A., & Wibowo, A. P. W. (2024). Analysis of the impact of UX (user experience) design on e-commerce website conversion. International Journal of Economics Development Research, 5(4), 3773-3781. https://doi.org/10.37385/ijedr.v5i4.6394

Liu, Y., & Ding, Z. (2022). Personalized recommendation model of electronic commerce in new media era based on semantic emotion analysis. Frontiers in Psychology, 13, 952622\. https://doi.org/10.3389/fpsyg.2022.952622

Luţan, E. R., & Bădică, C. (2023). Personalized quiz-based perfume recommender system using social data. In N. T. Nguyen et al. (Eds.), Advances in Computational Collective Intelligence. ICCCI 2023\. Communications in Computer and Information Science, vol 1864 (pp. 30-43). Springer. https://doi.org/10.1007/978-3-031-41774-0\_3