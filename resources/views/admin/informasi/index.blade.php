@extends('layouts.admin')

@section('title', 'Data Informasi')
@section('heading', 'Data Informasi')
@section('subheading', 'Kelola seluruh informasi sekolah: tambah, ubah, lihat, dan hapus.')

@section('content')

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.informasi.index') }}" class="flex w-full gap-2 sm:w-auto">
            <input type="search" name="q" value="{{ $keyword }}"
                   placeholder="Cari judul atau isi..."
                   class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900 sm:w-72">
            <button type="submit"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-900 hover:text-white">
                Cari
            </button>
            @if ($keyword)
                <a href="{{ route('admin.informasi.index') }}"
                   class="rounded-md px-3 py-2 text-sm text-gray-500 transition hover:text-gray-900">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.informasi.create') }}"
           class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-black">
            + Tambah Informasi
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <th class="px-5 py-3 font-medium">No</th>
                        <th class="px-5 py-3 font-medium">Informasi</th>
                        <th class="px-5 py-3 font-medium">Dibuat</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($informasis as $informasi)
                        <tr class="border-b border-gray-100 last:border-b-0">
                            <td class="px-5 py-4 text-gray-500">
                                {{ $informasis->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-start gap-3">
                                    @if ($informasi->imageUrl())
                                        <img src="{{ $informasi->imageUrl() }}" alt=""
                                             class="h-10 w-10 shrink-0 rounded object-cover">
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-900">{{ $informasi->title }}</p>
                                        <p class="mt-1 text-xs leading-relaxed text-gray-500">
                                            {{ $informasi->excerpt(90) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-xs text-gray-500">
                                {{ $informasi->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex items-center justify-end gap-2 text-xs">
                                    <a href="{{ route('admin.informasi.show', $informasi) }}"
                                       class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 transition hover:bg-gray-100">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.informasi.edit', $informasi) }}"
                                       class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 transition hover:bg-gray-100">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.informasi.destroy', $informasi) }}"
                                          onsubmit="return confirm('Hapus informasi ini? Data akan hilang dari halaman user.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-md border border-gray-900 bg-gray-900 px-3 py-1.5 font-medium text-white transition hover:bg-black">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center">
                                <p class="text-sm font-medium text-gray-900">Belum ada data informasi</p>
                                <p class="mt-1 text-sm text-gray-500">
                                    @if ($keyword)
                                        Tidak ada data yang cocok dengan kata kunci &ldquo;{{ $keyword }}&rdquo;.
                                    @else
                                        Klik &ldquo;Tambah Informasi&rdquo; untuk membuat data pertama.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($informasis->hasPages())
        <div class="mt-4">
            {{ $informasis->links() }}
        </div>
    @endif

@endsection
