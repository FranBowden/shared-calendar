{{-- Square icon-only control. `subtle` is for use on the tinted assistant panel, where slate-100 doesn't read. --}}
@props(['variant' => 'ghost', 'size' => 'h-8 w-8', 'as' => 'button'])

@php
    $base = 'inline-flex shrink-0 cursor-pointer items-center justify-center rounded-lg';

    $variants = [
        'ghost' => 'text-slate-400 hover:bg-slate-100 hover:text-slate-600',
        'subtle' => 'text-slate-400 hover:bg-white hover:text-slate-600',
        'outline' => 'border border-slate-300 bg-white text-slate-500 hover:bg-slate-50',
    ];
@endphp

<{{ $as }} {{ $attributes->class([$base, $variants[$variant], $size])
        ->merge($as === 'button' ? ['type' => 'button'] : []) }}>
    {{ $slot }}
</{{ $as }}>
