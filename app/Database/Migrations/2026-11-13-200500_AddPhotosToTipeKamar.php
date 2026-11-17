<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotosToTipeKamar extends Migration
{
    public function up()
    {
        $fields = [
            'foto_1' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'fasilitas',
            ],
            'foto_2' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'foto_1',
            ],
            'foto_3' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'foto_2',
            ],
        ];

        $this->forge->addColumn('tb_tipe_kamar', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_tipe_kamar', ['foto_1', 'foto_2', 'foto_3']);
    }
}
