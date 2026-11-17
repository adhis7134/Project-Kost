<?php

namespace App\Models;

use CodeIgniter\Model;

class KosModel extends Model
{
    protected $table      = 'tb_kos';
    protected $primaryKey = 'id_kos';
    protected $allowedFields = [
        'nama_kos', 'slug', 'alamat', 'deskripsi',
        'foto_banner', 'no_wa_pemilik', 'email_pemilik', 'status'
    ];
    protected $useTimestamps = true;

    /**
     * Ambil semua kos yang aktif beserta jumlah kamar tersedia.
     */
    public function getKosAktif()
    {
        return $this->select('tb_kos.*, COUNT(tb_kamar.id_kamar) as total_kamar,
                              SUM(CASE WHEN tb_kamar.status_kamar = "Tersedia" AND tb_kamar.deleted_at IS NULL THEN 1 ELSE 0 END) as kamar_tersedia')
                    ->join('tb_tipe_kamar', 'tb_tipe_kamar.id_kos = tb_kos.id_kos', 'left')
                    ->join('tb_kamar', 'tb_kamar.id_tipe = tb_tipe_kamar.id_tipe', 'left')
                    ->where('tb_kos.status', 'Aktif')
                    ->groupBy('tb_kos.id_kos')
                    ->findAll();
    }

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->where('status', 'Aktif')->first();
    }

    /**
     * Memastikan schema multi-tenant sudah siap secara otomatis
     */
    public static function ensureSchema()
    {
        try {
            $db = \Config\Database::connect();

            // 1. Cek tabel tb_kos
            if (!$db->tableExists('tb_kos')) {
                $db->query("CREATE TABLE IF NOT EXISTS `tb_kos` (
                    `id_kos` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                    `nama_kos` VARCHAR(150) NOT NULL,
                    `slug` VARCHAR(150) NOT NULL UNIQUE,
                    `alamat` TEXT NULL,
                    `deskripsi` TEXT NULL,
                    `foto_banner` VARCHAR(255) NULL,
                    `no_wa_pemilik` VARCHAR(25) NULL,
                    `email_pemilik` VARCHAR(100) NULL,
                    `status` ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
                    `created_at` DATETIME NULL,
                    `updated_at` DATETIME NULL,
                    PRIMARY KEY (`id_kos`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

                // Kos Default 1
                $db->table('tb_kos')->insert([
                    'id_kos'        => 1,
                    'nama_kos'      => 'Kos Grand Si-Kos (Pusat)',
                    'slug'          => 'kos-grand-si-kos',
                    'alamat'        => 'Jl. Ring Road Utara No. 12, Sleman, D.I. Yogyakarta',
                    'deskripsi'     => 'Hunian kos nyaman, tenang, dan strategis dekat kampus dengan fasilitas lengkap dan keamanan 24 jam.',
                    'foto_banner'   => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=1200&q=80',
                    'no_wa_pemilik' => '081234567890',
                    'email_pemilik' => 'admin@sikos.com',
                    'status'        => 'Aktif',
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);

                // Kos Contoh 2 (Untuk langsung memperlihatkan tampilan pembeda antar kos!)
                $db->table('tb_kos')->insert([
                    'id_kos'        => 2,
                    'nama_kos'      => 'Kos Melati Harmoni',
                    'slug'          => 'kos-melati-harmoni',
                    'alamat'        => 'Jl. Kaliurang KM 5, Gang Melati No. 8, Yogyakarta',
                    'deskripsi'     => 'Kos eksklusif putri dan pasutri dengan nuansa asri, taman hijau, WiFi kencang 100 Mbps, dan parkir luas.',
                    'foto_banner'   => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80',
                    'no_wa_pemilik' => '087812345678',
                    'email_pemilik' => 'melati@harmoni-kos.id',
                    'status'        => 'Aktif',
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            }

            // 2. Kolom id_kos di tb_tipe_kamar
            $fieldsTipe = $db->getFieldNames('tb_tipe_kamar');
            if (!in_array('id_kos', $fieldsTipe)) {
                $db->query("ALTER TABLE `tb_tipe_kamar` ADD COLUMN `id_kos` INT UNSIGNED NOT NULL DEFAULT 1 AFTER `id_tipe`");
            }

            // 3. Kolom id_kos di tb_pengguna
            $fieldsUser = $db->getFieldNames('tb_pengguna');
            if (!in_array('id_kos', $fieldsUser)) {
                $db->query("ALTER TABLE `tb_pengguna` ADD COLUMN `id_kos` INT UNSIGNED NULL DEFAULT 1 AFTER `role`");
            }

            // 4. Kolom id_kos di tb_profil_penghuni
            if ($db->tableExists('tb_profil_penghuni')) {
                $fieldsPenghuni = $db->getFieldNames('tb_profil_penghuni');
                if (!in_array('id_kos', $fieldsPenghuni)) {
                    $db->query("ALTER TABLE `tb_profil_penghuni` ADD COLUMN `id_kos` INT UNSIGNED NOT NULL DEFAULT 1 AFTER `id_profil_penghuni`");
                }
            }

            // 5. Kolom id_kos di tb_booking
            if ($db->tableExists('tb_booking')) {
                $fieldsBooking = $db->getFieldNames('tb_booking');
                if (!in_array('id_kos', $fieldsBooking)) {
                    $db->query("ALTER TABLE `tb_booking` ADD COLUMN `id_kos` INT UNSIGNED NOT NULL DEFAULT 1 AFTER `id_booking`");
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'ensureSchema error: ' . $e->getMessage());
        }
    }

    /**
     * Buat slug unik dari nama kos
     */
    public static function buatSlug(string $namaKos): string
    {
        $slug = strtolower(trim($namaKos));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return $slug;
    }
}
