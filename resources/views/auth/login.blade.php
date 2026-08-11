@extends('layouts.app')

@section('title', 'Log in')

@section('content')
<section class="mx-auto flex max-w-md flex-col justify-center px-6 py-20">
    <h1 class="text-2xl font-bold text-slate-900">Welcome back</h1>
    <p class="mt-2 text-sm text-slate-600">Log in to see what everyone's planning.</p>

    <x-card class="mt-8" padding="p-8">
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <x-text-field label="Email" name="email" type="email" autocomplete="email"
                placeholder="johnsmith@example.com" required />
            <x-text-field label="Password" name="password" type="password" autocomplete="current-password"
                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required />

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1"
                    class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-400" />
                Remember me
            </label>

            <x-button type="submit" size="lg" full>
                Log in
            </x-button>
        </form>
    </x-card>

    <p class="mt-6 text-center text-sm text-slate-600">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Sign up</a>
    </p>
</section>
@endsection
