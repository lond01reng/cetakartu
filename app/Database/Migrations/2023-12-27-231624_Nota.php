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
				'constraint'     => '10',
				'unsigned'       => true,
				'auto_increment' => true
            ],
            'nt_sch'  =>  [
                'type'           => 'VARCHAR',
				'constraint'     => '8',
            ],
            'nt_ks' => [
                'type'=>'varchar',
                'constraint'     => '32',
            ],
            'nt_nip'=>[
                'type'=>'varchar',
                'constraint' => '32',
            ],
            'nt_tgl' => [
                'type' => 'date',
            ],
            'nt_tmpl' =>[
                'type'=>'varchar',
                'constraint' => '32',
            ],
            'nt_cr DATETIME DEFAULT CURRENT_TIMESTAMP',
            'nt_up DATETIME DEFAULT CURRENT_TIMESTAMP  on update current_timestamp',
            'nt_dl' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
        ]);
        $this->forge->addKey('nt_id', TRUE);
        $this->forge->addForeignKey('nt_sch','ls_sekolah','sch_npsn','CASCADE','CASCADE','fk_sch'); 
        $this->forge->createTable('nota', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('nota');
    }
}
