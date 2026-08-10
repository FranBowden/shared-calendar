@props(['name', 'size' => 'h-4 w-4'])

@php
    $paths = [
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" />',
        'close' => '<path d="M18 6 6 18M6 6l12 12" />',
        'sparkles' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M18.4 5.6l-2.8 2.8M8.4 15.6l-2.8 2.8" />',
        'chevron-up' => '<path d="m18 15-6-6-6 6" />',
        'chevron-left' => '<path d="m15 18-6-6 6-6" />',
        'chevron-right' => '<path d="m9 18 6-6-6-6" />',
        'arrow-right' => '<path d="m5 12 14 0M13 6l6 6-6 6" />',
        'clock' => '<circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" />',
        'link' => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" /><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />',
    ];
@endphp

<svg xmlns="http://www.w3.org/2000/svg" {{ $attributes->class([$size]) }} viewBox="0 0 24 24" fill="none"
    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $paths[$name] !!}
</svg>
