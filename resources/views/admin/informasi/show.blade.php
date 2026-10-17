@extends('layouts.admin')

@section('title', 'Detail Informasi')
@section('heading', 'Detail Informasi')
@section('subheading', 'Pratinjau data seperti yang dilihat pengguna.')

@section('content')

    <div class="rounded-lg border border-gray-200 bg-white">

        @if ($informasi->imageUrl())
            <img src="{{ $informasi->imageUrl() }}" alt="{{ $informasi->title }}"
                 class="max-h-72 w-full rounded-t-lg object-cover">
        @endif

        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900">{{ $informasi->title }}</h2>

            <dl class="mt-3 grid gap-2 text-xs text-gray-500 sm:grid-cols-2">
                <div>
                    <dt class="inline font-medium text-gray-700">Dibuat:</dt>
                    <dd class="inline">{{ $informasi->created_at->translatedFormat('d F Y, H:i') }} WIB</dd>
                </div>
                <div>
                    <dt class="inline font-medium text-gray-700">Diperbarui:</dt>
                    <dd class="inline">{{ $informasi->updated_at->translatedFormat('d F Y, H:i') }} WIB</dd>
                </div>
            </dl>

            <div class="mt-4 space-y-4 border-t border-gray-200 pt-4 text-sm leading-relaxed text-gray-700">
                {!! nl2br(e($informasi->content)) !!}
            </div>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.informasi.edit', $informasi) }}"
           class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-black">
            Edit Informasi
        </a>
        <a href="{{ route('admin.informasi.index') }}"
           class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100">
            Kembali
        </a>

        <form method="POST" action="{{ route('admin.informasi.destroy', $informasi) }}"
              onsubmit="return confirm('Hapus informasi ini? Data akan hilang dari halaman user.');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-500 transition hover:border-gray-900 hover:text-gray-900">
                Hapus
            </button>
        </form>
    </div>

@endsection
