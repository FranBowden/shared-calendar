<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_reach_the_calendar(): void
    {
        $this->get('/calendar')->assertRedirect('/login');
    }

    public function test_the_auth_pages_render_with_a_csrf_token(): void
    {
        $this->get('/login')->assertOk()->assertSee('_token', false);
        $this->get('/register')->assertOk()->assertSee('name="password_confirmation"', false);
    }

    public function test_validation_errors_render_inline_and_keep_old_input(): void
    {
        $this->from('/register')
            ->followingRedirects()
            ->post('/register', ['name' => 'Fran', 'email' => 'not-an-email', 'password' => 'x'])
            ->assertSee('must be a valid email address', false)
            ->assertSee('value="Fran"', false);
    }

    public function test_a_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
            'password_confirmation' => 'open-sesame-1234',
        ]);

        $response->assertRedirect('/calendar');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'fran@example.com']);
    }

    public function test_the_stored_password_is_hashed(): void
    {
        $this->post('/register', [
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
            'password_confirmation' => 'open-sesame-1234',
        ]);

        $this->assertNotSame('open-sesame-1234', User::first()->password);
    }

    public function test_registration_requires_a_matching_confirmation(): void
    {
        $this->post('/register', [
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
            'password_confirmation' => 'something-else',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_a_user_can_log_in(): void
    {
        User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        $response = $this->post('/login', [
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        $response->assertRedirect('/calendar');
        $this->assertAuthenticated();
    }

    public function test_a_wrong_password_is_rejected(): void
    {
        User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        $this->post('/login', [
            'email' => 'fran@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_user_can_log_out(): void
    {
        $user = User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        $this->actingAs($user)->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_login_locks_out_after_repeated_failures(): void
    {
        User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        foreach (range(1, 5) as $attempt) {
            $this->post('/login', [
                'email' => 'fran@example.com',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        // The sixth attempt is refused before the password is even checked,
        // so even the correct password is rejected while locked out.
        $this->post('/login', [
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ])->assertSessionHasErrors('email');

        // The message carries a live countdown, so match the wording only.
        $this->assertStringContainsString(
            'Too many login attempts.',
            session('errors')->first('email')
        );

        $this->assertGuest();
    }

    public function test_lockout_fires_an_event(): void
    {
        Event::fake([Lockout::class]);

        foreach (range(1, 6) as $attempt) {
            $this->post('/login', [
                'email' => 'fran@example.com',
                'password' => 'wrong-password',
            ]);
        }

        Event::assertDispatched(Lockout::class);
    }

    public function test_a_successful_login_clears_the_throttle(): void
    {
        User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        foreach (range(1, 4) as $attempt) {
            $this->post('/login', ['email' => 'fran@example.com', 'password' => 'nope']);
        }

        $this->post('/login', [
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ])->assertRedirect('/calendar');

        $this->assertSame(0, RateLimiter::attempts('fran@example.com|127.0.0.1'));
    }

    public function test_the_throttle_is_scoped_to_the_email(): void
    {
        foreach (range(1, 5) as $attempt) {
            $this->post('/login', ['email' => 'someone@example.com', 'password' => 'nope']);
        }

        User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        // A different email is unaffected by the first address's lockout.
        $this->post('/login', [
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ])->assertRedirect('/calendar');
    }

    public function test_registration_is_throttled_per_ip(): void
    {
        // These have to fail validation: a successful registration logs the
        // session in, and the `guest` middleware then bounces every later
        // POST before the throttle ever sees it.
        foreach (range(1, 6) as $i) {
            $this->post('/register', [
                'name' => "User {$i}",
                'email' => 'not-an-email',
                'password' => 'open-sesame-1234',
                'password_confirmation' => 'open-sesame-1234',
            ])->assertSessionHasErrors('email');
        }

        $this->post('/register', [
            'name' => 'Seven',
            'email' => 'seven@example.com',
            'password' => 'open-sesame-1234',
            'password_confirmation' => 'open-sesame-1234',
        ])->assertStatus(429);
    }

    public function test_logged_in_users_are_pushed_off_the_login_page(): void
    {
        $user = User::create([
            'name' => 'Fran',
            'email' => 'fran@example.com',
            'password' => 'open-sesame-1234',
        ]);

        $this->actingAs($user)->get('/login')->assertRedirect('/calendar');
    }
}
