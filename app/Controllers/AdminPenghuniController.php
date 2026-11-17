<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use App\Models\ProfilPenghuniModel;
use App\Models\KamarModel;

class AdminPenghuniController extends BaseController
{
    protected $penggunaModel;
    protected $profilModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        $this->profilModel = new ProfilPenghuniModel();
        $this->kamarModel = new KamarModel();
    }

    public function index()
    {
        $id_kos = session()->get('id_kos') ?? 1;
        $data = [
            'penghuni' => $this->profilModel->getPenghuniLengkapByKos($id_kos)
        ];
        return view('admin/penghuni/index', $data);
    }

    public function create()
    {
        $id_kos = session()->get('id_kos') ?? 1;
        $data = [
            'kamar_tersedia' => $this->kamarModel->getKamarTersediaByKos($id_kos)
        ];
        return view('admin/penghuni/create', $data);
    }

    public function store()
    {
        $id_kos = session()->get('id_kos') ?? 1;
        $db = \Config\Database::connect();
        $db->transStart(); 

        
        $this->penggunaModel->insert([
            'username'       => $this->request->getVar('no_wa'),
            'password'       => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role'           => 'Penghuni',
            'id_kos'         => $id_kos,
            'is_first_login' => 1
        ]);

        $id_pengguna = $this->penggunaModel->getInsertID();

        
        $this->profilModel->insert([
            'id_pengguna'    => $id_pengguna,
            'id_kos'         => $id_kos,
            'id_kamar'       => $this->request->getVar('id_kamar'),
            'id_kamar'     => $this->request->getVar('id_kamar'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'no_wa'        => $this->request->getVar('no_wa')
        ]);

       
        $this->kamarModel->update($this->request->getVar('id_kamar'), [
            'status_kamar' => 'Terisi'
        ]);

        $db->transComplete(); 

        
        if ($db->transStatus() === false) {
            session()->setFlashdata('pesan_error', 'Gagal menyimpan data! Pastikan kolom di database sudah sesuai.');
        } else {
            session()->setFlashdata('pesan', 'Data penghuni dan akun berhasil dibuat.');
        }

        return redirect()->to('/admin/penghuni');
    }

    public function delete($id_profil)
    {
        $profil = $this->profilModel->find($id_profil);
        
        $this->kamarModel->update($profil['id_kamar'], ['status_kamar' => 'Tersedia']);
        $this->penggunaModel->delete($profil['id_pengguna']);
        $this->profilModel->delete($id_profil);

        session()->setFlashdata('pesan', 'Data penghuni berhasil dihapus dan kamar dikosongkan.');
        return redirect()->to('/admin/penghuni');
    }
}