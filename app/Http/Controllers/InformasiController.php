<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Halaman informasi untuk user/siswa (read-only, tanpa aksi CRUD).
 */
class InformasiController extends Controller
{
    /**
     * Daftar informasi terbaru.
     */
    public function index(Request $request): View
    {
        $informasis = Informasi::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q')->trim()->toString();

                $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('informasi.index', [
            'informasis' => $informasis,
            'keyword' => $request->input('q'),
        ]);
    }

    /**
     * Detail informasi.
     */
    public function show(Informasi $informasi): View
    {
        return view('informasi.show', [
            'informasi' => $informasi,
            'informasiLainnya' => Informasi::whereKeyNot($informasi->getKey())
                ->latest()
                ->take(3)
                ->get(),
        ]);
    }
}
