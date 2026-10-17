<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInformasiRequest;
use App\Http\Requests\UpdateInformasiRequest;
use App\Models\Informasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * CRUD data informasi (khusus admin).
 */
class InformasiController extends Controller
{
    /**
     * Daftar seluruh informasi beserta pencarian sederhana.
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
            ->paginate(10)
            ->withQueryString();

        return view('admin.informasi.index', [
            'informasis' => $informasis,
            'keyword' => $request->input('q'),
        ]);
    }

    /**
     * Form tambah informasi.
     */
    public function create(): View
    {
        return view('admin.informasi.create');
    }

    /**
     * Simpan informasi baru.
     */
    public function store(StoreInformasiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('informasis', 'public');
        }

        $informasi = Informasi::create($data);

        return redirect()
            ->route('admin.informasi.index')
            ->with('success', "Informasi \"{$informasi->title}\" berhasil ditambahkan.");
    }

    /**
     * Detail informasi dari sisi admin.
     */
    public function show(Informasi $informasi): View
    {
        return view('admin.informasi.show', compact('informasi'));
    }

    /**
     * Form ubah informasi.
     */
    public function edit(Informasi $informasi): View
    {
        return view('admin.informasi.edit', compact('informasi'));
    }

    /**
     * Perbarui informasi.
     */
    public function update(UpdateInformasiRequest $request, Informasi $informasi): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Hapus gambar lama agar tidak menumpuk di storage.
            if ($informasi->image) {
                Storage::disk('public')->delete($informasi->image);
            }

            $data['image'] = $request->file('image')->store('informasis', 'public');
        }

        $informasi->update($data);

        return redirect()
            ->route('admin.informasi.index')
            ->with('success', "Informasi \"{$informasi->title}\" berhasil diperbarui.");
    }

    /**
     * Hapus informasi. Data otomatis hilang dari halaman user
     * karena halaman user membaca langsung dari database.
     */
    public function destroy(Informasi $informasi): RedirectResponse
    {
        if ($informasi->image) {
            Storage::disk('public')->delete($informasi->image);
        }

        $judul = $informasi->title;
        $informasi->delete();

        return redirect()
            ->route('admin.informasi.index')
            ->with('success', "Informasi \"{$judul}\" berhasil dihapus.");
    }
}
