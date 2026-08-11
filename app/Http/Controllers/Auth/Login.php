<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Auth\Constants;

class Login extends Controller
{
    /**
     * Handle Login Request
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $this->ensureIsNotRateLimited($request);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request), Constants::DECAY_SECONDS);
            throw ValidationException::withMessages([
                'email' => 'Those credentials don\'t match our records.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        return redirect()->intended(route('calendar'));
    }

    /**
     * Block further attempts once this email/IP pair has failed too often.
     */
    private function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), Constants::MAX_ATTEMPTS)) {
            return;
        }

        event(new Lockout($request));
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        throw ValidationException::withMessages([
            'email' => sprintf(
                'Too many login attempts. Please try again in %d %s.',
                $seconds,
                Str::plural('second', $seconds),
            ),
        ]);
    }

    /**
     * Throttle per email + IP, so one attacker cannot lock out a real user
     * by hammering their address from elsewhere.
     */
    private function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower($request->string('email')) . '|' . $request->ip()
        );
    }
}
