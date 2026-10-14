<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_returns_successful_response(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk');
        $response->assertSee('Buat akun');
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password_confirmation"', false);
    }

    public function test_authenticated_user_can_navigate_from_home_to_learning_pages(): void
    {
        $user = User::factory()->create(['name' => 'Ayu Learner']);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Selamat datang, Ayu Learner')
            ->assertSee(route('subjects'), false)
            ->assertSee(route('progress'), false)
            ->assertSee(route('quiz', ['lesson' => 'matematika']), false)
            ->assertSee(route('quiz', ['lesson' => 'bahasa-indonesia']), false)
            ->assertSee(route('quiz', ['lesson' => 'ipas']), false)
            ->assertSee(route('logout'), false)
            ->assertSee(asset('css/home.css'), false)
            ->assertSee(asset('asset/edu.png'), false)
            ->assertSee('home-', false);
    }

    public function test_site_opens_with_account_creation_and_login_remains_optional(): void
    {
        $this->get('/')
            ->assertRedirect(route('register'));

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Buat akun gratis')
            ->assertSee('name="password_confirmation"', false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Buat akun gratis');
    }

    public function test_guest_can_browse_learning_pages_without_registering(): void
    {
        $this->get('/')
            ->assertRedirect(route('register'));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Selamat datang di Kilas Ilmu!')
            ->assertSee('Masuk');

        $this->get(route('subjects'))->assertOk();
        $this->get(route('quiz'))->assertOk();
        $this->get(route('progress'))->assertRedirect(route('login'));
    }

    public function test_user_can_login_with_uppercase_email_and_whitespace(): void
    {
        User::query()->create([
            'name' => 'Test User',
            'email' => 'test.user@example.com',
            'password' => Hash::make('Password123'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => '  TEST.USER@EXAMPLE.COM  ',
            'password' => 'Password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticated();
    }

    public function test_login_reports_invalid_credentials_without_authenticating(): void
    {
        User::factory()->create([
            'email' => 'student@example.test',
            'password' => Hash::make('correct-password'),
        ]);

        $this->postJson(route('login.store'), [
            'email' => 'student@example.test',
            'password' => 'incorrect-password',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        $this->assertGuest();
    }

    public function test_registering_an_existing_email_prompts_the_user_to_log_in(): void
    {
        User::factory()->create([
            'email' => 'student@example.test',
        ]);

        $this->from(route('register'))
            ->followingRedirects()
            ->post(route('register.store'), [
                'name' => 'Student',
                'email' => 'student@example.test',
                'password' => 'correct-password',
                'password_confirmation' => 'correct-password',
            ])
            ->assertOk()
            ->assertSee('id="tab-login"', false)
            ->assertSee('checked', false)
            ->assertSee('Email ini sudah terdaftar. Masuk menggunakan kata sandi yang dibuat di Kilas Ilmu.');
    }

    public function test_user_can_switch_to_a_different_account_after_logging_out(): void
    {
        /** @var User $oldAccount */
        $oldAccount = User::factory()->create([
            'name' => 'Ijlal',
            'email' => 'ijlal@example.test',
        ]);
        /** @var User $newAccount */
        $newAccount = User::factory()->create([
            'name' => 'New Account',
            'email' => 'new@example.test',
            'password' => Hash::make('new-password-123'),
        ]);

        $this->actingAs($oldAccount)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Selamat datang! Ijlal')
            ->assertSee('Keluar');

        $this->actingAs($oldAccount)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();

        $this->post(route('login.store'), [
            'email' => $newAccount->email,
            'password' => 'new-password-123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($newAccount);
        $this->get(route('home'))->assertSee('Selamat datang! New Account');
    }
}
