@extends('layouts.app')

@section('title', 'Daftar Informasi')

@section('content')

    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Informasi Sekolah</h1>
            <p class="mt-1 text-sm text-gray-500">
                Menampilkan {{ $informasis->total() }} informasi terbaru dari basis data sekolah.
            </p>
        </div>

        <form method="GET" action="{{ route('informasi.index') }}" class="flex w-full gap-2 sm:w-auto">
            <input type="search" name="q" value="{{ $keyword }}"
                   placeholder="Cari informasi..."
                   class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 outline-none transition focus:border-gray-900 focus:ring-1 focus:ring-gray-900 sm:w-64">
            <button type="submit"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-900 hover:text-white">
                Cari
            </button>
        </form>
    </div>

    @forelse ($informasis as $informasi)
        <article class="mb-4 overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300">
            <div class="flex flex-col sm:flex-row">
                @if ($informasi->imageUrl())
                    <img src="{{ $informasi->imageUrl() }}" alt="{{ $informasi->title }}"
                         class="h-40 w-full object-cover sm:h-auto sm:w-48">
                @endif

                <div class="flex-1 p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        {{ $informasi->created_at->translatedFormat('d F Y') }}
                    </p>

                    <h2 class="mt-1 text-base font-semibold text-gray-900">
                        <a href="{{ route('informasi.show', $informasi) }}" class="hover:underline">
                            {{ $informasi->title }}
                        </a>
                    </h2>

                    <p class="mt-2 text-sm leading-relaxed text-gray-600">
                        {{ $informasi->excerpt(180) }}
                    </p>

                    <a href="{{ route('informasi.show', $informasi) }}"
                       class="mt-3 inline-block text-sm font-medium text-gray-900 underline underline-offset-4 hover:text-gray-600">
                        Baca selengkapnya
                    </a>
                </div>
            </div>
        </article>
    @empty
        <div class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-12 text-center">
            <p class="text-sm font-medium text-gray-900">Belum ada informasi</p>
            <p class="mt-1 text-sm text-gray-500">
                @if ($keyword)
                    Tidak ada informasi yang cocok dengan kata kunci &ldquo;{{ $keyword }}&rdquo;.
                @else
                    Informasi yang ditambahkan admin akan tampil di halaman ini.
                @endif
            </p>
        </div>
    @endforelse

    @if ($informasis->hasPages())
        <div class="mt-6">
            {{ $informasis->links() }}
        </div>
    @endif

@endsection
