@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 30px;">
    <h1><i class="fas fa-user-gear" style="color: #6366f1;"></i> Manajemen Akun Pengguna</h1>
    <p style="color: #64748b;">Kelola hak akses Ketua, Sekretaris, dan Staff SPPG Paku Jaya.</p>
</div>

{{-- Alert notifikasi sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 25px; background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- Alert error jika validasi gagal (misal email kembar atau password kurang dari 8 karakter) --}}
@if($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 25px; background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; border: 1px solid #fca5a5;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    <div class="card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: fit-content;">
        <h3 style="font-size: 1.15rem; color: #1e293b; font-weight: 600; margin-bottom: 15px;"><i class="fas fa-plus-circle" style="color: #3b82f6;"></i> Tambah Akun</h3>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.85rem; color: #475569; font-weight: 600; display: block; margin-bottom: 5px;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box;" placeholder="Contoh: Ahmad Staff" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.85rem; color: #475569; font-weight: 600; display: block; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box;" placeholder="sppg@paku-jaya.com" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.85rem; color: #475569; font-weight: 600; display: block; margin-bottom: 5px;">Jabatan / Role</label>
                <select name="role" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; background: white;" required>
                    <option value="ketua" {{ old('role') == 'ketua' ? 'selected' : '' }}>Ketua SPPG</option>
                    <option value="sekretaris" {{ old('role') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Gudang</option>
                </select>
            </div>

            {{-- 🔑 INPUT PASSWORD BARU BIAR VALIDASI DI CONTROLLER TIDAK GAGAL --}}
            <div style="margin-bottom: 20px;">
                <label style="font-size: 0.85rem; color: #475569; font-weight: 600; display: block; margin-bottom: 5px;">Password Akun</label>
                <input type="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box;" placeholder="Minimal 8 karakter" required>
                <small style="color: #94a3b8; font-size: 0.75rem; display: block; margin-top: 4px;">Berikan password sementara untuk login awal user.</small>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Daftarkan Pengguna</button>
        </form>
    </div>

    <div class="card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h3 style="font-size: 1.15rem; color: #1e293b; font-weight: 600; margin-bottom: 15px;"><i class="fas fa-users" style="color: #10b981;"></i> Pengguna Aktif</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
                    <th style="padding: 12px 10px; color: #475569;">Nama</th>
                    <th style="padding: 12px 10px; color: #475569;">Role</th>
                    <th style="padding: 12px 10px; color: #475569;">Email</th>
                    <th style="padding: 12px 10px; color: #475569; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px 10px;"><strong>{{ $user->name }}</strong></td>
                    <td style="padding: 15px 10px;">
                        <span style="padding: 4px 12px; border-radius: 15px; font-size: 0.75rem; font-weight: 600;
                            background: {{ $user->role == 'ketua' ? '#fef3c7' : ($user->role == 'sekretaris' ? '#dcfce7' : '#e0f2fe') }};
                            color: {{ $user->role == 'ketua' ? '#92400e' : ($user->role == 'sekretaris' ? '#166534' : '#0369a1') }};">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 15px 10px; color: #64748b; font-size: 0.9rem;">{{ $user->email }}</td>
                    <td style="padding: 15px 10px; text-align: center;">
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1rem;" title="Hapus Akun">
                                <i class="fas fa-trash-alt"></i>
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
