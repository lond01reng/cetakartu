<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggota extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'ag_nisn'=>[
        'type'=>'varchar',
        'constraint'=>10,
        'unique'=>true
      ],
      'ag_nama'=>[
        'type'=>'varchar',
        'constraint'=>100,   
      ],
      'ag_nick'=>[
        'type'=>'varchar',
        'constraint'=>16,
      ],
      'ag_induk'=>[
        'type'=>'varchar',
        'constraint'=>16,
      ],
      'ag_jurusan'=>[
        'type'=>'varchar',
        'constraint'=>48,
      ],
      'ag_tgl'=>[
        'type'=>'date',
      ],
      'ag_tempat'=>[
        'type'=>'varchar',
        'constraint'=>24,
      ],
      'ag_bapak'=>[
        'type'=>'varchar',
        'constraint'=>24,
      ],
      'ag_rt'=>[
        'type'=>'varchar',
        'constraint'=>2,
      ],
      'ag_rw'=>[
        'type'=>'varchar',
        'constraint'=>2,
      ],
      'ag_dusun'=>[
        'type'=>'varchar',
        'constraint'=>24,
      ],
      'ag_desa'=>[
          'type'=>'varchar',
          'constraint'=>24,
      ],
      'ag_kec'=>[
          'type'=>'varchar',
          'constraint'=>24,
      ],
      'ag_kab'=>[
          'type'=>'varchar',
          'constraint'=>24,
      ],
      'ag_nota'=>[
        'type'           => 'INT',
        'constraint'     => 10,
        'unsigned'       => true,
      ],
      'ag_klas'=>[
          'type'=>'ENUM',
          'constraint'=>"'1','2','3'",
          'default'=>'1'
      ],
      'ag_cetak'=>[
          'type'=>'ENUM',
          'constraint'=>"'0','1'",
          'default'=>'0'
      ],
      'ag_cr DATETIME DEFAULT CURRENT_TIMESTAMP',
      'ag_up DATETIME DEFAULT CURRENT_TIMESTAMP  on update current_timestamp',
      'ag_dl' => [
        'type'           => 'DATETIME',
        'null'           => true,
      ]
    ]);
    $this->forge->addKey('ag_nisn', TRUE);
    $this->forge->addForeignKey('ag_nota','nota','nt_id','CASCADE','CASCADE','fk_nota'); 
    $this->forge->createTable('anggota',TRUE);
  }

  public function down()
  {
    $this->forge->dropTable('anggota');
  }
}
