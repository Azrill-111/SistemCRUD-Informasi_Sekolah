<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Informasi') &middot; {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen flex-col bg-gray-50 text-gray-900 antialiased">

    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex w-full max-w-5xl flex-wrap items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('informasi.index') }}" class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-md bg-gray-900 text-xs font-semibold text-white">
                    SI
                </span>
                <span class="leading-tight">
                    <span class="block text-sm font-semibold text-gray-900">{{ config('app.name') }}</span>
                </span>
            </a>

            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('informasi.index') }}"
                   class="rounded-md px-3 py-2 transition {{ request()->routeIs('informasi.*') ? 'bg-gray-100 font-medium text-gray-900' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    Informasi
                </a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="rounded-md border border-gray-300 px-3 py-2 text-gray-700 transition hover:bg-gray-100">
                        Dashboard Admin
                    </a>
                @endif

                <span class="hidden text-gray-300 sm:inline">|</span>

                <span class="hidden text-xs text-gray-500 sm:inline">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-md border border-gray-300 px-3 py-2 text-gray-700 transition hover:bg-gray-900 hover:text-white">
                        Keluar
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-8">
        @include('partials.alert')

        @yield('content')
    </main>

    <footer class="border-t border-gray-200 bg-white">
        <div class="mx-auto w-full max-w-5xl px-4 py-6 text-xs text-gray-500">
            &copy; {{ now()->year }} {{ config('app.name') }}. Seluruh informasi ditampilkan dari basis data sekolah.
        </div>
    </footer>

</body>
</html>
