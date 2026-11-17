<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MultiTenantKos extends Migration
{
    public function up()
    {
        // 1. Buat tabel tb_kos (properti kos)
        $this->forge->addField([
            'id_kos'       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_kos'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'alamat'       => ['type' => 'TEXT', 'null' => true],
            'deskripsi'    => ['type' => 'TEXT', 'null' => true],
            'foto_banner'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'no_wa_pemilik'=> ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'email_pemilik'=> ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['Aktif','Nonaktif'], 'default' => 'Aktif'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_kos');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('tb_kos', true);

        // Insert kos pertama (data lama)
        $this->db->table('tb_kos')->insert([
            'id_kos'        => 1,
            'nama_kos'      => 'Kos Pertama',
            'slug'          => 'kos-pertama',
            'alamat'        => 'Jl. Contoh No. 1',
            'deskripsi'     => 'Kos pertama yang sudah ada sebelumnya.',
            'foto_banner'   => null,
            'no_wa_pemilik' => '081234567890',
            'email_pemilik' => 'admin@kos.com',
            'status'        => 'Aktif',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        // 2. Tambah kolom id_kos ke tb_tipe_kamar
        $this->forge->addColumn('tb_tipe_kamar', [
            'id_kos' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'default'    => 1,
                'after'      => 'id_tipe',
            ],
        ]);
        // Set semua data lama ke kos 1
        $this->db->query('UPDATE tb_tipe_kamar SET id_kos = 1 WHERE id_kos IS NULL');

        // 3. Tambah kolom id_kos ke tb_pengguna
        $this->forge->addColumn('tb_pengguna', [
            'id_kos' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'role',
            ],
        ]);
        // Admin existing → kos 1
        $this->db->query("UPDATE tb_pengguna SET id_kos = 1 WHERE role = 'Admin'");

        // 4. Tambah kolom id_kos ke tb_profil_penghuni (jika belum ada)
        try {
            $this->forge->addColumn('tb_profil_penghuni', [
                'id_kos' => [
                    'type'    => 'INT',
                    'unsigned'=> true,
                    'null'    => true,
                    'default' => 1,
                    'after'   => 'id_profil_penghuni',
                ],
            ]);
            $this->db->query('UPDATE tb_profil_penghuni SET id_kos = 1 WHERE id_kos IS NULL');
        } catch (\Throwable $e) {
            // kolom mungkin sudah ada
        }

        // 5. Tambah kolom id_kos ke tb_booking (jika belum ada)
        try {
            $this->forge->addColumn('tb_booking', [
                'id_kos' => [
                    'type'    => 'INT',
                    'unsigned'=> true,
                    'null'    => true,
                    'default' => 1,
                    'after'   => 'id_booking',
                ],
            ]);
            $this->db->query('UPDATE tb_booking SET id_kos = 1 WHERE id_kos IS NULL');
        } catch (\Throwable $e) {
            // kolom mungkin sudah ada
        }
    }

    public function down()
    {
        $this->forge->dropTable('tb_kos', true);
        $this->forge->dropColumn('tb_tipe_kamar', 'id_kos');
        $this->forge->dropColumn('tb_pengguna', 'id_kos');
        try { $this->forge->dropColumn('tb_profil_penghuni', 'id_kos'); } catch (\Throwable $e) {}
        try { $this->forge->dropColumn('tb_booking', 'id_kos'); } catch (\Throwable $e) {}
    }
}
