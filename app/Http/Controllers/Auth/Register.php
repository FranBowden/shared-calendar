<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class Register extends Controller
{
    /**
     * Handle incoming registration requests
     * @param Request $request 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $validated = $this->ValidatePassword($request);
        $user = User::create($validated);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('calendar');
    }

    /**
     * Validation for passwords
     * @param Request $request
     * @return array
     */
    private function ValidatePassword(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
    }
}
