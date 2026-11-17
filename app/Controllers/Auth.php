<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController
{
    public function index()
    {
        $this->ensureDefaultUsers();
        return view('auth/login');
    }

    private function ensureDefaultUsers()
    {
        try {
            \App\Models\KosModel::ensureSchema();

            $model = new PenggunaModel();
            $db = \Config\Database::connect();

            // Admin default (Pusat / Kos 1)
            $admin = $model->where('username', 'admin')->first();
            if (!$admin) {
                $model->insert([
                    'username'       => 'admin',
                    'password'       => password_hash('admin123', PASSWORD_BCRYPT),
                    'role'           => 'Admin',
                    'id_kos'         => 1,
                    'is_first_login' => 0
                ]);
                $id = $model->getInsertID();
                $db->table('tb_profil_admin')->insert([
                    'id_pengguna'  => $id,
                    'nama_lengkap' => 'Administrator Si-Kos',
                    'no_wa'        => '081234567890'
                ]);
            }

            // Pemilik Kos Melati (Contoh Pemilik Kos ke-2)
            $pemilik2 = $model->where('username', 'pemilik_melati')->first();
            if (!$pemilik2) {
                $model->insert([
                    'username'       => 'pemilik_melati',
                    'password'       => password_hash('admin123', PASSWORD_BCRYPT),
                    'role'           => 'Admin',
                    'id_kos'         => 2,
                    'is_first_login' => 0
                ]);
                $id = $model->getInsertID();
                $db->table('tb_profil_admin')->insert([
                    'id_pengguna'  => $id,
                    'nama_lengkap' => 'Ibu Melati (Pemilik Kos Melati)',
                    'no_wa'        => '087812345678'
                ]);
            }

            // Admin Utama
            $adminUtama = $model->where('username', 'admin_utama')->first();
            if (!$adminUtama) {
                $model->insert([
                    'username'       => 'admin_utama',
                    'password'       => password_hash('admin123', PASSWORD_BCRYPT),
                    'role'           => 'Admin',
                    'id_kos'         => 1,
                    'is_first_login' => 0
                ]);
                $id = $model->getInsertID();
                $db->table('tb_profil_admin')->insert([
                    'id_pengguna'  => $id,
                    'nama_lengkap' => 'Bapak Kos',
                    'no_wa'        => '080000000001'
                ]);
            }

            // Penghuni
            $penghuni = $model->where('username', '0821')->first();
            if (!$penghuni) {
                $model->insert([
                    'username'       => '0821',
                    'password'       => password_hash('awdawd', PASSWORD_BCRYPT),
                    'role'           => 'Penghuni',
                    'id_kos'         => 1,
                    'is_first_login' => 0
                ]);
                $id = $model->getInsertID();
                $db->table('tb_profil_penghuni')->insert([
                    'id_pengguna'    => $id,
                    'id_kos'         => 1,
                    'nama_lengkap'   => 'Awaludin',
                    'no_wa'          => '0821',
                    'email'          => 'udin@gmail.com',
                    'foto_ktp'       => null,
                    'kontak_darurat' => null
                ]);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Auto-seed error: ' . $e->getMessage());
        }
    }

    public function process()
    {
        $this->ensureDefaultUsers();
        $session = session();
        $model = new PenggunaModel();
        
        $username = trim($this->request->getVar('username'));
        $password = trim($this->request->getVar('password'));
        
        $data = $model->where('username', $username)->first();
        
        if ($data) {
            $pass = $data['password'];
            
            // === JURUS DEBUGGING (Buka komentar blok ini JIKA masih error) ===
            /*
            dd([
                '1_password_diketik' => $password,
                '2_hash_di_database' => $pass,
                '3_panjang_hash_db'  => strlen($pass), // Wajib 60 karakter!
                '4_hasil_cocok_kah'  => password_verify($password, $pass)
            ]);
            */
            // =================================================================
            
            $verify_pass = password_verify($password, $pass);
            
            if ($verify_pass) {
                $id_kos = !empty($data['id_kos']) ? (int)$data['id_kos'] : 1;
                $nama_kos = 'Si-Kos';
                try {
                    $kosModel = new \App\Models\KosModel();
                    $kosInfo = $kosModel->find($id_kos);
                    if ($kosInfo) {
                        $nama_kos = $kosInfo['nama_kos'];
                    }
                } catch (\Throwable $e) {}

                $ses_data = [
                    'id_pengguna'    => $data['id_pengguna'],
                    'username'       => $data['username'],
                    'role'           => $data['role'],
                    'id_kos'         => $id_kos,
                    'nama_kos'       => $nama_kos,
                    'is_first_login' => $data['is_first_login'],
                    'logged_in'      => TRUE
                ];
                $session->set($ses_data);
                
                if ($data['is_first_login'] == 1) {
                    return redirect()->to('/ganti-password');
                }
                
                if (in_array($data['role'], ['Admin', 'PemilikKos', 'SuperAdmin'])) {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/penghuni/dashboard');
                }
            } else {
                $session->setFlashdata('msg', 'Password salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function gantiPassword()
    {
        return view('auth/ganti_password');
    }

    public function processGantiPassword()
    {
        $session = session();
        $model = new \App\Models\PenggunaModel();
        
        $id_pengguna = $session->get('id_pengguna');
        $password_baru = $this->request->getVar('password_baru');
        
        $data = [
            'password'       => password_hash($password_baru, PASSWORD_BCRYPT),
            'is_first_login' => 0
        ];
        
        $model->update($id_pengguna, $data);
        
        $session->set('is_first_login', 0);
        
        return redirect()->to('/penghuni/dashboard');
    }

    public function onboarding()
    {
        if (session()->get('role') != 'Penghuni') return redirect()->to('/login');

        $profilModel = new \App\Models\ProfilPenghuniModel();
        $profil = $profilModel->where('id_pengguna', session()->get('id_pengguna'))->first();
        if (!empty($profil['foto_ktp'])) {
            return redirect()->to('/penghuni/dashboard');
        }

        return view('auth/onboarding');
    }

    public function onboardingSubmit()
    {
        $rules = [
            'password_baru'       => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password_baru]',
            'kontak_darurat'      => 'required|numeric',
            'foto_ktp'            => 'uploaded[foto_ktp]|max_size[foto_ktp,2048]|is_image[foto_ktp]|ext_in[foto_ktp,png,jpg,jpeg]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('pesan_error', 'Gagal! Pastikan form diisi dengan benar dan KTP berupa gambar maksimal 2MB.');
            return redirect()->back()->withInput();
        }

        $id_pengguna = session()->get('id_pengguna');
        
        $penggunaModel = new \App\Models\PenggunaModel();
        $penggunaModel->update($id_pengguna, [
            'password' => password_hash($this->request->getVar('password_baru'), PASSWORD_BCRYPT)
        ]);

        $fileKtp = $this->request->getFile('foto_ktp');
        $namaKtp = $fileKtp->getRandomName();
        $fileKtp->move('uploads/ktp', $namaKtp);

        $profilModel = new \App\Models\ProfilPenghuniModel();
        $profil = $profilModel->where('id_pengguna', $id_pengguna)->first();
        
        $profilModel->update($profil['id_profil_penghuni'], [
            'kontak_darurat' => $this->request->getVar('kontak_darurat'),
            'foto_ktp'       => $namaKtp
        ]);

        session()->setFlashdata('pesan', 'Profil berhasil dilengkapi! Selamat Datang di Si-Kos.');
        return redirect()->to('/penghuni/dashboard');
    }
}