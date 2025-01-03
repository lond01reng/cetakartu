<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nt_id'    =>  [
                'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
            ],
            'nt_sch'  =>  [
                'type'           => 'VARCHAR',
				'constraint'     => '8',
            ],
            'adm_cr DATETIME DEFAULT CURRENT_TIMESTAMP',
            'adm_up DATETIME DEFAULT CURRENT_TIMESTAMP  on update current_timestamp',
            'adm_dl' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
