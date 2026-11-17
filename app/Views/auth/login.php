<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Si-Kos</title>
    <!-- Bootstrap CDN & Local Fallback -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
            padding: 32px;
        }
        .login-title {
            font-weight: 800;
            color: #0f172a;
            font-size: 28px;
            text-align: center;
            margin-bottom: 24px;
        }
        .login-title span {
            color: #0d6efd;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            background-color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-title">Si-<span>Kos</span></div>
        <?php if(session()->getFlashdata('msg')): ?>
            <div class="alert alert-danger py-2 rounded-3 text-center small"><?= session()->getFlashdata('msg') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('pesan_sukses')): ?>
            <div class="alert alert-success py-2 rounded-3 text-center small"><?= session()->getFlashdata('pesan_sukses') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('login/process') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username / No HP</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
            <div class="text-center mt-3">
                <a href="<?= base_url('daftar-pemilik') ?>" class="text-primary text-decoration-none small fw-semibold">
                    Pemilik kos baru? Daftarkan kos Anda di sini
                </a>
            </div>
            <div class="text-center mt-2">
                <a href="<?= base_url('/') ?>" class="text-muted text-decoration-none small">
                    &larr; Kembali ke Katalog Kos
                </a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>