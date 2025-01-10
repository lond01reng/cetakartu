<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarSekolahModel extends Model
{
    protected $table            = 'ls_sekolah';
    protected $primaryKey       = 'sch_npsn';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'sch_cr';
    protected $updatedField  = 'sch_up';
    protected $deletedField  = 'sch_dl';

    // // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
    public function getSch()
    {
        return $this->findAll();
    }
    public function jsSch()
    {
        $data=$this->findAll();
        $jsdata=[];
        foreach($data as $dt){
            // $jsdata[]=['npsn'=>$dt['sch_npsn'], 'sch'=>$dt['sch_nama']];
            $jsdata[]=['id'=>$dt->sch_npsn, 'sch'=>$dt->sch_nama];
        }
        return $jsdata;
    }
}
