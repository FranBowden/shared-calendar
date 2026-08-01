@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="relative flex min-h-[calc(100vh-137px)] items-center overflow-hidden">
    <div class="pointer-events-none absolute -top-40 -right-40 h-96 w-96 rounded-full bg-indigo-100 blur-3xl"></div>
    <div class="pointer-events-none absolute top-20 -left-32 h-72 w-72 rounded-full bg-amber-100 blur-3xl"></div>

    <div class="relative mx-auto grid max-w-6xl gap-16 px-6 py-24 lg:grid-cols-2 lg:items-center">
        <div>

            <h1 class="mt-6 text-5xl font-bold tracking-tight text-slate-900">
                Plans stop living in group chats.
            </h1>
            <p class="mt-6 max-w-md text-lg text-slate-600">
                Together is the one calendar everyone can see, add a plan once and
                it's on everyone's radar, no more "wait, are we still doing this?"
            </p>
            <div class="mt-10 flex items-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-500">
                    Get started free
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-6 py-3 text-base font-medium text-slate-700 hover:bg-slate-50">
                    Log in
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="rotate-2 rounded-2xl border border-slate-200 bg-white p-5 shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-slate-900">August 2026</span>
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-600 text-xs font-medium text-white">1</span>
                </div>
                <div class="mt-4 grid grid-cols-7 gap-1 text-center text-xs text-slate-400">
                    <span>S</span><span>M</span><span>T</span><span>W</span><span>T</span><span>F</span><span>S</span>
                </div>
                <div class="mt-2 grid grid-cols-7 gap-1">
                    @for ($i = 0; $i < 31; $i++)
                        <div @class([ 'h-8 rounded-md flex items-center justify-center text-xs' , 'bg-indigo-600 text-white font-semibold'=> $i === 0,
                        'bg-amber-100 text-amber-700 font-medium' => $i === 8,
                        'bg-rose-100 text-rose-700 font-medium' => $i === 14,
                        'text-slate-500' => ! in_array($i, [0, 8, 14]),
                        ])>{{ $i + 1 }}</div>
                @endfor
            </div>
        </div>

        <div class="absolute -bottom-6 -left-6 -rotate-3 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-lg">
            <p class="text-xs font-medium text-slate-400">Sat, Aug 15</p>
            <p class="text-sm font-semibold text-slate-900">🎂 Mum's birthday dinner</p>
        </div>
    </div>
    </div>
</section>
@endsection