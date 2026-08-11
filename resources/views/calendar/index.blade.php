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
        {{-- Drives the connect-apps drawer below purely with CSS (peer-checked) --}}
        <input type="checkbox" id="connect-apps" class="peer/apps sr-only">

        <div
            class="invisible fixed inset-0 z-40 bg-slate-900/30 opacity-0 transition-opacity peer-checked/apps:visible peer-checked/apps:opacity-100">
            <label for="connect-apps" class="block h-full w-full cursor-default" aria-label="Close connected apps"></label>
        </div>

        <aside
            class="fixed inset-y-0 right-0 z-50 flex w-80 max-w-full translate-x-full flex-col border-l border-slate-200 bg-white shadow-xl transition-transform duration-300 peer-checked/apps:translate-x-0">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-slate-900">Connect your calendars</h2>
                <x-icon-button as="label" for="connect-apps" aria-label="Close connected apps">
                    <x-icon name="close" />
                </x-icon-button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-5">
                <p class="text-sm text-slate-500">
                    Bring events in from the calendars you already use. Nothing is shared until you say so.
                </p>

                <ul class="mt-5 space-y-3">
                    @php
                        $providers = [
                            ['name' => 'Google Calendar', 'detail' => 'Gmail or Workspace account', 'color' => 'text-blue-600'],
                            ['name' => 'Outlook', 'detail' => 'Microsoft 365 or Outlook.com', 'color' => 'text-sky-600'],
                            ['name' => 'Apple Calendar', 'detail' => 'iCloud account', 'color' => 'text-slate-700'],
                        ];
                    @endphp

                    @foreach ($providers as $provider)
                        <li class="flex items-center gap-3 rounded-xl border border-slate-200 p-3">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-50 {{ $provider['color'] }}">
                                <x-icon name="calendar" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $provider['name'] }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $provider['detail'] }}</p>
                            </div>
                            <x-button variant="secondary" size="xs">Connect</x-button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="border-t border-slate-200 px-5 py-4">
                <p class="text-xs text-slate-400">You can disconnect an account at any time from settings.</p>
            </div>
        </aside>

        {{-- Whole assistant collapses away for people who don't want it --}}
        <input type="checkbox" id="assistant-open" class="peer/assistant sr-only" checked>

        <div class="mb-6 peer-checked/assistant:hidden">
            <x-button as="label" for="assistant-open" variant="ghost" size="sm">
                <x-icon name="sparkles" />
                Ask the assistant
            </x-button>
        </div>

        <div class="hidden peer-checked/assistant:block">
            <x-card variant="tinted" class="mb-6">
                <div class="flex items-start gap-3">
                    <span
                        class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-white">
                        <x-icon name="sparkles" />
                    </span>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <label for="assistant-prompt" class="text-sm font-medium text-slate-900">
                                    Ask the assistant
                                </label>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    Describe it in plain English &mdash; repeats, dates and times all work.
                                </p>
                            </div>
                            <x-icon-button as="label" for="assistant-open" variant="subtle" size="h-7 w-7"
                                title="Hide assistant">
                                <x-icon name="chevron-up" />
                            </x-icon-button>
                        </div>

                        <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                            <input type="text" id="assistant-prompt"
                                placeholder="e.g. Football training every Monday at 6pm for the next 5 weeks"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <x-button as="label" for="ai-preview">
                                <x-icon name="arrow-right" />
                                Create
                            </x-button>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach (['Dinner with Mum on Sunday', 'Gym Tue + Thu at 7am for a month', 'Block out 12&ndash;1pm every weekday'] as $example)
                                <button type="button"
                                    class="rounded-full border border-slate-300 bg-white px-3 py-1 text-xs text-slate-600 hover:border-indigo-300 hover:text-indigo-700">
                                    {!! $example !!}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Reveals the mock preview below (UI only, no parsing yet) --}}
            <input type="checkbox" id="ai-preview" class="peer/ai sr-only">

            {{-- Confirmation step: the assistant never writes to the calendar unprompted --}}
            <x-card class="mb-6 hidden peer-checked/ai:block">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Here&rsquo;s what I&rsquo;ll add</h3>
                        <p class="mt-0.5 text-xs text-slate-500">5 events &middot; repeats weekly &middot; review before confirming</p>
                    </div>
                    <x-icon-button as="label" for="ai-preview" aria-label="Discard preview">
                        <x-icon name="close" />
                    </x-icon-button>
                </div>

                <ul class="mt-4 divide-y divide-slate-100 rounded-xl border border-slate-200">
                    @php
                        // Placeholder rows so the preview reads realistically until parsing exists.
                        $preview = collect(range(0, 4))->map(
                            fn($week) => \Carbon\Carbon::now()->next(\Carbon\Carbon::MONDAY)->addWeeks($week),
                        );
                    @endphp

                    @foreach ($preview as $date)
                        <li class="flex items-center gap-3 px-3 py-2.5">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                <x-icon name="clock" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-900">Football training</p>
                                <p class="truncate text-xs text-slate-500">{{ $date->format('D j M') }} &middot; 6:00pm &ndash; 7:00pm</p>
                            </div>
                            <button type="button" class="shrink-0 text-xs font-medium text-slate-400 hover:text-rose-600">
                                Remove
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4 flex items-center justify-end gap-2">
                    <x-button as="label" for="ai-preview" variant="secondary" size="sm">Discard</x-button>
                    <x-button>Add 5 events</x-button>
                </div>
            </x-card>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-icon-button variant="outline" size="h-9 w-9" aria-label="Previous month">
                    <x-icon name="chevron-left" />
                </x-icon-button>
                <h1 class="text-xl font-semibold text-slate-900 w-40 text-center">{{ $month->format('F Y') }}</h1>
                <x-icon-button variant="outline" size="h-9 w-9" aria-label="Next month">
                    <x-icon name="chevron-right" />
                </x-icon-button>
            </div>

            <x-button as="label" for="connect-apps" variant="secondary" size="sm">
                <x-icon name="link" />
                Connect apps
            </x-button>
        </div>

        <x-card class="mt-6 overflow-hidden" padding="">
            <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="px-3 py-2 text-center text-xs font-medium uppercase tracking-wide text-slate-500">
                        {{ $day }}</div>
                @endforeach
            </div>

            <div class="grid grid-cols-7">
                @for ($i = 0; $i < $startOffset; $i++)
                    <div class="h-24 border-b border-r border-slate-100 bg-slate-50/50"></div>
                @endfor

                @for ($day = 1; $day <= $daysInMonth; $day++)
                    <div id="day-{{ $day }}" class="h-24 border-b border-r border-slate-100 p-2 last:border-r-0">
                        <span @class([
                            'inline-flex h-6 w-6 items-center justify-center rounded-full text-sm',
                            'bg-indigo-600 text-white font-medium' => $day === $today,
                            'text-slate-700' => $day !== $today,
                        ])>{{ $day }}</span>
                    </div>
                @endfor
            </div>
        </x-card>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const daysInMonth = {{ $daysInMonth }};

        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.getElementById(`day-${day}`);

            dayElement.addEventListener('click', function(e) {
                if (e.target !== dayElement) return;

                if (dayElement.querySelector('.add-event-label')) return;

                const addEventLabel = document.createElement('div');
                addEventLabel.classList.add('add-event-label', 'mt-2', 'w-full', 'text-sm',
                    'text-slate-700');

                const input = document.createElement('input');
                input.type = 'text';
                input.placeholder = 'Add event';
                input.classList.add('mt-2', 'w-full', 'border', 'border-slate-300', 'rounded', 'px-2',
                    'py-1', 'text-sm', 'text-slate-700');

                input.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                addEventLabel.appendChild(input);
                dayElement.appendChild(addEventLabel);
                input.focus();
            });
        }

    });
</script>
@endpush
