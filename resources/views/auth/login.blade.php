<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPPG Paku Jaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f0f9ff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; border: 1px solid rgba(14, 165, 233, 0.1); }
        .logo-bgn { height: 80px; margin-bottom: 20px; }
        h2 { color: #0369a1; margin-bottom: 10px; font-size: 1.4rem; }
        p { color: #64748b; font-size: 0.9rem; margin-bottom: 20px; }

        /* CSS untuk pesan error */
        .alert-error { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; font-size: 0.8rem; margin-bottom: 20px; text-align: left; }

        .form-group { text-align: left; margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; color: #1e293b; margin-bottom: 8px; font-weight: 600; }
        input { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; box-sizing: border-box; outline: none; transition: 0.3s; }
        input:focus { border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1); }
        .btn-login { background: #0ea5e9; color: white; border: none; width: 100%; padding: 14px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; margin-top: 10px; }
        .btn-login:hover { background: #0369a1; }
    </style>
</head>
<body>
    <div class="login-card">
        <img src="{{ asset('logo_bgn.jpg') }}" class="logo-bgn" alt="Logo BGN">
        <h2>ASU Control</h2>
        <p>SPPG Paku Jaya - Kota Tangerang</p>

        @if ($errors->any())
            <div class="alert-error">
                Email atau password yang Anda masukkan salah.
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" placeholder="contoh@sppg.com" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">Masuk ke Sistem</button>
        </form>
    </div>
</body>
</html>
