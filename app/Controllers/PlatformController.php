<?php

namespace App\Controllers;

use App\Models\KosModel;
use App\Models\KamarModel;
use App\Models\TipeKamarModel;
use App\Models\PenggunaModel;

class PlatformController extends BaseController
{
    protected $kosModel;
    protected $kamarModel;
    protected $tipeKamarModel;

    public function __construct()
    {
        KosModel::ensureSchema();
        $this->kosModel       = new KosModel();
        $this->kamarModel     = new KamarModel();
        $this->tipeKamarModel = new TipeKamarModel();
    }

    /**
     * Beranda Utama Multi-Kos: Menampilkan semua properti kos terdaftar
     */
    public function index()
    {
        $keyword = $this->request->getGet('cari');
        $query = $this->kosModel->select('tb_kos.*, 
                    COUNT(tb_kamar.id_kamar) as total_kamar,
                    SUM(CASE WHEN tb_kamar.status_kamar = "Tersedia" AND tb_kamar.deleted_at IS NULL THEN 1 ELSE 0 END) as kamar_tersedia,
                    MIN(tb_tipe_kamar.harga_dasar) as harga_termurah')
            ->join('tb_tipe_kamar', 'tb_tipe_kamar.id_kos = tb_kos.id_kos', 'left')
            ->join('tb_kamar', 'tb_kamar.id_tipe = tb_tipe_kamar.id_tipe', 'left')
            ->where('tb_kos.status', 'Aktif')
            ->groupBy('tb_kos.id_kos');

        if (!empty($keyword)) {
            $query->groupStart()
                  ->like('tb_kos.nama_kos', $keyword)
                  ->orLike('tb_kos.alamat', $keyword)
                  ->orLike('tb_kos.deskripsi', $keyword)
                  ->groupEnd();
        }

        $daftarKos = $query->findAll();

        $data = [
            'daftar_kos' => $daftarKos,
            'keyword'    => $keyword,
            'total_kos'  => count($daftarKos)
        ];

        return view('platform/index', $data);
    }

    /**
     * Halaman Detail Kos & Kamar Tersedia untuk 1 Kos Tertentu
     */
    public function show($slug)
    {
        $kos = $this->kosModel->findBySlug($slug);
        if (!$kos) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Properti kos tidak ditemukan.');
        }

        $kamarTersedia = $this->kamarModel->getKamarTersediaByKos($kos['id_kos']);
        $tipeKamar = $this->tipeKamarModel->where('id_kos', $kos['id_kos'])->findAll();

        $data = [
            'kos'            => $kos,
            'kamar_tersedia' => $kamarTersedia,
            'tipe_kamar'     => $tipeKamar
        ];

        return view('platform/kos_detail', $data);
    }

    /**
     * Halaman Form Pendaftaran Pemilik Kos Baru
     */
    public function registerPemilik()
    {
        return view('platform/register_pemilik');
    }

    /**
     * Proses Simpan Pendaftaran Pemilik Kos Baru
     */
    public function storePemilik()
    {
        $rules = [
            'nama_pemilik'   => 'required|min_length[3]',
            'no_wa'          => 'required|numeric|min_length[9]',
            'nama_kos'       => 'required|min_length[3]',
            'alamat'         => 'required',
            'username'       => 'required|min_length[4]|is_unique[tb_pengguna.username]',
            'password'       => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Generate slug unik untuk kos
            $baseSlug = KosModel::buatSlug($this->request->getPost('nama_kos'));
            $slug = $baseSlug;
            $counter = 1;
            while ($this->kosModel->where('slug', $slug)->first()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // 2. Simpan Properti Kos
            $fotoBanner = 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80';
            
            $fileFoto = $this->request->getFile('foto_banner');
            if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
                $namaFile = $fileFoto->getRandomName();
                $fileFoto->move('uploads/kos', $namaFile);
                $fotoBanner = base_url('uploads/kos/' . $namaFile);
            }

            $idKos = $this->kosModel->insert([
                'nama_kos'      => $this->request->getPost('nama_kos'),
                'slug'          => $slug,
                'alamat'        => $this->request->getPost('alamat'),
                'deskripsi'     => $this->request->getPost('deskripsi') ?: 'Kos baru yang nyaman dan strategis.',
                'foto_banner'   => $fotoBanner,
                'no_wa_pemilik' => $this->request->getPost('no_wa'),
                'email_pemilik' => $this->request->getPost('email_pemilik') ?: null,
                'status'        => 'Aktif'
            ]);

            // 3. Simpan Akun Pengguna (Role: Admin untuk kos ini)
            $penggunaModel = new PenggunaModel();
            $idPengguna = $penggunaModel->insert([
                'username'       => trim($this->request->getPost('username')),
                'password'       => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'role'           => 'Admin',
                'id_kos'         => $idKos,
                'is_first_login' => 0
            ]);

            // 4. Simpan Profil Admin
            $db->table('tb_profil_admin')->insert([
                'id_pengguna'  => $idPengguna,
                'nama_lengkap' => $this->request->getPost('nama_pemilik'),
                'no_wa'        => $this->request->getPost('no_wa')
            ]);

            // 5. Buat 1 Tipe Kamar Awal untuk kos baru
            $idTipe = $this->tipeKamarModel->insert([
                'id_kos'      => $idKos,
                'nama_tipe'   => 'Kamar Standard (Awal)',
                'harga_dasar' => 750000,
                'fasilitas'   => 'Kasur, Lemari, Meja Belajar, Free WiFi',
                'deskripsi'   => 'Kamar nyaman dan bersih siap huni.',
                'foto_1'      => null,
                'foto_2'      => null,
                'foto_3'      => null
            ]);

            // Buat 2 kamar contoh awal
            $db->table('tb_kamar')->insertBatch([
                ['id_tipe' => $idTipe, 'no_kamar' => '01', 'status_kamar' => 'Tersedia', 'created_at' => date('Y-m-d H:i:s')],
                ['id_tipe' => $idTipe, 'no_kamar' => '02', 'status_kamar' => 'Tersedia', 'created_at' => date('Y-m-d H:i:s')],
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftarkan kos.');
            }

            session()->setFlashdata('pesan_sukses', 'Selamat! Kos "' . $this->request->getPost('nama_kos') . '" berhasil didaftarkan. Silakan login menggunakan akun admin yang baru dibuat.');
            return redirect()->to('/login');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }
}
