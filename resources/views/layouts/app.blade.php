<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Together') &middot; {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 antialiased flex flex-col">
    <nav class="border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto max-w-6xl px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white">
                    <x-icon name="calendar" size="h-5 w-5" />
                </span>
                Together
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('calendar') }}"
                        class="text-sm font-medium text-slate-600 hover:text-slate-900">Calendar</a>
                    <span class="text-sm text-slate-400">{{ auth()->user()->name }}</span>

                    {{-- Logging out changes state, so it's a POST form rather than a link. --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button type="submit" variant="secondary">Log out</x-button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-slate-600 hover:text-slate-900">Log in</a>
                    <x-button as="a" href="{{ route('register') }}">Sign up</x-button>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 py-6 text-center text-sm text-slate-400">
        &copy; {{ date('Y') }} Together
    </footer>

    @stack('scripts')
</body>

</html>
