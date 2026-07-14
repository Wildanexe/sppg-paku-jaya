<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPPG Paku Jaya - Inventory Control</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-light: #f0f9ff;
            --white: #ffffff;
            --sidebar-blue: #0369a1;
            --accent-blue: #0ea5e9;
            --text-dark: #1e293b;
            --danger: #ef4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-light); color: var(--text-dark); display: flex; height: 100vh; overflow: hidden; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--sidebar-blue);
            color: white;
            display: flex;
            flex-direction: column; /* Biar footer bisa didorong ke bawah */
            padding: 25px 15px;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 { font-size: 1.1rem; text-align: center; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 15px; letter-spacing: 1px; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 12px 15px; margin: 4px 0; border-radius: 10px; display: flex; align-items: center; transition: 0.3s; font-size: 0.9rem; }
        .sidebar a:hover, .sidebar a.active { background: var(--accent-blue); color: white; transform: translateX(5px); }
        .sidebar i { margin-right: 12px; font-size: 1.1rem; }

        /* SIDEBAR FOOTER (PROFILE & LOGOUT) */
        .sidebar-footer { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 10px; padding: 10px; background: rgba(0,0,0,0.1); border-radius: 12px; margin-bottom: 10px; }
        .user-avatar { width: 35px; height: 35px; background: var(--accent-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.8rem; }
        .logout-btn {
            width: 100%; background: var(--danger); color: white; border: none; padding: 10px;
            border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;
            gap: 8px; transition: 0.3s; font-family: 'Poppins'; font-weight: 600; font-size: 0.85rem;
        }
        .logout-btn:hover { background: #dc2626; transform: scale(1.02); }

        /* MAIN CONTENT */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .topbar { background: var(--white); height: 80px; padding: 0 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 15px rgba(0,0,0,0.05); z-index: 10; }
        .topbar .title { font-weight: 600; font-size: 1.2rem; color: var(--sidebar-blue); }
        .logo-sppg { height: 50px; width: auto; }

        /* CONTENT AREA */
        .container { padding: 30px; overflow-y: auto; flex: 1; }
        .card { background: var(--white); border-radius: 15px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid rgba(14, 165, 233, 0.1); }
        .btn-primary { background: var(--accent-blue); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-weight: 600; }
        .btn-primary:hover { background: var(--sidebar-blue); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>SPPG PAKU JAYA</h2>
        <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Beranda</a>
        <a href="/categories" class="{{ Request::is('categories*') ? 'active' : '' }}"><i class="fas fa-tags"></i> Kategori Bahan</a>
        <a href="/suppliers" class="{{ Request::is('suppliers*') ? 'active' : '' }}"><i class="fas fa-store"></i> Supplier</a>
        <a href="/materials" class="{{ Request::is('materials*') ? 'active' : '' }}"><i class="fas fa-boxes-stacked"></i> Master Bahan</a>
        <a href="/stocks" class="{{ Request::is('stocks*') ? 'active' : '' }}"><i class="fas fa-arrow-right-to-bracket"></i> Stok Masuk</a>
        <a href="/transactions" class="{{ Request::is('transactions*') ? 'active' : '' }}"><i class="fas fa-arrow-right-from-bracket"></i> Barang Keluar</a>

        <div style="margin-top: 15px;">
            <p style="font-size: 0.65rem; color: rgba(255,255,255,0.4); padding-left: 15px; margin-bottom: 5px; letter-spacing: 1px;">ADMIN MENU</p>
            <a href="/recap" style="color: #fbbf24;"><i class="fas fa-chart-pie"></i> Rekap & Budgeting</a>
            <a href="/users"><i class="fas fa-user-gear"></i> Manajemen Akun</a>
        </div>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'W', 0, 1)) }}
                </div>
                <div style="overflow: hidden;">
                    <p style="font-size: 0.8rem; font-weight: 600; margin: 0; white-space: nowrap; text-overflow: ellipsis;">
                        {{ Auth::user()->name ?? 'Wildan Obit' }}
                    </p>
                    <small style="font-size: 0.65rem; color: rgba(255,255,255,0.6);">
                        {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                    </small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="title">TAI System</div>
            <div class="logo-container" style="display: flex; align-items: center; gap: 15px;">
                <img src="{{ asset('logo_bgn.jpg') }}" class="logo-sppg" alt="Logo SPPG">
            </div>
        </div>

        <div class="container">
            @yield('content')
        </div>
    </div>
</body>
</html>
