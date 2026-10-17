<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Data informasi sekolah yang dikelola oleh admin dan ditampilkan
 * (read-only) kepada user/siswa.
 */
#[Fillable(['title', 'content', 'image'])]
class Informasi extends Model
{
    use HasFactory;

    /**
     * Nama tabel ditulis eksplisit karena bentuk jamak dari "Informasi"
     * adalah "informasis" (Laravel tidak menambahkan "s" pada kata berakhiran "i").
     */
    protected $table = 'informasis';

    /**
     * URL gambar (null jika admin tidak mengunggah gambar).
     */
    public function imageUrl(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        return Storage::disk('public')->url($this->image);
    }

    /**
     * Ringkasan konten untuk ditampilkan pada daftar informasi.
     */
    public function excerpt(int $limit = 150): string
    {
        return str($this->content)->stripTags()->squish()->limit($limit)->toString();
    }
}
