{{--
    Menampilkan pesan sukses/gagal secara seragam di semua halaman.
--}}
@if (session('success'))
    <div class="mb-6 rounded-md border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 shadow-sm">
        <span class="font-semibold text-gray-900">Berhasil.</span> {{ session('success') }}
    </div>
@endif

@if (session('status'))
    <div class="mb-6 rounded-md border border-gray-200 bg-gray-100 px-4 py-3 text-sm text-gray-700">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-md border border-gray-300 bg-white px-4 py-3 text-sm text-gray-700">
        <p class="font-semibold text-gray-900">Periksa kembali isian Anda:</p>
        <ul class="mt-2 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
