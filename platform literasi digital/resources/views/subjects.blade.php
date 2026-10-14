<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kilas Ilmu - Semua Pelajaran</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/subject.css') }}">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="brand">
            </div>
            <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('asset/edu.png') }}" alt="Kilas Ilmu">
            <span class="brand-name">Kilas Ilmu</span>
        </div>
        <ul>
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('subjects') }}">Mata Pelajaran</a></li>
            @auth
                <li><a href="{{ route('progress') }}">Kemajuan</a></li>
            @else
                <li><a href="{{ route('login') }}">Masuk untuk menyimpan kemajuan</a></li>
            @endauth
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn-k">Keluar</button>
                </form>
            </li>
        </ul>
    </nav>
    </header>
    <main>
        <div class="main-container">
            <div style="display: flex; flex-direction: column; width: 100%;">

                <!-- Judul Halaman & Bagian Filter -->
                <div class="page-header">
                    <div class="header-top">
                        <div>
                            <div class="badge-curriculum">
                                <span class="material-symbols-outlined"
                                    style="font-size: 16px; font-variation-settings: 'FILL' 1;">school</span>
                                Materi untuk Anak SD
                            </div>
                            <h1>Semua Pelajaran</h1>
                            <p class="subtitle">Pilih pelajaran dan kerjakan kuis sederhana sesuai materi SD.</p>
                        </div>

                        <!-- Ringkasan Jumlah Pelajaran -->
                        <div class="metric-pill">
                            <div class="metric-icon">8</div>
                            <div class="metric-info">
                                <span class="metric-title">Pelajaran</span>
                                <span class="metric-subtitle">8 pelajaran • 160 soal kuis</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bilah Pencarian dan Filter -->
                    <div class="search-filter-bar">
                        <!-- Kolom Pencarian -->
                        <div class="search-box">
                            <span class="material-symbols-outlined" style="font-size: 20px;">search</span>
                            <input id="subjectSearch" placeholder="Cari pelajaran atau topik..." type="text">
                        </div>
                        <!-- Tombol Filter Cepat -->
                        <div class="filter-container" id="filterContainer">
                            <button class="filter-btn active" data-filter="all">Semua</button>
                            <button class="filter-btn inactive" data-filter="tematik">Tematik</button>
                            <button class="filter-btn inactive" data-filter="bahasa">Bahasa</button>
                            <button class="filter-btn inactive" data-filter="active">Aktif</button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pelajaran -->
                <div class="subjects-grid" id="subjectsGrid">

                    <!-- Pelajaran 1: Matematika -->
                    <div class="subject-card" data-quiz-id="matematika" data-category="tematik active"
                        data-title="matematika berhitung pecahan bangun datar pengukuran waktu panjang dasar sd">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">calculate</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-green">Matematika Dasar</span>
                                            <span class="tag-gray">Tematik SD</span>
                                        </div>
                                        <h2 class="subject-title">Matematika</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Belajar berhitung, pecahan sederhana, bangun datar, dan pengukuran
                                waktu serta panjang.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Penjumlahan dan pengurangan membantu kita menghitung benda sehari-hari.</li>
                                    <li>Pecahan menunjukkan bagian yang sama besar, misalnya setengah dan seperempat.</li>
                                    <li>Persegi memiliki empat sisi sama panjang; panjang benda kecil diukur dengan sentimeter.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span
                                    style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis Matematika" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'matematika']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 2: Bahasa Indonesia -->
                    <div class="subject-card" data-quiz-id="bahasa-indonesia" data-category="bahasa active"
                        data-title="bahasa indonesia cerita dongeng nusantara kalimat tanya puisi anak literasi">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">menu_book</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-green">Bahasa Utama</span>
                                            <span class="tag-gray">Literasi</span>
                                        </div>
                                        <h2 class="subject-title">Bahasa Indonesia</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Membaca teks cerita, memahami dongeng nusantara, menyusun kalimat
                                tanya, dan puisi anak.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Temukan siapa, apa, dan di mana saat membaca sebuah cerita.</li>
                                    <li>Gunakan tanda tanya (?) di akhir kalimat tanya dan titik (.) di akhir kalimat berita.</li>
                                    <li>Sinonim memiliki arti mirip, sedangkan antonim memiliki arti berlawanan.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span
                                    style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis Bahasa Indonesia" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'bahasa-indonesia']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 3: Sains -->
                    <div class="subject-card" data-quiz-id="ipas" data-category="tematik"
                        data-title="ipas ilmu pengetahuan alam sosial siklus air tumbuhan hewan lingkungan sains">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">eco</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-gray">Sains &amp; Sosial</span>
                                            <span class="tag-gray">Tematik SD</span>
                                        </div>
                                        <h2 class="subject-title">IPAS (Ilmu Pengetahuan Alam &amp; Sosial)</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Mengeksplorasi siklus air, bagian tumbuhan, hewan di sekitar kita,
                                dan peta lingkungan rumah.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Akar menyerap air, batang menyalurkannya, dan daun membantu tumbuhan membuat makanan.</li>
                                    <li>Panas matahari menguapkan air; uap air dapat berkumpul menjadi awan.</li>
                                    <li>Jaga lingkungan dengan memilah sampah dan merawat tanaman.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span
                                    style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis IPAS" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'ipas']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 4: Pancasila & Seni -->
                    <div class="subject-card" data-quiz-id="pancasila-seni" data-category="tematik"
                        data-title="pendidikan pancasila seni budaya sbdp ppkn gotong royong kerajinan tangan karakter kreativitas">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">palette</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-gray">Karakter &amp; Kreativitas</span>
                                        </div>
                                        <h2 class="subject-title">Pendidikan Pancasila &amp; Seni Budaya</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Mengenal nilai gotong royong, aturan di sekolah, serta berkreasi
                                menggambar dan membuat kerajinan tangan.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Gotong royong berarti bekerja bersama untuk menyelesaikan kebaikan bersama.</li>
                                    <li>Dengarkan pendapat teman dan ikuti aturan yang disepakati bersama.</li>
                                    <li>Merah dan kuning dapat dicampur menjadi jingga; gunakan alat seni dengan aman.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span
                                    style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis Pendidikan Pancasila dan Seni Budaya" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'pancasila-seni']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 5: Pendidikan Agama & Budi Pekerti -->
                    <div class="subject-card" data-quiz-id="pendidikan-agama" data-category="tematik"
                        data-title="pendidikan agama budi pekerti sikap baik jujur peduli tanggung jawab toleransi">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">volunteer_activism</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-green">Budi Pekerti</span>
                                            <span class="tag-gray">Karakter</span>
                                        </div>
                                        <h2 class="subject-title">Pendidikan Agama &amp; Budi Pekerti</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Belajar sikap jujur, peduli, bertanggung jawab, dan menghormati perbedaan dalam kehidupan sehari-hari.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Jujur berarti berkata sesuai kenyataan dan mengembalikan barang yang bukan milik kita.</li>
                                    <li>Tepati janji, minta maaf saat salah, dan bantu teman yang membutuhkan.</li>
                                    <li>Hormati teman yang memiliki kebiasaan atau keyakinan berbeda agar hidup rukun.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis Pendidikan Agama dan Budi Pekerti" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'pendidikan-agama']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 6: PJOK -->
                    <div class="subject-card" data-quiz-id="pjok" data-category="tematik active"
                        data-title="pjok pendidikan jasmani olahraga kesehatan kebugaran gerak sehat keselamatan">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">sports_basketball</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-green">Olahraga</span>
                                            <span class="tag-gray">Hidup Sehat</span>
                                        </div>
                                        <h2 class="subject-title">PJOK</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Mengenal gerak dasar, kebugaran tubuh, permainan, keselamatan, dan kebiasaan hidup sehat.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Lakukan pemanasan sebelum olahraga dan pendinginan setelah selesai.</li>
                                    <li>Minum air putih, makan makanan bergizi, dan beristirahat cukup.</li>
                                    <li>Ikuti aturan permainan dan jaga keselamatan diri serta teman.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis PJOK" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'pjok']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 7: Bahasa Inggris -->
                    <div class="subject-card" data-quiz-id="bahasa-inggris" data-category="bahasa"
                        data-title="bahasa inggris kosakata warna angka sapaan benda sederhana">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">translate</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-green">Bahasa Asing</span>
                                            <span class="tag-gray">Kosakata Dasar</span>
                                        </div>
                                        <h2 class="subject-title">Bahasa Inggris</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Berlatih kosakata sehari-hari, warna, angka, benda, serta ungkapan sederhana dalam Bahasa Inggris.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Warna: red (merah), blue (biru), dan green (hijau).</li>
                                    <li>Angka: one (satu), two (dua), dan ten (sepuluh).</li>
                                    <li>Gunakan “Good morning” untuk menyapa pada pagi hari dan “Thank you” untuk berterima kasih.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis Bahasa Inggris" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'bahasa-inggris']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pelajaran 8: Informatika -->
                    <div class="subject-card" data-quiz-id="informatika" data-category="tematik"
                        data-title="informatika komputer teknologi digital algoritma keamanan internet perangkat">
                        <div>
                            <div class="subject-header">
                                <div class="subject-icon-title">
                                    <div class="subject-icon">
                                        <span class="material-symbols-outlined"
                                            style="font-size: 28px; font-variation-settings: 'FILL' 1;">computer</span>
                                    </div>
                                    <div>
                                        <div class="subject-tags">
                                            <span class="tag-green">Teknologi</span>
                                            <span class="tag-gray">Digital</span>
                                        </div>
                                        <h2 class="subject-title">Informatika</h2>
                                    </div>
                                </div>
                                <span class="subject-percentage" data-subject-percentage>0%</span>
                            </div>
                            <p class="subject-desc">Mengenal perangkat komputer, langkah berpikir, informasi digital, dan cara aman menggunakan teknologi.</p>
                            <details class="study-material">
                                <summary>Yuk, pelajari materinya</summary>
                                <ul>
                                    <li>Keyboard digunakan untuk mengetik, mouse untuk memilih, dan monitor untuk melihat hasil.</li>
                                    <li>Algoritma adalah urutan langkah yang membantu kita menyelesaikan masalah.</li>
                                    <li>Jangan bagikan kata sandi atau alamat rumah; tanyakan kepada orang dewasa tepercaya jika ragu.</li>
                                </ul>
                            </details>
                        </div>
                        <div>
                            <div class="progress-info">
                                <span style="color: var(--on-surface-variant); font-weight: 500; display: flex; align-items: center; gap: 4px;">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">menu_book</span>
                                    20 soal kuis
                                </span>
                                <span class="subject-progress-label" data-subject-progress-label>Belum dikerjakan</span>
                            </div>
                            <div class="progress-bar-bg" role="progressbar" aria-label="Nilai terbaik kuis Informatika" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar-fill" style="width: 0%;"></div>
                            </div>
                            <a class="btn-start" href="{{ route('quiz', ['lesson' => 'informatika']) }}">
                                <span>Mulai Kuis</span>
                                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>

                <p class="subject-progress-error" id="subject-progress-error" role="alert" hidden></p>

                <!-- Tampilan kosong saat hasil filter tidak ditemukan -->
                <div class="empty-state" id="noResultsMessage">
                    <div class="empty-icon">
                        <span class="material-symbols-outlined" style="font-size: 24px;">search_off</span>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600;">Pelajaran tidak ditemukan</h3>
                    <p style="font-size: 0.875rem; color: var(--on-surface-variant); margin-top: 4px;">Coba kata kunci
                        lain atau pilih filter yang berbeda.</p>
                </div>

                <!-- Informasi Belajar -->
                <div class="notice-banner">
                    <div class="notice-left">
                        <div class="notice-icon">
                            <span class="material-symbols-outlined" style="font-size: 20px;">emoji_events</span>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 600; color: var(--on-surface);">Terus semangat belajar!</div>
                            <div style="font-size: 0.875rem; color: var(--on-surface-variant);">Kerjakan kuis dan lihat perkembangan belajarmu di halaman progres.</div>
                        </div>
                    </div>
                    <a class="notice-link" href="{{ route('progress') }}">
                        Lihat Progres Belajar
                        <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                    </a>
                </div>

            </div>
        </div>
    </main>

    <!-- Bagian Bawah Halaman -->
    <footer>
        <div class="footer-container">
            <p style="font-size: 0.875rem; color: var(--on-surface-variant);">© 2026 Kilas Ilmu. Platform belajar untuk semua.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Ketentuan Layanan</a>
                <a href="#">Bantuan</a>
            </div>
        </div>
    </footer>
    @vite('resources/js/subjects.js')
</body>

</html>
