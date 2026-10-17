<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk &middot; {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4 py-10 text-gray-900 antialiased">

    <div class="w-full max-w-sm">

        <div class="mb-6 text-center">
            <span class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-md bg-gray-900 text-xs font-semibold text-white">
                SI
            </span>
            <h1 class="text-lg font-semibold text-gray-900">{{ config('app.name') }}</h1>
            <p class="mt-1 text-sm text-gray-500">Masuk untuk melihat informasi sekolah</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">

            @include('partials.alert')

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                           placeholder="nama@sekolah.test">
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                           placeholder="••••••••">
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" value="1"
                           class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                    Ingat saya
                </label>

                <button type="submit"
                        class="w-full rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-black">
                    Masuk
                </button>
            </form>
        </div>
    </div>

</body>
</html>
