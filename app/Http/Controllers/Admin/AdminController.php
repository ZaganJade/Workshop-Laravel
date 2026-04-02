<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Barang;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
     public function admin()
    {
        $stats = [
            'total_buku' => Buku::count(),
            'total_kategori' => Kategori::count(),
            'total_user' => User::count(),
            'total_barang' => Barang::count(),
            'recent_logs' => ActivityLog::with('user')->latest()->take(5)->get(),
        ];

        return view('AdminDashboard', compact('stats'));
    }
}
