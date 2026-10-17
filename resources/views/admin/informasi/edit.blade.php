@extends('layouts.admin')

@section('title', 'Ubah Informasi')
@section('heading', 'Ubah Informasi')
@section('subheading', 'Perbarui judul, isi, atau gambar informasi.')

@section('content')

    <form method="POST" action="{{ route('admin.informasi.update', $informasi) }}"
          enctype="multipart/form-data"
          class="rounded-lg border border-gray-200 bg-white p-6">
        @csrf
        @method('PUT')

        @include('admin.informasi._form')

        <div class="mt-6 flex items-center gap-3 border-t border-gray-200 pt-5">
            <button type="submit"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-black">
                Perbarui Informasi
            </button>
            <a href="{{ route('admin.informasi.index') }}"
               class="rounded-md px-3 py-2 text-sm text-gray-600 transition hover:text-gray-900">
                Batal
            </a>
        </div>
    </form>

@endsection
