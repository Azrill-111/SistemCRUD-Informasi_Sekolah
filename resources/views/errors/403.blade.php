<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 &middot; Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-100 px-4 text-gray-900 antialiased">

    <div class="w-full max-w-md rounded-lg border border-gray-200 bg-white p-8 text-center">
        <p class="text-4xl font-semibold text-gray-900">403</p>
        <h1 class="mt-3 text-lg font-semibold text-gray-900">Akses ditolak</h1>
        <p class="mt-2 text-sm leading-relaxed text-gray-500">
            Halaman ini hanya dapat diakses oleh admin. Akun Anda tidak memiliki hak akses
            untuk membuka panel pengelolaan.
        </p>

        <a href="{{ auth()->check() ? route('informasi.index') : route('login') }}"
           class="mt-6 inline-block rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-black">
            Kembali ke Halaman Informasi
        </a>
    </div>

</body>
</html>
