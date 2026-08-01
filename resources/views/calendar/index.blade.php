@extends('layouts.app')

@section('title', 'Calendar')

@php
/**
 * Deal with this later, will need to hide calendar until user login
 */
    $month = \Carbon\Carbon::now()->startOfMonth();
    $startOffset = $month->copy()->dayOfWeekIso % 7; 
    $daysInMonth = $month->daysInMonth;
    $today = \Carbon\Carbon::now()->day;
@endphp

@section('content')
    <section class="mx-auto max-w-5xl px-6 py-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-500 hover:bg-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <h1 class="text-xl font-semibold text-slate-900 w-40 text-center">{{ $month->format('F Y') }}</h1>
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-500 hover:bg-slate-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
            <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Add event
            </button>
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wide text-slate-500">{{ $day }}</div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                @for ($i = 0; $i < $startOffset; $i++)
                    <div class="h-24 border-b border-r border-slate-100 bg-slate-50/50"></div>
                @endfor

                @for ($day = 1; $day <= $daysInMonth; $day++)
                    <div class="h-24 border-b border-r border-slate-100 p-2 last:border-r-0">
                        <span @class([
                            'inline-flex h-6 w-6 items-center justify-center rounded-full text-sm',
                            'bg-indigo-600 text-white font-medium' => $day === $today,
                            'text-slate-700' => $day !== $today,
                        ])>{{ $day }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </section>
@endsection
