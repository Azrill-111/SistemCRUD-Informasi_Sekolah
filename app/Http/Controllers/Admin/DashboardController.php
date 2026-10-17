<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard admin berisi ringkasan data.
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalInformasi' => Informasi::count(),
            'informasiHariIni' => Informasi::whereDate('created_at', today())->count(),
            'totalAdmin' => User::where('role', User::ROLE_ADMIN)->count(),
            'totalUser' => User::where('role', User::ROLE_USER)->count(),
            'informasiTerbaru' => Informasi::latest()->take(5)->get(),
        ]);
    }
}
