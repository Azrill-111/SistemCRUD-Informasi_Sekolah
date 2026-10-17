<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') &middot; {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 antialiased">

    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-md bg-gray-900 text-xs font-semibold text-white">
                    SI
                </span>
                <span class="leading-tight">
                    <span class="block text-sm font-semibold text-gray-900">{{ config('app.name') }}</span>
                    <span class="block text-xs text-gray-500">Panel Admin</span>
                </span>
            </a>

            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('informasi.index') }}" target="_blank"
                   class="hidden rounded-md border border-gray-300 px-3 py-2 text-gray-700 transition hover:bg-gray-100 sm:inline-block">
                    Lihat Halaman User
                </a>

                <span class="hidden text-xs text-gray-500 sm:inline">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-md border border-gray-300 px-3 py-2 text-gray-700 transition hover:bg-gray-900 hover:text-white">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-4 py-8 md:flex-row">

        <aside class="md:w-56 md:shrink-0">
            <nav class="flex gap-1 overflow-x-auto md:flex-col md:overflow-visible">
                <a href="{{ route('admin.dashboard') }}"
                   class="whitespace-nowrap rounded-md px-3 py-2 text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 font-medium text-white' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.informasi.index') }}"
                   class="whitespace-nowrap rounded-md px-3 py-2 text-sm transition {{ request()->routeIs('admin.informasi.index', 'admin.informasi.show', 'admin.informasi.edit') ? 'bg-gray-900 font-medium text-white' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
                    Data Informasi
                </a>
                <a href="{{ route('admin.informasi.create') }}"
                   class="whitespace-nowrap rounded-md px-3 py-2 text-sm transition {{ request()->routeIs('admin.informasi.create') ? 'bg-gray-900 font-medium text-white' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
                    Tambah Informasi
                </a>
            </nav>
        </aside>

        <main class="min-w-0 flex-1">
            <div class="mb-6">
                <h1 class="text-lg font-semibold text-gray-900">@yield('heading', 'Dashboard')</h1>
                <p class="mt-1 text-sm text-gray-500">@yield('subheading')</p>
            </div>

            @include('partials.alert')

            @yield('content')
        </main>
    </div>

</body>
</html>
