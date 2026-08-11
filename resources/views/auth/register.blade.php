@extends('layouts.app')

@section('title', 'Sign up')

@section('content')
<section class="mx-auto flex max-w-md flex-col justify-center px-6 py-20">
    <h1 class="text-2xl font-bold text-slate-900">Create your account</h1>
    <p class="mt-2 text-sm text-slate-600">Takes a minute. No credit card needed.</p>

    <x-card class="mt-8" padding="p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <x-text-field label="Name" name="name" autocomplete="name" required />
            <x-text-field label="Email" name="email" type="email" autocomplete="email"
                placeholder="johnsmith@example.com" required />
            <x-text-field label="Password" name="password" type="password" autocomplete="new-password"
                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required />
            <x-text-field label="Confirm password" name="password_confirmation" type="password"
                autocomplete="new-password"
                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required />

            <x-button type="submit" size="lg" full>
                Create account
            </x-button>
        </form>
    </x-card>

    <p class="mt-6 text-center text-sm text-slate-600">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
    </p>
</section>
@endsection
