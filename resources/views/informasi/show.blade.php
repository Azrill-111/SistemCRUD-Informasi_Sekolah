@extends('layouts.app')

@section('title', $informasi->title)

@section('content')

    <a href="{{ route('informasi.index') }}" class="text-sm text-gray-500 hover:text-gray-900">
        &larr; Kembali ke daftar informasi
    </a>

    <article class="mt-4 overflow-hidden rounded-lg border border-gray-200 bg-white">

        @if ($informasi->imageUrl())
            <img src="{{ $informasi->imageUrl() }}" alt="{{ $informasi->title }}"
                 class="max-h-80 w-full object-cover">
        @endif

        <div class="p-6">
            <p class="text-xs uppercase tracking-wide text-gray-500">
                Diterbitkan {{ $informasi->created_at->translatedFormat('d F Y, H:i') }} WIB
                @if ($informasi->updated_at->gt($informasi->created_at))
                    &middot; diperbarui {{ $informasi->updated_at->translatedFormat('d F Y, H:i') }} WIB
                @endif
            </p>

            <h1 class="mt-2 text-xl font-semibold leading-snug text-gray-900">
                {{ $informasi->title }}
            </h1>

            <div class="mt-4 space-y-4 border-t border-gray-200 pt-4 text-sm leading-relaxed text-gray-700">
                {!! nl2br(e($informasi->content)) !!}
            </div>
        </div>
    </article>

    @if ($informasiLainnya->isNotEmpty())
        <section class="mt-8">
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Informasi lainnya
            </h2>

            <div class="grid gap-3 sm:grid-cols-3">
                @foreach ($informasiLainnya as $lainnya)
                    <a href="{{ route('informasi.show', $lainnya) }}"
                       class="rounded-lg border border-gray-200 bg-white p-4 transition hover:border-gray-300">
                        <p class="text-xs text-gray-500">
                            {{ $lainnya->created_at->translatedFormat('d M Y') }}
                        </p>
                        <p class="mt-1 text-sm font-medium text-gray-900">
                            {{ $lainnya->title }}
                        </p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

@endsection
