@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Admin')
@section('subheading', 'Ringkasan data informasi dan pengguna sistem.')

@section('content')

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Total Informasi', 'value' => $totalInformasi, 'note' => 'seluruh data'],
                ['label' => 'Ditambahkan Hari Ini', 'value' => $informasiHariIni, 'note' => now()->translatedFormat('d F Y')],
                ['label' => 'Akun Admin', 'value' => $totalAdmin, 'note' => 'pengelola sistem'],
                ['label' => 'Akun User', 'value' => $totalUser, 'note' => 'siswa / pembaca'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="rounded-lg border border-gray-200 bg-white p-5">
                <p class="text-xs uppercase tracking-wide text-gray-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $card['value'] }}</p>
                <p class="mt-1 text-xs text-gray-400">{{ $card['note'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 rounded-lg border border-gray-200 bg-white">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h2 class="text-sm font-semibold text-gray-900">5 Informasi Terbaru</h2>
            <a href="{{ route('admin.informasi.create') }}"
               class="rounded-md bg-gray-900 px-3 py-2 text-xs font-medium text-white transition hover:bg-black">
                + Tambah Informasi
            </a>
        </div>

        @forelse ($informasiTerbaru as $informasi)
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-3 last:border-b-0">
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-gray-900">{{ $informasi->title }}</p>
                    <p class="mt-0.5 text-xs text-gray-500">
                        {{ $informasi->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <a href="{{ route('informasi.show', $informasi) }}" target="_blank"
                       class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 transition hover:bg-gray-100">
                        Lihat
                    </a>
                    <a href="{{ route('admin.informasi.edit', $informasi) }}"
                       class="rounded-md border border-gray-300 px-3 py-1.5 text-gray-700 transition hover:bg-gray-100">
                        Edit
                    </a>
                </div>
            </div>
        @empty
            <p class="px-5 py-8 text-center text-sm text-gray-500">
                Belum ada data informasi. Silakan tambahkan informasi pertama.
            </p>
        @endforelse
    </div>

@endsection
