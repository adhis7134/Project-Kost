<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Si-Kos - Platform Direktori & Manajemen Multi-Kos</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #1e293b; }
        a { text-decoration: none; }
        
        .navbar-custom { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 2px 15px rgba(0,0,0,0.04); padding: 16px 0; }
        .navbar-brand { font-size: 24px; font-weight: 800; color: #0f172a; }
        .navbar-brand span { color: #0d6efd; }
        
        .hero { 
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); 
            padding: 90px 0 70px; 
            color: white; 
            position: relative; 
            overflow: hidden; 
        }
        .hero::after { 
            content: ''; 
            position: absolute; 
            width: 500px; 
            height: 500px; 
            background: radial-gradient(circle, rgba(13,110,253,0.3) 0%, transparent 70%); 
            top: -150px; 
            right: -100px; 
            border-radius: 50%; 
        }
        .hero-badge { 
            background: rgba(255,255,255,0.12); 
            padding: 8px 18px; 
            border-radius: 50px; 
            font-size: 13px; 
            font-weight: 600; 
            display: inline-block; 
            margin-bottom: 20px; 
            border: 1px solid rgba(255,255,255,0.25); 
        }
        .hero-title { font-size: 46px; font-weight: 800; line-height: 1.25; margin-bottom: 18px; }
        .hero-desc { font-size: 17px; color: #cbd5e1; line-height: 1.6; margin-bottom: 30px; }
        
        .search-box { 
            background: white; 
            padding: 10px; 
            border-radius: 50px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
            max-width: 650px; 
        }
        .search-box input { border: none; outline: none; padding-left: 20px; font-size: 15px; }
        .search-box input:focus { box-shadow: none; }
        
        .kos-card { 
            background: white; 
            border-radius: 20px; 
            overflow: hidden; 
            border: 1px solid #e2e8f0; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            height: 100%; 
            display: flex; 
            flex-direction: column; 
        }
        .kos-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 35px rgba(0,0,0,0.08); 
            border-color: #0d6efd; 
        }
        .kos-img-wrap { 
            position: relative; 
            height: 220px; 
            overflow: hidden; 
            background-color: #e2e8f0; 
        }
        .kos-img-wrap img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            transition: transform 0.5s; 
        }
        .kos-card:hover .kos-img-wrap img { transform: scale(1.06); }
        .badge-status { 
            position: absolute; 
            top: 15px; 
            right: 15px; 
            padding: 6px 14px; 
            border-radius: 50px; 
            font-size: 12px; 
            font-weight: 700; 
            backdrop-filter: blur(6px); 
        }
        .badge-owner { 
            position: absolute; 
            bottom: 12px; 
            left: 15px; 
            background: rgba(15, 23, 42, 0.75); 
            color: white; 
            padding: 5px 12px; 
            border-radius: 30px; 
            font-size: 11px; 
            font-weight: 600; 
            backdrop-filter: blur(4px); 
        }
        
        .kos-body { padding: 24px; flex-grow: 1; display: flex; flex-direction: column; }
        .kos-title { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px; line-height: 1.3; }
        .kos-address { font-size: 13px; color: #64748b; margin-bottom: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .kos-price { font-size: 22px; font-weight: 800; color: #0d6efd; }
        .kos-price span { font-size: 13px; color: #64748b; font-weight: 500; }
        
        .cta-banner { 
            background: linear-gradient(135deg, #1e3a8a 0%, #0d6efd 100%); 
            border-radius: 24px; 
            padding: 50px 40px; 
            color: white; 
            position: relative; 
            overflow: hidden; 
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <i class="bi bi-buildings-fill text-primary me-2 fs-3"></i>
                <span>Si-</span>Kos
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item me-lg-3">
                        <a class="nav-link text-dark fw-semibold" href="<?= base_url('/') ?>">
                            <i class="bi bi-compass me-1"></i> Jelajah Kos
                        </a>
                    </li>
                    <li class="nav-item me-lg-3">
                        <a class="nav-link text-primary fw-bold" href="<?= base_url('daftar-pemilik') ?>">
                            <i class="bi bi-plus-circle me-1"></i> Daftarkan Kos Anda
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk / Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="hero-badge">
                        <i class="bi bi-shield-check me-1 text-primary"></i> Multi-Tenant Platform Kos
                    </span>
                    <h1 class="hero-title">Temukan Hunian Kos Nyaman dari Berbagai Pemilik</h1>
                    <p class="hero-desc">Pilih kos sesuai selera, lokasi, dan budget Anda. Setiap kos memiliki fasilitas, pengelola, dan keunggulan tersendiri.</p>
                    
                    <!-- Search Bar -->
                    <form action="<?= base_url('/') ?>" method="get" class="search-box mx-auto d-flex align-items-center">
                        <i class="bi bi-search text-muted ms-3 fs-5"></i>
                        <input type="text" name="cari" class="form-control" placeholder="Cari nama kos atau lokasi..." value="<?= esc($keyword ?? '') ?>">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold text-nowrap">
                            Cari Kos
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION DAFTAR KOS -->
    <section class="py-5">
        <div class="container py-3">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h3 class="fw-bold m-0 text-dark">Daftar Pilihan Kos</h3>
                    <p class="text-muted m-0">Menampilkan <?= count($daftar_kos) ?> properti kos yang siap huni</p>
                </div>
                <div>
                    <a href="<?= base_url('daftar-pemilik') ?>" class="btn btn-primary btn-sm rounded-pill px-3 py-2 fw-bold">
                        <i class="bi bi-house-add-fill me-1"></i> Anda Pemilik Kos? Gabung Di Sini
                    </a>
                </div>
            </div>

            <?php if (empty($daftar_kos)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-building-slash text-muted" style="font-size: 60px;"></i>
                    <h5 class="fw-bold mt-3 text-secondary">Belum ada kos yang sesuai</h5>
                    <p class="text-muted">Coba kata kunci pencarian lain atau kembali ke seluruh daftar.</p>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary rounded-pill px-4">Lihat Semua Kos</a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($daftar_kos as $kos): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="kos-card">
                                <div class="kos-img-wrap">
                                    <img src="<?= !empty($kos['foto_banner']) ? $kos['foto_banner'] : 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80' ?>" alt="<?= esc($kos['nama_kos']) ?>">
                                    
                                    <?php if ($kos['kamar_tersedia'] > 0): ?>
                                        <span class="badge-status bg-success text-white">
                                            <i class="bi bi-check-circle-fill me-1"></i> <?= $kos['kamar_tersedia'] ?> Kamar Kosong
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-status bg-danger text-white">
                                            <i class="bi bi-x-circle-fill me-1"></i> Kamar Penuh
                                        </span>
                                    <?php endif; ?>

                                    <span class="badge-owner">
                                        <i class="bi bi-person-fill me-1"></i> <?= !empty($kos['no_wa_pemilik']) ? 'Pemilik Terverifikasi' : 'Mitra Si-Kos' ?>
                                    </span>
                                </div>
                                
                                <div class="kos-body">
                                    <h4 class="kos-title"><?= esc($kos['nama_kos']) ?></h4>
                                    <p class="kos-address">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= esc($kos['alamat'] ?? 'Lokasi strategis') ?>
                                    </p>
                                    
                                    <p class="text-muted small mb-4" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= esc($kos['deskripsi'] ?? 'Fasilitas lengkap, bersih, aman, dan nyaman.') ?>
                                    </p>
                                    
                                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 11px;">Mulai dari</small>
                                            <div class="kos-price">
                                                Rp <?= !empty($kos['harga_termurah']) ? number_format($kos['harga_termurah'], 0, ',', '.') : '750.000' ?><span>/bln</span>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('kos/' . esc($kos['slug'])) ?>" class="btn btn-primary rounded-pill px-3 py-2 fw-bold text-nowrap">
                                            Lihat Kamar <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- BANNER UNTUK PEMILIK KOS -->
    <section class="py-5 bg-white border-top">
        <div class="container">
            <div class="cta-banner">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-light text-primary fw-bold mb-3 px-3 py-2 rounded-pill">Khusus Pemilik Kos</span>
                        <h2 class="fw-bold mb-3">Punya Kamar Kos yang Belum Tersewa?</h2>
                        <p class="text-white-50 mb-4 mb-lg-0" style="font-size: 16px;">
                            Daftarkan properti kos Anda sekarang juga. Dapatkan dashboard khusus untuk kelola tipe kamar, data penghuni, tagihan otomatis, hingga laporan keuangan tanpa repot!
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="<?= base_url('daftar-pemilik') ?>" class="btn btn-light text-primary btn-lg rounded-pill px-4 fw-bold shadow">
                            <i class="bi bi-door-open-fill me-1"></i> Daftarkan Kos Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-4 bg-dark text-white-50 text-center">
        <div class="container">
            <p class="m-0 small">© <?= date('Y') ?> Si-Kos - Platform Manajemen Multi-Tenant Kos Terpadu.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
