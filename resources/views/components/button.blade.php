{{-- `as` lets the same styling drive <button>, <a> and the <label> toggles the calendar uses. --}}
@props(['variant' => 'primary', 'size' => 'md', 'as' => 'button', 'full' => false])

@php
    // `full` uses block-level flex so a full-width button doesn't pick up baseline leading.
    $base = ($full ? 'flex w-full' : 'inline-flex shrink-0')
        . ' cursor-pointer items-center justify-center gap-2 rounded-lg font-medium';

    $variants = [
        'primary' => 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-500',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50',
        'ghost' => 'border border-slate-300 bg-white text-slate-600 hover:border-indigo-300 hover:text-indigo-700',
    ];

    $sizes = [
        'xs' => 'px-3 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2.5 text-sm',
    ];
@endphp

<{{ $as }} {{ $attributes->class([$base, $variants[$variant], $sizes[$size]])
        ->merge($as === 'button' ? ['type' => 'button'] : []) }}>
    {{ $slot }}
</{{ $as }}>
