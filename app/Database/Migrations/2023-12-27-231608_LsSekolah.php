<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LsSekolah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sch_npsn'    =>  [
                'type'           => 'VARCHAR',
				'constraint'     => '8',
            ],
            'sch_nama'  =>  [
                'type'           => 'VARCHAR',
				'constraint'     => '64',
                'unique'         => true
            ],
            'sch_alamat'  =>  [
                'type'           => 'VARCHAR',
				'constraint'     => '128',
            ],
            'sch_cr DATETIME DEFAULT CURRENT_TIMESTAMP',
            'sch_up DATETIME DEFAULT CURRENT_TIMESTAMP  on update current_timestamp',
            'sch_dl' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
        ]);
        $this->forge->addKey('sch_npsn', TRUE);
        $this->forge->createTable('ls_sekolah', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('ls_sekolah');
    }
}
