<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($kos['nama_kos']) ?> - Si-Kos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #1e293b; }
        a { text-decoration: none; }
        
        .navbar-custom { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 1px 10px rgba(0,0,0,0.05); padding: 15px 0; }
        .navbar-brand { font-size: 22px; font-weight: 800; color: #0f172a; }
        
        .banner-kos { 
            position: relative; 
            height: 380px; 
            border-radius: 28px; 
            overflow: hidden; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            margin-top: 25px; 
            background-color: #0f172a; 
        }
        .banner-kos img { width: 100%; height: 100%; object-fit: cover; opacity: 0.85; }
        .banner-overlay { 
            position: absolute; 
            inset: 0; 
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.2) 60%, transparent 100%); 
            display: flex; 
            flex-direction: column; 
            justify-content: flex-end; 
            padding: 40px; 
            color: white; 
        }
        
        .kamar-card { 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            border: 1px solid #e2e8f0; 
            transition: 0.3s; 
            height: 100%; 
            display: flex; 
            flex-direction: column; 
        }
        .kamar-card:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.06); 
            border-color: #0d6efd; 
        }
        .kamar-img-wrap { 
            position: relative; 
            height: 200px; 
            background: #e2e8f0; 
        }
        .kamar-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .kamar-badge-no { 
            position: absolute; 
            top: 15px; 
            left: 15px; 
            background: rgba(13, 110, 253, 0.9); 
            color: white; 
            padding: 5px 12px; 
            border-radius: 50px; 
            font-size: 13px; 
            font-weight: 700; 
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <i class="bi bi-arrow-left-circle text-primary me-2 fs-4"></i>
                <span class="fw-bold">Semua Kos</span>
            </a>
            
            <div class="ms-auto d-flex align-items-center gap-2">
                <?php if (!empty($kos['no_wa_pemilik'])): ?>
                    <a href="https://wa.me/<?= preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $kos['no_wa_pemilik'])) ?>" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-whatsapp me-1"></i> Hubungi Pemilik
                    </a>
                <?php endif; ?>
                <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        
        <?php if (session()->getFlashdata('pesan_sukses')): ?>
            <div class="alert alert-success rounded-4 mt-4 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('pesan_sukses') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('pesan_error')): ?>
            <div class="alert alert-danger rounded-4 mt-4 shadow-sm">
                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('pesan_error') ?>
            </div>
        <?php endif; ?>

        <!-- BANNER & INFO KOS -->
        <div class="banner-kos">
            <img src="<?= !empty($kos['foto_banner']) ? $kos['foto_banner'] : 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=1200&q=80' ?>" alt="<?= esc($kos['nama_kos']) ?>">
            <div class="banner-overlay">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold mb-2 align-self-start">
                    <i class="bi bi-house-check-fill me-1"></i> Properti Kos Terverifikasi
                </span>
                <h1 class="fw-bold display-6 mb-2"><?= esc($kos['nama_kos']) ?></h1>
                <p class="mb-0 text-white-50 fs-6">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= esc($kos['alamat'] ?? 'Yogyakarta') ?>
                </p>
            </div>
        </div>

        <div class="row mt-4 g-4">
            <!-- DESKRIPSI & TENTANG KOS -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Tentang Kos Ini</h5>
                    <p class="text-secondary mb-0" style="line-height: 1.8;">
                        <?= nl2br(esc($kos['deskripsi'] ?? 'Kos ini menyediakan lingkungan hunian yang tenang, bersih, dan nyaman dengan akses yang mudah ke berbagai fasilitas umum.')) ?>
                    </p>
                </div>

                <!-- DAFTAR KAMAR TERSEDIA -->
                <h4 class="fw-bold mb-3">
                    <i class="bi bi-door-open-fill text-primary me-1"></i> Kamar Tersedia (<?= count($kamar_tersedia) ?>)
                </h4>

                <?php if (empty($kamar_tersedia)): ?>
                    <div class="card border-0 shadow-sm p-5 text-center rounded-4">
                        <i class="bi bi-door-closed text-muted" style="font-size: 50px;"></i>
                        <h6 class="fw-bold mt-3 text-secondary">Saat ini belum ada kamar yang tersedia di kos ini</h6>
                        <p class="text-muted small m-0">Silakan hubungi pemilik kos melalui WhatsApp untuk reservasi antrian atau cek kos lainnya.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($kamar_tersedia as $kmr): ?>
                            <div class="col-md-6">
                                <div class="kamar-card">
                                    <div class="kamar-img-wrap">
                                        <?php 
                                            $fotoKamar = 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=600&q=80';
                                            if (!empty($kmr['foto_1'])) {
                                                $fotoKamar = base_url('uploads/kamar/' . $kmr['foto_1']);
                                            }
                                        ?>
                                        <img src="<?= $fotoKamar ?>" alt="Kamar <?= esc($kmr['no_kamar']) ?>">
                                        <span class="kamar-badge-no">Kamar <?= esc($kmr['no_kamar']) ?></span>
                                    </div>
                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <span class="badge bg-primary-subtle text-primary align-self-start mb-2 px-2 py-1 rounded-pill small fw-bold">
                                            <?= esc($kmr['nama_tipe']) ?>
                                        </span>
                                        <h5 class="fw-bold text-primary mb-2">
                                            Rp <?= number_format($kmr['harga_dasar'], 0, ',', '.') ?> <span class="text-muted fs-6 fw-normal">/bln</span>
                                        </h5>
                                        <p class="text-muted small mb-3" style="line-height: 1.5;">
                                            <i class="bi bi-stars text-warning me-1"></i> <?= esc($kmr['fasilitas']) ?>
                                        </p>
                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalBooking<?= $kmr['id_kamar'] ?>">
                                                <i class="bi bi-calendar-check me-1"></i> Ajukan Booking
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL BOOKING -->
                            <div class="modal fade" id="modalBooking<?= $kmr['id_kamar'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">Booking Kamar <?= esc($kmr['no_kamar']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="<?= base_url('booking/submit') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_kamar" value="<?= $kmr['id_kamar'] ?>">
                                            <div class="modal-body">
                                                <div class="alert alert-light border rounded-3 p-3 mb-3">
                                                    <div class="fw-bold text-dark"><?= esc($kos['nama_kos']) ?></div>
                                                    <div class="text-muted small">Tipe: <?= esc($kmr['nama_tipe']) ?> | Biaya: Rp <?= number_format($kmr['harga_dasar'], 0, ',', '.') ?>/bln</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Nama Lengkap Anda</label>
                                                    <input type="text" name="nama_calon" class="form-control rounded-3" placeholder="Masukkan nama lengkap" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">No. WhatsApp Aktif</label>
                                                    <input type="text" name="no_wa" class="form-control rounded-3" placeholder="08123456789" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Email Aktif</label>
                                                    <input type="email" name="email" class="form-control rounded-3" placeholder="nama@email.com" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Kirim Pengajuan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- SIDEBAR INFO PEMILIK & KONTAK -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold mb-3"><i class="bi bi-person-badge-fill text-primary me-2"></i>Pengelola Kos</h5>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark"><?= esc($kos['nama_kos']) ?></div>
                            <small class="text-success fw-semibold"><i class="bi bi-patch-check-fill me-1"></i> Mitra Resmi Si-Kos</small>
                        </div>
                    </div>

                    <ul class="list-unstyled text-secondary small mb-4">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt me-2 text-danger"></i> <?= esc($kos['alamat'] ?? '-') ?>
                        </li>
                        <?php if (!empty($kos['no_wa_pemilik'])): ?>
                            <li class="mb-2">
                                <i class="bi bi-whatsapp me-2 text-success"></i> <?= esc($kos['no_wa_pemilik']) ?>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($kos['email_pemilik'])): ?>
                            <li class="mb-2">
                                <i class="bi bi-envelope me-2 text-primary"></i> <?= esc($kos['email_pemilik']) ?>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <?php if (!empty($kos['no_wa_pemilik'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $kos['no_wa_pemilik'])) ?>?text=Halo%20saya%20tertarik%20dengan%20kamar%20di%20<?= urlencode($kos['nama_kos']) ?>" target="_blank" class="btn btn-success w-100 rounded-pill fw-bold mb-2 py-2">
                            <i class="bi bi-whatsapp me-1"></i> Chat Pemilik Kos
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2">
                        <i class="bi bi-key-fill me-1"></i> Login Penghuni Kos
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="py-4 bg-white border-top text-center text-muted">
        <div class="container">
            <small>© <?= date('Y') ?> Si-Kos • Properti: <?= esc($kos['nama_kos']) ?></small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
