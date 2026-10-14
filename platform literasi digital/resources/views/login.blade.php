<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f7fc">
    <title>Masuk atau Daftar | Kilas Ilmu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="auth-layout">
        <aside class="auth-aside">
            <a class="brand" href="{{ route('login') }}" aria-label="Kilas Ilmu, halaman masuk">
                <img src="{{ asset('asset/edu.png') }}" alt="">
                <span class="brand-name">Kilas Ilmu</span>
            </a>

            <div class="aside-copy">
                <p class="eyebrow">Belajar dengan arah</p>
                <h1>Langkah kecil hari ini, kemajuan besar esok hari.</h1>
                <p>Bangun kebiasaan belajar, kerjakan kuis, dan lihat perkembanganmu tersimpan dengan aman.</p>
                <ul class="benefit-list">
                    <li><span class="benefit-check" aria-hidden="true">✓</span> Progres belajar personal</li>
                    <li><span class="benefit-check" aria-hidden="true">✓</span> Riwayat hasil kuis</li>
                    <li><span class="benefit-check" aria-hidden="true">✓</span> Target dan rangkaian belajar harian</li>
                </ul>
            </div>

            <div class="aside-foot">Kilas Ilmu · Temukan ritme belajarmu</div>
        </aside>

        <section class="auth-main" aria-label="Akun Kilas Ilmu">
            <div class="auth-content">
                <header class="form-heading">
                    <h2>Selamat datang</h2>
                    <p>Masuk ke akunmu atau daftar untuk mulai menyimpan progres belajar.</p>
                </header>

                @if ($errors->any())
                    <div class="validation-errors" role="alert" aria-live="polite">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <input
                    type="radio"
                    name="auth-tab"
                    id="tab-login"
                    @checked(! $errors->has('name') && ! $errors->has('password_confirmation'))
                >
                <input
                    type="radio"
                    name="auth-tab"
                    id="tab-register"
                    @checked($errors->has('name') || $errors->has('password_confirmation'))
                >

                <div class="auth-tabs" role="tablist" aria-label="Pilih masuk atau daftar">
                    <label id="login-tab" for="tab-login" role="tab" aria-controls="login-panel">Masuk</label>
                    <label id="register-tab" for="tab-register" role="tab" aria-controls="register-panel">Buat akun</label>
                </div>

                <div class="auth-panels">
                    <section class="auth-panel" id="login-panel" role="tabpanel" aria-labelledby="login-tab">
                        <form action="{{ route('login.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <p class="auth-form-note">Gunakan email dan kata sandi yang dibuat saat mendaftar di Kilas Ilmu. Kata sandi Gmail tidak digunakan.</p>
                                <label for="login-email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    id="login-email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    autocomplete="email"
                                    required
                                >

                                <label for="login-password" class="form-label">Kata sandi</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    id="login-password"
                                    placeholder="Masukkan kata sandi"
                                    autocomplete="current-password"
                                    required
                                >
                                <label class="remember-row" for="remember">
                                    <input type="checkbox" name="remember" id="remember" value="1">
                                    <span>Ingat saya di perangkat ini</span>
                                </label>
                                <button type="submit" class="btn-primary">Masuk ke akun</button>
                            </div>
                        </form>
                    </section>

                    <section class="auth-panel" id="register-panel" role="tabpanel" aria-labelledby="register-tab">
                        <form action="{{ route('register.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <p class="auth-form-note">Daftar satu kali. Jika email sudah terdaftar, pilih Masuk dan gunakan kata sandi yang dibuat saat mendaftar.</p>
                                <label for="register-name" class="form-label">Nama lengkap</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    id="register-name"
                                    value="{{ old('name') }}"
                                    placeholder="Nama yang ingin ditampilkan"
                                    autocomplete="name"
                                    maxlength="255"
                                    required
                                >

                                <label for="register-email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    id="register-email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    autocomplete="email"
                                    maxlength="255"
                                    required
                                >

                                <label for="register-password" class="form-label">Kata sandi</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    id="register-password"
                                    placeholder="Minimal 8 karakter"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required
                                >

                                <label for="register-password-confirmation" class="form-label">Ulangi kata sandi</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    id="register-password-confirmation"
                                    placeholder="Masukkan kata sandi sekali lagi"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required
                                >

                                <button type="submit" class="btn-primary">Buat akun gratis</button>
                            </div>
                        </form>
                    </section>
                </div>

                <p class="auth-note">Informasi akun dan progres belajar hanya digunakan untuk pengalaman belajarmu.</p>
            </div>
        </section>
    </main>
</body>
</html>
