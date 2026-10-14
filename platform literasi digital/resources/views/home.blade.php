<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>kilas Ilmu - Platform Pembelajaran</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>

    <nav class="navbar" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('home') }}">
            <img src="{{ asset('asset/edu.png') }}" alt="">
            <span class="brand-name">Kilas Ilmu</span>
        </a>
        <ul>
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ route('subjects') }}">Mata Pelajaran</a></li>
            <li><a href="{{ route('progress') }}">Kemajuan</a></li>
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn-k">Keluar</button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Konten Utama -->
    <main class="main-content">
        <div class="wrapper">
            <div class="flex-container">

                <!-- Banner Selamat Datang & Riwayat -->
                <section class="welcome-banner">
                    <div class="welcome-left">
                        <div class="icon-box-large">
                            <span class="material-symbols-outlined icon-28">school</span>
                        </div>
                        <div>
                            <div class="welcome-title-row">
                                <h1 class="welcome-heading">Selamat datang, {{ auth()->user()->name }}</h1>
                                <span class="scholar-badge">
                                    <span class="scholar-dot"></span> Pelajar Baru
                                </span>
                            </div>
                            <p class="welcome-subtitle">Mulai perjalanan belajarmu hari ini!</p>
                        </div>
                    </div>
                    <div class="banner-stats">
                        <!-- Lencana Beruntun (0) -->
                        <div class="stat-card">
                            <span class="material-symbols-outlined icon-streak"
                                style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                            <div class="stat-info">
                                <span class="stat-title" id="streak-title">0 hari beruntun</span>
                                <span class="stat-desc" id="streak-subtitle">Terbaik: 0 hari</span>
                            </div>
                        </div>
                        <!-- Target Harian (0) -->
                        <div class="stat-card">
                            <div class="goal-circle-wrapper">
                                <svg class="goal-svg" viewBox="0 0 36 36">
                                    <path class="goal-path-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="currentColor" stroke-width="3"></path>
                                    <path class="goal-path-fill"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 0 a 15.9155 15.9155 0 0 1 0 0"
                                        fill="none" stroke="currentColor" stroke-dasharray="0, 100"
                                        stroke-linecap="round" stroke-width="3.5"></path>
                                </svg>
                                <span class="material-symbols-outlined goal-icon">remove</span>
                            </div>
                            <div class="stat-info">
                                <span class="stat-title" id="daily-goal-title">Target Harian: 0/2 pertanyaan</span>
                                <span class="stat-completed" id="daily-goal-subtitle">0 selesai hari ini</span>
                            </div>
                        </div>
                    </div>
                    <p id="home-progress-error" role="alert" hidden></p>
                </section>

                <!-- Bagian Hero -->
                <section class="hero-section">
                    <div class="hero-left">
                        <span class="hero-tag">Menginovasi Pendidikan Melalui Teknologi</span>
                        <h2 class="hero-title">Belajar Lebih Cerdas.</h2>
                        <p class="hero-desc">Belajar sesuai ritme Anda dengan kursus modular interaktif, tantangan
                            diagnostik secara real-time, dan jalur kurikulum berbasis data.</p>
                        <div class="hero-buttons">
                            <a href="#subjects-overview" class="btn-primary">
                                <span>Mulai Belajar</span>
                                <span class="material-symbols-outlined icon-18">arrow_forward</span>
                            </a>
                            <a class="btn-secondary" href="{{ route('subjects') }}">Jelajahi Silabus</a>
                        </div>
                        <div class="hero-features">
                            <div class="feature-item">
                                <span class="material-symbols-outlined icon-feature">verified</span>
                                <span>Konten Terakreditasi</span>
                            </div>
                            <div class="feature-item">
                                <span class="material-symbols-outlined icon-feature">bolt</span>
                                <span>Pembelajaran Mandiri</span>
                            </div>
                        </div>
                    </div>
                    <!-- Area Grafis Edukasi -->
                    <div class="hero-graphic-container">
                        <div class="hero-graphic-box">
                            <div class="graphic-circle">
                                <svg class="graphic-svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 3L1 9L12 15L21 10.09V17H23V9M5 13.18V17.18C5 19.94 8.13 22 12 22C15.87 22 19 19.94 19 17.18V13.18L12 17L5 13.18Z">
                                    </path>
                                </svg>
                            </div>
                            <div class="graphic-badge">
                                <span class="material-symbols-outlined icon-story">auto_stories</span>
                                <span>Sistem Modular Interaktif</span>
                            </div>
                            <div class="graphic-floating-tag">Jalur Adaptif v2.4</div>
                        </div>
                    </div>
                </section>

                <!-- Kartu Sorotan Lanjutkan Belajar (0%) -->
                <section>
                    <div class="section-heading-wrapper">
                        <div class="section-title-group">
                            <span class="material-symbols-outlined icon-play">play_circle</span>
                            <h3 class="section-title">Mulai Kursus Baru</h3>
                        </div>
                        <span class="section-subtitle">Belum ada riwayat belajar</span>
                    </div>
                    <div class="course-card course-card-row" data-home-featured-subject="matematika">
                        <div class="course-info-left">
                            <div class="course-badge-row">
                                <span class="course-badge">Matematika SD</span>
                                <span class="course-meta">
                                    <span class="material-symbols-outlined icon-16">menu_book</span> Module 1 • 15 mins
                                    left
                                </span>
                            </div>
                            <h4 class="course-title">Operasi Hitung Penjumlahan & Pengurangan</h4>
                            <p class="course-desc">Fokus: Mempelajari dasar berhitung penjumlahan, pengurangan, dan
                                pemecahan masalah sederhana sehari-hari.</p>
                            <!-- Bilah Progres (0%) -->
                            <div>
                                <div class="progress-info">
                                    <span class="progress-label-dark">Matematika SD</span>
                                    <span class="progress-label-blue" id="featured-subject-percentage">0%</span>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" id="featured-subject-progress" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="course-action-right">
                            <a class="btn-primary btn-full" href="{{ route('quiz', ['lesson' => 'matematika']) }}">
                                <span>Mulai Belajar</span>
                                <span class="material-symbols-outlined icon-18">play_arrow</span>
                            </a>
                            <span class="course-step-label">Langkah 0 dari 10 dalam modul ini</span>
                        </div>
                    </div>
                </section>

                <!-- Bagian Mata Pelajaran Anda (0%) -->
                <section id="subjects-overview">
                    <div class="subjects-header-wrapper">
                        <div>
                            <h3 class="subjects-main-title">Mata Pelajaran yang Diikuti</h3>
                            <p class="subjects-main-subtitle">Periode akademik aktif untuk Semester Genap 2026</p>
                        </div>
                        <span class="enrolled-badge">3 Terdaftar</span>
                    </div>
                    <div class="subjects-grid">

                        <!-- Kartu 1: Matematika -->
                        <div class="course-card" data-home-subject="matematika">
                            <div>
                                <div class="subject-card-top">
                                    <div class="subject-icon-box">
                                        <span class="material-symbols-outlined icon-24">calculate</span>
                                    </div>
                                    <span class="subject-tag">Matematika Dasar</span>
                                </div>
                                <h4 class="subject-title">Matematika</h4>
                                <p class="subject-desc">Belajar berhitung seru, perkalian, pembagian, dan bentuk bangun
                                    datar.</p>
                            </div>
                            <div>
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <span class="progress-lessons" data-home-subject-attempts>0 percobaan</span>
                                        <span class="progress-percent" data-home-subject-percentage>0%</span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill" data-home-subject-fill style="width: 0%;"></div>
                                    </div>
                                </div>
                                <a class="btn-secondary btn-subject-open" href="{{ route('quiz', ['lesson' => 'matematika']) }}">
                                    <span>Buka Mata Pelajaran</span>
                                    <span class="material-symbols-outlined icon-16">chevron_right</span>
                                </a>
                            </div>
                        </div>

                        <!-- Kartu 2: Bahasa -->
                        <div class="course-card" data-home-subject="bahasa-indonesia">
                            <div>
                                <div class="subject-card-top">
                                    <div class="subject-icon-box">
                                        <span class="material-symbols-outlined icon-24">menu_book</span>
                                    </div>
                                    <span class="subject-tag">Bahasa & Sastra</span>
                                </div>
                                <h4 class="subject-title">Bahasa Indonesia</h4>
                                <p class="subject-desc">Membaca cerita pendek, menulis kalimat efektif, dan memperkaya
                                    kosakata bahasa Indonesia.</p>
                            </div>
                            <div>
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <span class="progress-lessons" data-home-subject-attempts>0 percobaan</span>
                                        <span class="progress-percent" data-home-subject-percentage>0%</span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill" data-home-subject-fill style="width: 0%;"></div>
                                    </div>
                                </div>
                                <a class="btn-secondary btn-subject-open" href="{{ route('quiz', ['lesson' => 'bahasa-indonesia']) }}">
                                    <span>Buka Mata Pelajaran</span>
                                    <span class="material-symbols-outlined icon-16">chevron_right</span>
                                </a>
                            </div>
                        </div>

                        <!-- Kartu 3: Sains -->
                        <div class="course-card" data-home-subject="ipas">
                            <div>
                                <div class="subject-card-top">
                                    <div class="subject-icon-box">
                                        <span class="material-symbols-outlined icon-24">public</span>
                                    </div>
                                    <span class="subject-tag">Tematik SD</span>
                                </div>
                                <h4 class="subject-title">IPAS (Ilmu Pengetahuan Alam & Sosial)</h4>
                                <p class="subject-desc">Mengenal lingkungan alam, bagian tubuh makhluk hidup, dan
                                    sejarah lingkungan sekitar.</p>
                            </div>
                            <div>
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <span class="progress-lessons" data-home-subject-attempts>0 percobaan</span>
                                        <span class="progress-percent" data-home-subject-percentage>0%</span>
                                    </div>
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill" data-home-subject-fill style="width: 0%;"></div>
                                    </div>
                                </div>
                                <a class="btn-secondary btn-subject-open" href="{{ route('quiz', ['lesson' => 'ipas']) }}">
                                    <span>Buka Mata Pelajaran</span>
                                    <span class="material-symbols-outlined icon-16">chevron_right</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Banner Tips Belajar -->
                <section class="study-tip">
                    <div class="tip-icon-box">
                        <span class="material-symbols-outlined icon-20">lightbulb</span>
                    </div>
                    <div class="tip-content-wrapper">
                        <p class="tip-text">
                            <strong class="tip-highlight">Tips Belajar:</strong> Sprint harian 20 menit singkat lebih
                            efektif dalam meningkatkan daya ingat dibanding sesi akhir pekan yang panjang.
                        </p>
                        <a class="tip-btn" href="{{ route('progress') }}">Lihat progres →</a>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <!-- Catatan Kaki -->
    <footer class="site-footer">
        <div class="wrapper">
            <div class="footer-container">
                <p class="footer-copyright">&copy; 2026 Kilas Ilmu. Keunggulan Akademik &amp; Platform Pembelajaran.</p>
                <div class="footer-links">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('subjects') }}">Pelajaran</a>
                    <a href="{{ route('progress') }}">Progres</a>
                </div>
            </div>
        </div>
    </footer>

    @vite('resources/js/home.js')
</body>

</html>
