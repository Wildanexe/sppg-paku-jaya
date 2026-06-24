@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1><i class="fas fa-user-gear"></i> Manajemen Akun Pengguna</h1>
    <p style="color: #64748b;">Kelola hak akses Ketua, Sekretaris, dan Staff SPPG Paku Jaya.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    <div class="card">
        <h3><i class="fas fa-plus-circle"></i> Tambah Akun</h3>
        <form action="{{ route('users.store') }}" method="POST" style="margin-top: 15px;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.8rem; color: #64748b;">Nama Lengkap</label>
                <input type="text" name="name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.8rem; color: #64748b;">Email</label>
                <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.8rem; color: #64748b;">Jabatan / Role</label>
                <select name="role" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    <option value="ketua">Ketua SPPG</option>
                    <option value="sekretaris">Sekretaris</option>
                    <option value="staff">Staff Gudang</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Daftarkan Pengguna</button>
        </form>
    </div>

    <div class="card">
        <h3><i class="fas fa-users"></i> Pengguna Aktif</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                    <th style="padding: 10px;">Nama</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 10px;"><strong>{{ $user->name }}</strong></td>
                    <td>
                        <span style="padding: 3px 10px; border-radius: 15px; font-size: 0.75rem;
                            background: {{ $user->role == 'ketua' ? '#fef3c7' : ($user->role == 'sekretaris' ? '#dcfce7' : '#e0f2fe') }};
                            color: {{ $user->role == 'ketua' ? '#92400e' : ($user->role == 'sekretaris' ? '#166534' : '#0369a1') }};">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="color: #64748b; font-size: 0.9rem;">{{ $user->email }}</td>
                    <td style="text-align: center;">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
