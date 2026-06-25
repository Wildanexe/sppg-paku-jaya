<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        // Proteksi: Hanya Ketua/Sekretaris yang bisa lihat daftar user
        if (Auth::check() && Auth::user()->role == 'staff') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengelola akun.');
        }

        // Ambil semua data user dari database
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Fungsi untuk menyimpan user/akun baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:ketua,sekretaris,staff',
            'password' => 'required|string|min:8',
        ]);

        // 2. Simpan data ke tabel users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password, // Otomatis di-hash oleh model User jika casts sudah aktif
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan!');
    }

    /**
     * Fungsi untuk menghapus user dari database.
     */
    public function destroy(User $user)
    {
        // Proteksi tambahan: Mencegah user menghapus dirinya sendiri jika sedang login (opsional)
        // Jika kamu ingin memaksa menghapus akunmu saat login sekarang, baris if di bawah ini bisa dilewati.
        if (Auth::id() === $user->id) {
            // Jika ingin tetap bisa menghapus diri sendiri saat ini, komentari baris di bawah ini:
            // return redirect()->route('users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang digunakan.');
        }

        // Hapus user dari database
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
