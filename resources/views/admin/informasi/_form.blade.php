{{--
    Form isian informasi. Dipakai oleh halaman tambah dan ubah.
    Variabel $informasi hanya ada pada halaman ubah.
--}}
@php
    $informasi = $informasi ?? null;
@endphp

<div class="space-y-5">

    <div>
        <label for="title" class="mb-1 block text-sm font-medium text-gray-700">
            Judul Informasi <span class="text-gray-400">*</span>
        </label>
        <input id="title" type="text" name="title"
               value="{{ old('title', $informasi?->title) }}"
               required maxlength="200"
               class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
               placeholder="Contoh: Jadwal Ujian Tengah Semester">
        @error('title')
            <p class="mt-1 text-xs text-gray-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="mb-1 block text-sm font-medium text-gray-700">
            Isi Informasi <span class="text-gray-400">*</span>
        </label>
        <textarea id="content" name="content" rows="12" required
                  class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm leading-relaxed text-gray-900 placeholder-gray-400 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                  placeholder="Tuliskan isi informasi secara lengkap...">{{ old('content', $informasi?->content) }}</textarea>
        <p class="mt-1 text-xs text-gray-500">Minimal 20 karakter. Tekan Enter untuk membuat paragraf baru.</p>
        @error('content')
            <p class="mt-1 text-xs text-gray-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="image" class="mb-1 block text-sm font-medium text-gray-700">
            Gambar <span class="text-gray-400">(opsional)</span>
        </label>

        <div class="flex flex-wrap items-start gap-4">
            @if ($informasi?->imageUrl())
                <img src="{{ $informasi->imageUrl() }}" alt="Gambar saat ini"
                     class="h-24 w-32 rounded-md border border-gray-200 object-cover">
            @endif

            <div class="flex-1">
                <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp"
                       class="block w-full cursor-pointer rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-600 file:mr-3 file:rounded file:border-0 file:bg-gray-900 file:px-3 file:py-2 file:text-xs file:font-medium file:text-white">
                <p class="mt-1 text-xs text-gray-500">
                    Format jpg, jpeg, png, atau webp. Maksimal 2 MB.
                    @if ($informasi?->imageUrl())
                        Biarkan kosong jika tidak ingin mengganti gambar.
                    @endif
                </p>
                @error('image')
                    <p class="mt-1 text-xs text-gray-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

</div>
