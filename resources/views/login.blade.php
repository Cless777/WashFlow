<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | WashFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #1a1a2e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-wrapper {
            width: 100%;
            max-width: 960px;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,.4);
        }
        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #1B5E20 0%, #2E7D32 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }
        .login-left .brand { font-size: 2rem; font-weight: 800; color: #A5D6A7; }
        .login-left h2 { font-size: 1.8rem; font-weight: 700; margin-top: 2rem; }
        .login-left p { opacity: .75; }
        .login-left .feature-item {
            display: flex; gap: 14px; align-items: center;
            margin-bottom: 1rem;
        }
        .login-left .feature-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .login-right {
            flex: 1;
            background: #fff;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right h3 { font-weight: 800; color: #1a1a2e; margin-bottom: .5rem; }
        .login-right p.sub { color: #6c757d; font-size: .9rem; margin-bottom: 2rem; }
        .form-label { font-weight: 600; font-size: .875rem; color: #333; }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            font-size: .9rem;
            transition: .2s;
        }
        .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 3px rgba(46,125,50,.15);
        }
        .input-group .form-control { border-radius: 12px 0 0 12px; }
        .input-group .btn { border-radius: 0 12px 12px 0; border: 2px solid #e9ecef; border-left: 0; background: #f8f9fa; }
        .btn-login {
            background: linear-gradient(135deg, #2E7D32, #388E3C);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: .3s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46,125,50,.35);
        }
        .back-link { color: #2E7D32; font-size: .85rem; text-decoration: none; }
        .back-link:hover { color: #1B5E20; }
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-right { padding: 40px 30px; }
            .login-wrapper { max-width: 440px; }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    {{-- LEFT --}}
    <div class="login-left">
        <div class="brand"><i class="fa fa-tint me-2"></i>WashFlow</div>
        <h2>Selamat Datang Kembali</h2>
        <p>Masuk untuk mengelola laundry Anda dengan mudah dan efisien.</p>
        <div class="mt-4">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-shopping-bag"></i></div>
                <span>Kelola Order Laundry</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-chart-bar"></i></div>
                <span>Pantau Laporan & Pendapatan</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-users"></i></div>
                <span>Manajemen Pelanggan</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-money-bill-wave"></i></div>
                <span>Kelola Pembayaran</span>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="login-right">
        <a href="{{ route('Home') }}" class="back-link mb-4 d-inline-block">
            <i class="fa fa-arrow-left me-1"></i>Kembali ke Beranda
        </a>
        <h3>Login</h3>
        <p class="sub">Masukkan kredensial Anda untuk mengakses dashboard WashFlow.</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size:.875rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                           placeholder="admin@washflow.id" required autofocus>
                    <button class="btn" type="button"><i class="fa fa-envelope text-muted"></i></button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="••••••••" required id="passwordInput">
                    <button class="btn" type="button" onclick="togglePass()">
                        <i class="fa fa-eye text-muted" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="font-size:.875rem;">Ingat Saya</label>
                </div>
                <a href="#" class="back-link">Lupa Password?</a>
            </div>
            <button type="submit" class="btn btn-login w-100">
                <i class="fa fa-sign-in-alt me-2"></i>Masuk
            </button>
        </form>

        <p class="text-center mt-4" style="font-size:.875rem;color:#6c757d;">
            Belum punya akun?
            <a href="{{ route('register') }}" class="back-link fw-bold">Daftar Sekarang</a>
        </p>
    </div>
</div>

<script>
function togglePass() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
