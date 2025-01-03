<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Useradm extends Seeder
{
    public function run()
    {
        $uadm_data=[
            [
                'adm_uname'  => 's03do',
                'adm_pasw' =>'$2y$10$.RCn2XLUWzKoz1zHyaK6ael27NSDXIJRQGVBv.o9uhOO2erHtcEpO', /*lorog2022*/
                'adm_nama'  => 'SMKN Ngadirojo',
                'adm_level'     => 'sup',
                'adm_status'    => 'vl'
            ]
        ];
        foreach($uadm_data as $data){
            $this->db->table('useradm')->insert($data);
        }
    }
}
