<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="web_standard" name="shell-type">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/progress.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <div class="brand">
            <img src="{{ asset('asset/edu.png') }}" alt="Kilas Ilmu">
            <span class="brand-name">Kilas Ilmu</span>
        </div>
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
    <main class="main-content">
        <div class="container">
            <div class="content-wrapper">

                <!-- Judul Halaman -->
                <div class="page-title-section">
                    <div>
                        <div class="badge-tag">
                            <span class="material-symbols-outlined">insights</span>
                            Ringkasan Performa Akademik
                        </div>
                        <h1 class="page-title">Kemajuan & Prestasi Belajar</h1>
                        <p class="page-subtitle">
                            Lacak kemajuan Anda, raih pencapaian, dan tingkatkan pengalaman belajar Anda dengan wawasan yang dipersonalisasi.
                        </p>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-light">
                            <span class="material-symbols-outlined">calendar_today</span>
                            30 Hari Terakhir
                        </button>
                        <button class="btn btn-primary">
                            <span class="material-symbols-outlined">download</span>
                            Ekspor Laporan
                        </button>
                    </div>
                </div>

                <!-- Ringkasan 4 Metrik Utama -->
                <div class="metrics-grid">
                    <!-- Metrik 1 -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <span class="stat-label">Total XP</span>
                            <div class="stat-icon primary-hover">
                                <span class="material-symbols-outlined">bolt</span>
                            </div>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value">0 <span class="stat-unit">XP</span></div>
                            <div class="stat-trend positive">
                                <span class="material-symbols-outlined">trending_up</span>
                                0 minggu ini
                            </div>
                        </div>
                    </div>
                    <!-- Metrik 2 -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <span class="stat-label">Pelajaran Selesai</span>
                            <div class="stat-icon primary-hover">
                                <span class="material-symbols-outlined">menu_book</span>
                            </div>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value">0</div>
                            <div class="stat-desc">Dari 0 mata pelajaran inti</div>
                        </div>
                    </div>
                    <!-- Metrik 3 -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <span class="stat-label">Rata-rata Ketepatan</span>
                            <div class="stat-icon secondary-hover">
                                <span class="material-symbols-outlined">verified</span>
                            </div>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value">0%</div>
                            <div class="stat-trend positive">
                                <span class="material-symbols-outlined">arrow_upward</span>
                                0% dari nilai acuan
                            </div>
                        </div>
                    </div>
                    <!-- Metrik 4 -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <span class="stat-label">Progres Kurikulum</span>
                            <div class="stat-icon primary-hover">
                                <span class="material-symbols-outlined">hourglass_top</span>
                            </div>
                        </div>
                        <div class="stat-body">
                            <div class="stat-value">0%</div>
                            <div class="stat-desc">Progres kurikulum keseluruhan</div>
                        </div>
                    </div>
                </div>
                <div class="card curriculum-card">
                    <div class="curriculum-header">
                        <div class="curriculum-info">
                            <div class="curriculum-icon">
                                <span class="material-symbols-outlined">school</span>
                            </div>
                            <div>
                                <h2>Penyelesaian Kurikulum Keseluruhan</h2>
                                <p>Semester Aktif 1 — Jalur Sains, Teknologi, Rekayasa, Matematika &amp; Humaniora</p>
                            </div>
                        </div>
                        <div class="curriculum-badges">
                            <span class="badge-pill primary-pill">0% Selesai</span>
                            <span class="badge-pill secondary-pill">Belum Dimulai</span>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 0%;" role="progressbar"
                                aria-label="Penyelesaian kurikulum" aria-valuemin="0" aria-valuemax="100"
                                aria-valuenow="0"></div>
                        </div>
                        <div class="progress-footer">
                            <div class="progress-legend">
                                <span class="legend-item"><span class="dot primary-dot"></span> 0 Modul
                                    Selesai</span>
                                <span class="legend-item"><span class="dot gray-dot"></span> 28 Tersisa</span>
                            </div>
                            <span class="estimated-date">Perkiraan Selesai: -</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Konten Dua Kolom -->
                <div class="lower-grid">

                    <!-- Kolom Kiri (Pelajaran Selesai - Kosong/Belum ada riwayat) -->
                    <div class="card main-lessons-card">
                        <div class="section-header">
                            <div class="section-title-wrap">
                                <div class="section-icon">
                                    <span class="material-symbols-outlined">assignment_turned_in</span>
                                </div>
                                <h2>Pelajaran Selesai</h2>
                            </div>
                            <span class="sort-text">Urutkan: Terbaru</span>
                        </div>

                        <div class="lesson-list">
                            <div style="text-align: center; padding: 2.5rem 1rem; color: var(--on-surface-variant);">
                                <span class="material-symbols-outlined"
                                    style="font-size: 40px; margin-bottom: 0.5rem; opacity: 0.5;">inbox</span>
                                <p style="margin: 0; font-size: 0.875rem;">Belum ada pelajaran yang diselesaikan. Mulai
                                    sebuah modul untuk melihat kemajuanmu di sini!</p>
                            </div>
                        </div>

                        <div class="lesson-footer-prompt">
                            <span>Menampilkan 0 dari 0 catatan pelajaran yang selesai</span>
                            <button class="view-all-btn" type="button">
                                Lihat Semua Catatan yang Selesai
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Aktivitas Mingguan & Lencana) -->
                    <div class="right-column">

                        <!-- Aktivitas Mingguan (Rangkaian 0 Hari) -->
                        <div class="card">
                            <div class="section-header">
                                <div class="section-title-wrap">
                                    <span class="material-symbols-outlined fire-icon">local_fire_department</span>
                                    <h2>Aktivitas Mingguan</h2>
                                </div>
                                <span class="streak-pill"
                                    style="background-color: rgba(115, 118, 134, 0.1); color: var(--outline);">0 Hari
                                    Beruntun</span>
                            </div>
                            <p class="section-desc">Masuk setiap hari untuk menjaga rangkaian belajar dan mendapatkan
                                XP bonus.</p>

                            <div class="tracker-grid">
                                <div class="tracker-day">
                                    <span>Sen</span>
                                    <div class="tracker-circle empty"><span class="empty-dot"></span></div>
                                    <span class="tracker-date">7 Okt</span>
                                </div>
                                <div class="tracker-day">
                                    <span>Sel</span>
                                    <div class="tracker-circle empty"><span class="empty-dot"></span></div>
                                    <span class="tracker-date">8 Okt</span>
                                </div>
                                <div class="tracker-day">
                                    <span>Rab</span>
                                    <div class="tracker-circle empty"><span class="empty-dot"></span></div>
                                    <span class="tracker-date">9 Okt</span>
                                </div>
                                <div class="tracker-day">
                                    <span>Kam</span>
                                    <div class="tracker-circle empty"><span class="empty-dot"></span></div>
                                    <span class="tracker-date">10 Okt</span>
                                </div>
                                <div class="tracker-day">
                                    <span>Jum</span>
                                    <div class="tracker-circle empty"><span class="empty-dot"></span></div>
                                    <span class="tracker-date">11 Okt</span>
                                </div>
                                <div class="tracker-day">
                                    <span class="bold">Sab</span>
                                    <div class="tracker-circle today"><span
                                            class="material-symbols-outlined">schedule</span></div>
                                    <span class="tracker-date today-text">Hari ini</span>
                                </div>
                                <div class="tracker-day">
                                    <span>Min</span>
                                    <div class="tracker-circle empty"><span class="empty-dot"></span></div>
                                    <span class="tracker-date">13 Okt</span>
                                </div>
                            </div>

                            <div class="tracker-tip">
                                <span class="material-symbols-outlined">emoji_events</span>
                                <span>Belajar hari ini untuk memulai <strong>Rangkaian Belajar</strong> pertamamu!</span>
                            </div>
                        </div>

                        <!-- Bagian Lencana yang Diraih (0 Terbuka) -->
                        <div class="card">
                            <div class="section-header">
                                <div class="section-title-wrap">
                                    <span class="material-symbols-outlined badge-main-icon">military_tech</span>
                                    <h2>Lencana yang Diraih</h2>
                                </div>
                                <span class="unlocked-text">0 Terbuka</span>
                            </div>

                            <div class="badges-list"
                                style="text-align: center; padding: 1.5rem 0; color: var(--on-surface-variant);">
                                <p style="margin: 0; font-size: 0.875rem;">Selesaikan pelajaran dan kuis untuk membuka
                                    pencapaian serta lencana.</p>
                            </div>

                            <button class="showcase-btn">
                                Lihat Koleksi Lencana (11 Terkunci)
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <p>© 2026 Kilas Ilmu. Keunggulan Akademik &amp; Platform Pembelajaran.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Ketentuan Layanan</a>
                <a href="#">Pusat Bantuan</a>
            </div>
        </div>
    </footer>
    @vite('resources/js/progress.js')
</body>
</html>