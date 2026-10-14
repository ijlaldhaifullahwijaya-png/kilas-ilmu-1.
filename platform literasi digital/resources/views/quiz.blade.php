<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kuis {{ $selectedQuiz['title'] }} - Kilas Ilmu</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
</head>

<body class="quiz-page">
    <header>
        <div class="header-container">
            <a class="brand" href="{{ route('home') }}">
                <img src="{{ asset('asset/edu.png') }}" alt="">
                <span>Kilas Ilmu</span>
            </a>
            <nav aria-label="Navigasi utama">
                <a href="{{ route('home') }}">Beranda</a>
                <a class="active" href="{{ route('subjects') }}">Mata Pelajaran</a>
                <a href="{{ route('progress') }}">Kemajuan</a>
                <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn-k">Keluar</button>
                </form>
            </li>
            </nav>
        </div>
    </header>

    <main>
        <div class="main-container">
            <a class="back-link" href="{{ route('subjects') }}">
                <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
                Kembali ke daftar pelajaran
            </a>

            <div class="session-bar">
                <div class="session-left">
                    <span class="badge-math">
                        <span class="material-symbols-outlined" aria-hidden="true">{{ $selectedQuiz['icon'] }}</span>
                        {{ $selectedQuiz['subject'] }}
                    </span>
                    <span class="session-label">Latihan untuk anak SD</span>
                </div>
                <div class="question-counter" id="question-count" aria-live="polite"></div>
            </div>

            <div class="quiz-progress">
                <div class="track-progress-bg">
                    <div
                        aria-valuemax="{{ count($selectedQuiz['questions']) }}"
                        aria-valuemin="0"
                        aria-valuenow="0"
                        class="track-progress-fill"
                        id="question-progress"
                        role="progressbar"></div>
                </div>
            </div>

            <div class="workspace">
                <form
                    class="question-card quiz-form"
                    id="quiz-form"
                    data-quiz-id="{{ $selectedQuizId }}"
                    data-attempt-id="{{ $quizAttemptId }}">
                    @foreach ($selectedQuiz['questions'] as $questionId => $question)
                        <fieldset class="question-step" @if (! $loop->first) hidden @endif>
                            <div class="card-top-info">
                                <span class="algebra-badge">Soal {{ $loop->iteration }}</span>
                                <span class="difficulty-info">Pilih satu jawaban yang benar</span>
                            </div>

                            <legend tabindex="-1">{{ $question['prompt'] }}</legend>

                            <div class="options-group" role="radiogroup" aria-label="Pilihan jawaban soal {{ $loop->iteration }}">
                                @foreach ($question['options'] as $value => $option)
                                    <label class="quiz-option" for="{{ $questionId }}-{{ $loop->index }}">
                                        <input
                                            id="{{ $questionId }}-{{ $loop->index }}"
                                            name="{{ $questionId }}"
                                            type="radio"
                                            value="{{ $value }}">
                                        <span class="option-content">
                                            <span class="option-badge">{{ chr(65 + $loop->index) }}</span>
                                            <span class="option-text">{{ $option }}</span>
                                        </span>
                                        <span class="radio-indicator" aria-hidden="true">
                                            <span class="radio-dot"></span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="quick-tip">
                                <span class="material-symbols-outlined" aria-hidden="true">lightbulb</span>
                                <p>Baca soalnya baik-baik, lalu pilih jawaban yang menurutmu paling tepat. Semangat! 😊</p>
                            </div>
                        </fieldset>
                    @endforeach

                    <p class="quiz-message" id="quiz-message" role="alert" hidden></p>

                    <div class="action-toolbar">
                        <button class="btn-prev" id="previous-question" type="button" disabled>
                            <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
                            Sebelumnya
                        </button>
                        <button class="btn-submit" id="next-question" type="button" hidden>
                            Soal berikutnya
                            <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
                        </button>
                        <button class="btn-submit" id="submit-quiz" type="submit" hidden>
                            Selesai &amp; lihat hasil
                            <span class="material-symbols-outlined" aria-hidden="true">celebration</span>
                        </button>
                    </div>
                </form>

                <section class="question-card quiz-result" id="quiz-result" aria-labelledby="result-title" tabindex="-1" hidden>
                    <span class="result-icon material-symbols-outlined" aria-hidden="true">emoji_events</span>
                    <h1 id="result-title">Kuis selesai!</h1>
                    <p class="quiz-score" id="quiz-score"></p>
                    <p id="quiz-correct"></p>
                    <p id="result-encouragement"></p>
                    <div class="result-review">
                        <h2>Yuk, pelajari pembahasannya</h2>
                        <ol id="quiz-explanations"></ol>
                    </div>
                    <div class="action-toolbar">
                        <a class="btn-prev" id="retake-quiz" href="{{ route('quiz', ['lesson' => $selectedQuizId]) }}">Coba kuis lain</a>
                        <a class="btn-submit" href="{{ route('subjects') }}">Pilih pelajaran lain</a>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>Belajar sedikit demi sedikit, lama-lama jadi hebat! 🌟</p>
        </div>
    </footer>

    @vite('resources/js/quiz.js')
</body>

</html>
