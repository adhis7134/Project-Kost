<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username'       => 'admin', 
                'password'       => password_hash('admin123', PASSWORD_BCRYPT),
                'role'           => 'Admin',
                'is_first_login' => 0,
                'nama'           => 'Administrator',
                'no_wa'          => '081234567890'
            ],
            [
                'username'       => 'admin_utama', 
                'password'       => password_hash('admin123', PASSWORD_BCRYPT),
                'role'           => 'Admin',
                'is_first_login' => 0,
                'nama'           => 'Bapak Kos',
                'no_wa'          => '080000000001'
            ],
            [
                'username'       => 'admin_penjaga', 
                'password'       => password_hash('penjaga123', PASSWORD_BCRYPT),
                'role'           => 'Admin',
                'is_first_login' => 0,
                'nama'           => 'Kang Ujang Penjaga',
                'no_wa'          => '080000000002'
            ],
            [
                'username'       => '0821', 
                'password'       => password_hash('awdawd', PASSWORD_BCRYPT), 
                'role'           => 'Penghuni',
                'is_first_login' => 1,
                'nama'           => 'Awaludin',
                'no_wa'          => '0821',
                'email'          => 'udin@gmail.com'
            ]
        ];

        foreach ($users as $u) {
            $cek = $this->db->table('tb_pengguna')->where('username', $u['username'])->get()->getRow();
            if (!$cek) {
                $this->db->table('tb_pengguna')->insert([
                    'username'       => $u['username'],
                    'password'       => $u['password'],
                    'role'           => $u['role'],
                    'is_first_login' => $u['is_first_login'],
                ]);
                $id = $this->db->insertID();

                if ($u['role'] === 'Admin') {
                    $this->db->table('tb_profil_admin')->insert([
                        'id_pengguna'  => $id,
                        'nama_lengkap' => $u['nama'],
                        'no_wa'        => $u['no_wa'],
                    ]);
                } else {
                    $this->db->table('tb_profil_penghuni')->insert([
                        'id_pengguna'    => $id,
                        'nama_lengkap'   => $u['nama'],
                        'no_wa'          => $u['no_wa'],
                        'email'          => $u['email'] ?? null,
                        'foto_ktp'       => null,
                        'kontak_darurat' => null,
                    ]);
                }
            }
        }
    }
}
