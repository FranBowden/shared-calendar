@extends('layouts.app')

@section('title', 'Sign up')

@section('content')
<section class="mx-auto flex max-w-md flex-col justify-center px-6 py-20">
    <h1 class="text-2xl font-bold text-slate-900">Create your account</h1>
    <p class="mt-2 text-sm text-slate-600">Takes a minute. No credit card needed.</p>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-8">
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700">Name</label>
                <input type="text" placeholder="John Smith" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-100" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" placeholder="johnsmith@example.com" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-100" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Password</label>
                <input type="password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-100" />
            </div>

            <a href="{{ route('calendar') }}" class="block w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
                Create account
            </a>
        </div>
    </div>

    <p class="mt-6 text-center text-sm text-slate-600">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
    </p>
</section>
@endsection