<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;
use App\Models\User;
use App\Models\UserLearningProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class QuizResultController extends Controller
{
    private const DEFAULT_QUIZ_ID = 'literasi-digital-dasar';

    public function show(Request $request)
    {
        $quizId = $request->query('lesson');

        if (! $quizId) {
            return redirect()->route('subjects');
        }

        $quiz = config("quizzes.$quizId");
        abort_if(! $quiz, 404);

        $attemptId = (string) Str::uuid();
        $questions = $this->createQuizQuestions($request, $quizId, $quiz);
        $attempts = $request->session()->get('quiz_attempts', []);
        $attempts[$attemptId] = [
            'quiz_id' => $quizId,
            'questions' => $questions,
        ];
        $request->session()->put('quiz_attempts', array_slice($attempts, -5, null, true));

        return view('quiz', [
            'selectedQuizId' => $quizId,
            'selectedQuiz' => [...$quiz, 'questions' => $questions],
            'quizAttemptId' => $attemptId,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
            'quizId' => ['sometimes', 'string', Rule::in(array_keys(config('quizzes')))],
            'attemptId' => ['required_with:quizId', 'uuid'],
        ]);
        $quizId = $validatedRequest['quizId'] ?? self::DEFAULT_QUIZ_ID;
        $quiz = config("quizzes.$quizId");
        $attemptId = isset($validatedRequest['quizId']) ? ($validatedRequest['attemptId'] ?? null) : null;
        $attempt = $attemptId ? $request->session()->get("quiz_attempts.$attemptId") : null;

        if ($attemptId && (
            ! is_array($attempt)
            || ($attempt['quiz_id'] ?? null) !== $quizId
            || ! is_array($attempt['questions'] ?? null)
        )) {
            throw ValidationException::withMessages([
                'attemptId' => 'Kuis ini sudah tidak aktif. Buka kembali pelajarannya untuk mencoba soal baru.',
            ]);
        }

        $questions = $attemptId ? $attempt['questions'] : $quiz['questions'];

        $validated = $request->validate([
            'answers' => ['required', 'array:'.implode(',', array_keys($questions))],
            ...collect($questions)->mapWithKeys(fn (array $question, string $id) => [
                "answers.$id" => [
                    'required',
                    'string',
                    Rule::in(array_keys($question['options'])),
                ],
            ])->all(),
        ]);

        $answers = $validated['answers'];
        $correctAnswers = collect($questions)
            ->filter(fn (array $question, string $id) => $answers[$id] === $question['answer'])
            ->count();

        $result = DB::transaction(function () use ($request, $correctAnswers, $quizId, $quiz, $questions) {
            User::query()->whereKey($request->user()->id)->lockForUpdate()->firstOrFail();
            $today = today();
            $progress = UserLearningProgress::query()->firstOrCreate(
                ['user_id' => $request->user()->id],
                ['daily_goal_date' => $today],
            );

            if (! $progress->daily_goal_date || ! $progress->daily_goal_date->isSameDay($today)) {
                $progress->daily_goal_date = $today;
                $progress->daily_completed = 0;
            }

            $progress->daily_completed += count($questions);
            if (! $progress->last_active_date || ! $progress->last_active_date->isSameDay($today)) {
                $progress->current_streak = $progress->last_active_date?->isSameDay($today->copy()->subDay())
                    ? $progress->current_streak + 1
                    : 1;
                $progress->last_active_date = $today;
                $progress->max_streak = max($progress->max_streak, $progress->current_streak);
            }
            $progress->save();

            return QuizResult::query()->create([
                'user_id' => $request->user()->id,
                'quiz_id' => $quizId,
                'title' => $quiz['title'],
                'subject' => $quiz['subject'],
                'correct_answers' => $correctAnswers,
                'total_questions' => count($questions),
            ]);
        });

        if ($attemptId) {
            $request->session()->forget("quiz_attempts.$attemptId");
        }

        $explanations = collect($questions)
            ->map(fn (array $question, string $id) => [
                'correct' => $answers[$id] === $question['answer'],
                'explanation' => $question['explanation'],
            ])
            ->values();

        return response()->json([
            'result' => $this->formatResult($result),
            'explanations' => $explanations,
        ], 201);
    }

    private function createQuizQuestions(Request $request, string $quizId, array $quiz): array
    {
        $variants = collect(config("quiz_variants.$quizId", []))
            ->map(function (array $variant): array {
                [$prompt, $options, $answer, $explanation] = $variant;

                return compact('prompt', 'options', 'answer', 'explanation');
            })
            ->all();
        $questionBank = array_merge($quiz['questions'], $variants);
        $questionCount = min(20, count($questionBank));
        $previousQuestionIds = $request->session()->get("quiz_previous_question_ids.$quizId", []);
        $questionIds = array_keys($questionBank);
        shuffle($questionIds);
        $selectedQuestionIds = array_slice(
            array_values(array_diff($questionIds, $previousQuestionIds)),
            0,
            $questionCount,
        );
        $remainingCount = $questionCount - count($selectedQuestionIds);

        if ($remainingCount > 0) {
            $remainingQuestionIds = array_values(array_diff($questionIds, $selectedQuestionIds));
            shuffle($remainingQuestionIds);
            $selectedQuestionIds = array_merge(
                $selectedQuestionIds,
                array_slice($remainingQuestionIds, 0, $remainingCount),
            );
        }

        $request->session()->put("quiz_previous_question_ids.$quizId", $selectedQuestionIds);

        return collect($selectedQuestionIds)
            ->mapWithKeys(fn (string $questionId) => [$questionId => $questionBank[$questionId]])
            ->values()
            ->mapWithKeys(fn (array $question, int $index) => ['q'.($index + 1) => $question])
            ->all();
    }

    public function index(Request $request): JsonResponse
    {
        $period = $this->validatedPeriod($request);
        $now = now();
        $periodStart = $this->periodStart($period);

        $userResults = QuizResult::query()->where('user_id', $request->user()->id);
        $periodResults = (clone $userResults);
        if ($periodStart) {
            $periodResults->where('created_at', '>=', $periodStart);
        }

        $totals = (clone $periodResults)
            ->selectRaw('COUNT(*) as attempts, COALESCE(SUM(correct_answers), 0) as correct_answers, COALESCE(SUM(total_questions), 0) as total_questions, COALESCE(SUM(correct_answers * 10), 0) as total_xp')
            ->first();
        $completedModules = (clone $periodResults)->distinct()->count('quiz_id');
        $totalSubjects = (clone $periodResults)->distinct()->count('subject');
        $weeklyXp = (clone $userResults)
            ->where('created_at', '>=', $now->copy()->subDays(6)->startOfDay())
            ->sum(DB::raw('correct_answers * 10'));
        $progress = UserLearningProgress::query()->firstOrNew(['user_id' => $request->user()->id]);
        $today = today();
        $lastActiveDate = $progress->last_active_date;
        $isStreakActive = $lastActiveDate
            && (
                $lastActiveDate->isSameDay($today)
                || $lastActiveDate->isSameDay($today->copy()->subDay())
            );
        $currentStreak = $isStreakActive ? $progress->current_streak : 0;

        $activityDates = (clone $userResults)
            ->where('created_at', '>=', $now->copy()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as activity_date')
            ->distinct()
            ->orderByDesc('activity_date')
            ->limit(7)
            ->pluck('activity_date')
            ->values();

        $results = (clone $periodResults)
            ->latest('created_at')
            ->limit(100)
            ->get();
        $subjectScores = (clone $userResults)
            ->selectRaw('quiz_id, MAX(CASE WHEN total_questions > 0 THEN correct_answers * 1.0 / total_questions ELSE 0 END) as best_score, COUNT(*) as attempts')
            ->groupBy('quiz_id')
            ->get()
            ->keyBy('quiz_id');
        $subjectProgress = collect(array_keys(config('quizzes')))
            ->mapWithKeys(function (string $quizId) use ($subjectScores) {
                $score = $subjectScores->get($quizId);

                return [$quizId => [
                    'percentage' => $score ? (int) round((float) $score->best_score * 100) : 0,
                    'attempts' => $score ? (int) $score->attempts : 0,
                ]];
            });

        $totalQuestions = (int) $totals->total_questions;
        $badgeFlags = [
            'completedFirstQuiz' => (clone $userResults)->exists(),
            'hasPerfectScore' => (clone $userResults)
                ->whereColumn('correct_answers', 'total_questions')
                ->exists(),
            'consistencyChamp' => ($progress->max_streak ?? 0) >= 3,
        ];

        return response()->json([
            'results' => $results->map(fn (QuizResult $result) => $this->formatResult($result)),
            'subjectProgress' => $subjectProgress,
            'badgeFlags' => $badgeFlags,
            'stats' => [
                'totalXP' => (int) $totals->total_xp,
                'xpGainWeek' => (int) $weeklyXp,
                'lessonsCompleted' => $completedModules,
                'totalSubjects' => $totalSubjects,
                'accuracy' => $totalQuestions
                    ? (int) round(((int) $totals->correct_answers / $totalQuestions) * 100)
                    : 0,
                'pace' => min((int) round(($completedModules / 28) * 100), 100),
                'modulesCompleted' => $completedModules,
                'modulesRemaining' => max(28 - $completedModules, 0),
                'streakDays' => $currentStreak,
                'totalResults' => (int) $totals->attempts,
            ],
            'progress' => [
                'currentStreak' => $currentStreak,
                'maxStreak' => $progress->max_streak ?? 0,
                'dailyCompleted' => $progress->daily_goal_date?->isSameDay($today)
                    ? $progress->daily_completed
                    : 0,
                'activityDates' => $activityDates,
            ],
        ]);
    }

    public function export(Request $request)
    {
        $periodStart = $this->periodStart($this->validatedPeriod($request));
        $query = QuizResult::query()
            ->where('user_id', $request->user()->id)
            ->when($periodStart, fn ($query) => $query->where('created_at', '>=', $periodStart))
            ->orderBy('created_at');

        return response()->streamDownload(function () use ($query) {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['Quiz', 'Mata Pelajaran', 'Jawaban Benar', 'Jumlah Soal', 'Nilai (%)', 'Waktu Selesai'], ',', '"', '\\');

            foreach ($query->cursor() as $result) {
                fputcsv($stream, [
                    $this->safeCsvValue($result->title),
                    $this->safeCsvValue($result->subject),
                    $result->correct_answers,
                    $result->total_questions,
                    (int) round(($result->correct_answers / $result->total_questions) * 100),
                    $result->created_at->toIso8601String(),
                ], ',', '"', '\\');
            }

            fclose($stream);
        }, 'learning-progress.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function formatResult(QuizResult $result): array
    {
        return [
            'id' => $result->id,
            'quizId' => $result->quiz_id,
            'title' => $result->title,
            'subject' => $result->subject,
            'correctAnswers' => $result->correct_answers,
            'totalQuestions' => $result->total_questions,
            'completedAt' => $result->created_at->toIso8601String(),
        ];
    }

    private function validatedPeriod(Request $request): string
    {
        return $request->validate([
            'period' => ['sometimes', Rule::in(['7d', '30d', 'term', 'all'])],
        ])['period'] ?? '30d';
    }

    private function periodStart(string $period): ?Carbon
    {
        return match ($period) {
            '7d' => now()->subDays(6)->startOfDay(),
            '30d' => now()->subDays(29)->startOfDay(),
            'term' => now()->startOfYear(),
            default => null,
        };
    }

    private function safeCsvValue(string $value): string
    {
        return preg_match('/^[=+\-@\t\r]/', $value) === 1 ? "'".$value : $value;
    }
}
