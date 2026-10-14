<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizProgressTest extends TestCase
{
    use RefreshDatabase;

    public function test_quiz_results_are_saved_and_scoped_to_the_authenticated_user(): void
    {
        $student = User::factory()->create();
        $anotherStudent = User::factory()->create();

        $this->actingAs($student)
            ->postJson(route('quiz.results.store'), [
                'correctAnswers' => 0,
                'answers' => [
                    'q1' => 'manager',
                    'q2' => 'url',
                    'q3' => 'https',
                    'q4' => 'mfa',
                    'q5' => 'official',
                ],
            ])
            ->assertCreated()
            ->assertJsonPath('result.correctAnswers', 5)
            ->assertJsonPath('result.totalQuestions', 5);

        $this->assertDatabaseHas('quiz_results', [
            'user_id' => $student->id,
            'correct_answers' => 5,
            'total_questions' => 5,
        ]);

        $export = $this->actingAs($student)->get(route('progress.export', ['period' => 'all']));
        $export->assertOk();
        $this->assertStringContainsString('Dasar Literasi Digital', $export->streamedContent());

        $this->actingAs($student)
            ->getJson(route('progress.data'))
            ->assertOk()
            ->assertJsonPath('stats.totalResults', 1)
            ->assertJsonPath('progress.dailyCompleted', 5)
            ->assertJsonPath('progress.currentStreak', 1)
            ->assertJsonCount(1, 'progress.activityDates');

        $this->actingAs($anotherStudent)
            ->getJson(route('progress.data'))
            ->assertOk()
            ->assertJsonPath('stats.totalResults', 0)
            ->assertJsonCount(0, 'results');
    }

    public function test_quiz_result_cannot_be_submitted_without_authentication(): void
    {
        $this->postJson(route('quiz.results.store'), [
            'answers' => [
                'q1' => 'manager',
                'q2' => 'url',
                'q3' => 'https',
                'q4' => 'mfa',
                'q5' => 'official',
            ],
        ])->assertUnauthorized();
    }

    public function test_quiz_answers_are_validated_before_saving(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->postJson(route('quiz.results.store'), [
                'answers' => [
                    'q1' => 'not-a-valid-answer',
                    'q2' => 'url',
                    'q3' => 'https',
                    'q4' => 'mfa',
                    'q5' => 'official',
                ],
            ])
            ->assertUnprocessable();

        $this->assertDatabaseCount('quiz_results', 0);
    }

    public function test_subject_quiz_requires_a_current_quiz_attempt(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)
            ->postJson(route('quiz.results.store'), [
                'quizId' => 'matematika',
                'attemptId' => '00000000-0000-4000-8000-000000000000',
                'answers' => [],
            ])
            ->assertUnprocessable();

        $this->assertDatabaseCount('quiz_results', 0);
    }

    public function test_each_subject_has_its_own_quiz_and_results_are_scored_from_its_questions(): void
    {
        $student = User::factory()->create();
        $quizzes = collect(config('quizzes'))->except('literasi-digital-dasar');

        $this->actingAs($student)
            ->get(route('quiz'))
            ->assertRedirect(route('subjects'));

        $subjectsPage = $this->get(route('subjects'));
        $subjectsPage->assertSee('Yuk, pelajari materinya');
        $this->assertSame(8, substr_count($subjectsPage->getContent(), 'Yuk, pelajari materinya'));
        foreach ($quizzes as $quizId => $quiz) {
            $subjectsPage->assertSee(route('quiz', ['lesson' => $quizId]), false);
        }

        $initialProgress = $this->getJson(route('progress.data', ['period' => 'all']));
        foreach ($quizzes as $quizId => $quiz) {
            $initialProgress->assertJsonPath("subjectProgress.$quizId.percentage", 0)
                ->assertJsonPath("subjectProgress.$quizId.attempts", 0);
        }

        foreach ($quizzes as $quizId => $quiz) {
            $this->assertCount(20, $quiz['questions']);

            $firstQuizPage = $this->get(route('quiz', ['lesson' => $quizId]))
                ->assertOk()
                ->assertSee($quiz['title']);
            $attempts = $this->app['session.store']->get('quiz_attempts');
            $firstAttemptId = array_key_last($attempts);
            $firstQuestions = $attempts[$firstAttemptId]['questions'];
            $firstQuizPage->assertSee($firstQuestions['q1']['prompt'])
                ->assertSee($firstQuestions['q20']['prompt']);

            $answers = collect($firstQuestions)
                ->mapWithKeys(fn (array $question, string $questionId) => [$questionId => $question['answer']])
                ->all();

            $this->postJson(route('quiz.results.store'), [
                'quizId' => $quizId,
                'attemptId' => $firstAttemptId,
                'answers' => $answers,
            ])
                ->assertCreated()
                ->assertJsonPath('result.quizId', $quizId)
                ->assertJsonPath('result.title', $quiz['title'])
                ->assertJsonPath('result.correctAnswers', count($firstQuestions))
                ->assertJsonPath('result.totalQuestions', count($firstQuestions));

            $secondQuizPage = $this->get(route('quiz', ['lesson' => $quizId]))
                ->assertOk();
            $attempts = $this->app['session.store']->get('quiz_attempts');
            $secondAttemptId = array_key_last($attempts);
            $secondQuestions = $attempts[$secondAttemptId]['questions'];
            $this->assertCount(10, array_intersect(
                array_map('serialize', $firstQuestions),
                array_map('serialize', $secondQuestions),
            ), "Unexpected question overlap for $quizId.");
            $secondQuizPage->assertSee($secondQuestions['q1']['prompt'])
                ->assertSee($secondQuestions['q20']['prompt']);

            $secondAnswers = collect($secondQuestions)
                ->mapWithKeys(fn (array $question, string $questionId) => [$questionId => $question['answer']])
                ->all();

            $this->postJson(route('quiz.results.store'), [
                'quizId' => $quizId,
                'attemptId' => $secondAttemptId,
                'answers' => $secondAnswers,
            ])
                ->assertCreated()
                ->assertJsonPath('result.correctAnswers', count($secondQuestions))
                ->assertJsonPath('result.totalQuestions', count($secondQuestions));
        }

        $this->assertDatabaseCount('quiz_results', $quizzes->count() * 2);

        $subjectProgress = $this->getJson(route('progress.data', ['period' => 'all']));
        foreach ($quizzes as $quizId => $quiz) {
            $subjectProgress->assertJsonPath("subjectProgress.$quizId.percentage", 100)
                ->assertJsonPath("subjectProgress.$quizId.attempts", 2);
        }
    }

    public function test_registration_creates_a_user_and_signs_them_in(): void
    {
        $this->post(route('register.store'), [
            'name' => 'New Student',
            'email' => 'student@example.test',
            'password' => 'safe-password-123',
            'password_confirmation' => 'safe-password-123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'student@example.test']);
    }
}
