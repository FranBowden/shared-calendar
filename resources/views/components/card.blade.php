@props(['variant' => 'default', 'padding' => 'p-4'])

@php
    $variants = [
        'default' => 'border-slate-200 bg-white',
        'tinted' => 'border-indigo-100 bg-indigo-50/60',
    ];
@endphp

<div {{ $attributes->class(['rounded-2xl border', $variants[$variant], $padding]) }}>
    {{ $slot }}
</div>
