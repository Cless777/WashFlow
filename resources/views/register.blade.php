<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | WashFlow</title>
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
        .register-card {
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 24px;
            padding: 50px 50px;
            box-shadow: 0 30px 80px rgba(0,0,0,.4);
        }
        .brand { font-size: 1.8rem; font-weight: 800; color: #2E7D32; text-align: center; }
        h3 { font-weight: 800; color: #1a1a2e; text-align: center; }
        p.sub { color: #6c757d; font-size: .875rem; text-align: center; margin-bottom: 2rem; }
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
        .btn-register {
            background: linear-gradient(135deg, #2E7D32, #388E3C);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: .3s;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #1B5E20, #2E7D32);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46,125,50,.35);
        }
        .green-link { color: #2E7D32; text-decoration: none; font-weight: 600; }
        .green-link:hover { color: #1B5E20; }
        @media (max-width: 576px) {
            .register-card { padding: 35px 25px; }
        }
    </style>
</head>
<body>
<div class="register-card">
    <div class="brand mb-2"><i class="fa fa-tint me-2"></i>WashFlow</div>
    <h3 class="mt-3">Buat Akun Baru</h3>
    <p class="sub">Daftarkan akun Anda untuk mengakses sistem WashFlow.</p>

    <form method="POST" action="{{ route('register.process') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Minimal 8 karakter" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi Password" required>
        </div>
        <button type="submit" class="btn btn-register w-100">
            <i class="fa fa-user-plus me-2"></i>Daftar Sekarang
        </button>
    </form>

    <p class="text-center mt-4" style="font-size:.875rem;color:#6c757d;">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="green-link">Login</a>
    </p>
    <p class="text-center" style="font-size:.85rem;">
        <a href="{{ route('Home') }}" class="green-link" style="font-weight:400;">
            <i class="fa fa-arrow-left me-1"></i>Kembali ke Beranda
        </a>
    </p>
</div>
</body>
</html>
