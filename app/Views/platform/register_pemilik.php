<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pemilik Kos Baru - Si-Kos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; color: #1e293b; min-height: 100vh; }
        .form-card { background: white; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
        .section-badge { background: #eff6ff; color: #0d6efd; font-weight: 700; font-size: 13px; padding: 6px 14px; border-radius: 30px; display: inline-block; margin-bottom: 15px; }
    </style>
</head>
<body class="py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="text-center mb-4">
                    <a href="<?= base_url('/') ?>" class="text-decoration-none">
                        <h2 class="fw-bold text-dark"><i class="bi bi-buildings-fill text-primary"></i> Si-<span class="text-primary">Kos</span></h2>
                    </a>
                    <p class="text-muted">Formulir Pendaftaran Mitra Pemilik Kos Baru</p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger rounded-4 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger rounded-4 mb-4">
                        <ul class="mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="form-card p-4 p-md-5">
                    <form action="<?= base_url('daftar-pemilik/simpan') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- BAGIAN 1: PROPERTI KOS -->
                        <span class="section-badge"><i class="bi bi-house-door-fill me-1"></i> Data Properti Kos</span>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kos <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kos" class="form-control form-control-lg rounded-3" placeholder="Contoh: Kos Mawar Indah" value="<?= old('nama_kos') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap Kos <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="2" class="form-control rounded-3" placeholder="Jl. Anggrek No. 10, Sleman, Yogyakarta" required><?= old('alamat') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi & Keunggulan Kos</label>
                            <textarea name="deskripsi" rows="3" class="form-control rounded-3" placeholder="Kos dekat kampus, free WiFi 100 Mbps, parkir luas, keamanan CCTV 24 jam..."><?= old('deskripsi') ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Banner Kos (Opsional)</label>
                            <input type="file" name="foto_banner" class="form-control rounded-3" accept="image/*">
                            <small class="text-muted">Format gambar JPG/PNG, maksimal 2MB. Jika kosong akan menggunakan foto ilustrasi standar.</small>
                        </div>

                        <hr class="my-4">

                        <!-- BAGIAN 2: DATA PEMILIK & AKUN LOGIN -->
                        <span class="section-badge"><i class="bi bi-person-fill-lock me-1"></i> Data Pemilik & Akun Admin</span>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap Pemilik <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pemilik" class="form-control rounded-3" placeholder="Bpk. Hendra Gunawan" value="<?= old('nama_pemilik') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">No. WhatsApp Pemilik <span class="text-danger">*</span></label>
                                <input type="text" name="no_wa" class="form-control rounded-3" placeholder="08123456789" value="<?= old('no_wa') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Pemilik (Opsional)</label>
                            <input type="email" name="email_pemilik" class="form-control rounded-3" placeholder="pemilik@gmail.com" value="<?= old('email_pemilik') ?>">
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username Login Admin Kos <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control rounded-3" placeholder="admin_mawar" value="<?= old('username') ?>" required>
                                <small class="text-muted">Digunakan untuk login ke panel admin kos Anda</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Password Login <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control rounded-3" placeholder="Minimal 5 karakter" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow">
                                <i class="bi bi-check-circle-fill me-2"></i> Daftarkan Kos & Buat Akun Admin
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="<?= base_url('/') ?>" class="text-muted text-decoration-none small">
                                <i class="bi bi-arrow-left me-1"></i> Batal & Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
