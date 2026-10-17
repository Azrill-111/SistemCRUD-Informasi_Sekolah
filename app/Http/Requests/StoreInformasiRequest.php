<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInformasiRequest extends FormRequest
{
    /**
     * Hanya admin yang boleh menambah informasi (dijaga pula oleh middleware).
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Aturan validasi penambahan data informasi.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string', 'min:20'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Pesan validasi dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul informasi wajib diisi.',
            'title.max' => 'Judul informasi maksimal 200 karakter.',
            'content.required' => 'Isi informasi wajib diisi.',
            'content.min' => 'Isi informasi minimal 20 karakter.',
            'image.image' => 'Berkas harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }
}
