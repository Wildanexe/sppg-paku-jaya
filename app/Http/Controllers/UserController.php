<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna (Ketua, Sekretaris, Staff).
     */
    public function index()
    {
        // 1. Proteksi: Hanya Ketua/Sekretaris yang bisa lihat daftar user
        if (Auth::check() && Auth::user()->role == 'staff') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengelola akun.');
        }

        // 2. Ambil semua data user dari database
        $users = User::all();

        // 3. Lempar ke view yang sudah kita buat tadi
        return view('users.index', compact('users'));
    }

    /**
     * Opsi: Fungsi buat nambah user baru (nanti bisa kamu kembangkan)
     */
    public function store(Request $request)
    {
        // Logika simpan user baru di sini...
    }
}
