<?php

namespace App\Models;

use CodeIgniter\Model;

class UseradmModel extends Model
{
    protected $table            = 'useradm';
    protected $primaryKey       = 'adm_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    // protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'adm_cr';
    protected $updatedField  = 'adm_up';
    protected $deletedField  = 'adm_dl';

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
    public function cekuser($username)
    {
        // $data=[
        //     'adm_uname' =>$username,
        //     'adm_pasw'  => $password,
        // ];
        $this->where('adm_uname',$username);
        return $this->first();
    }
}
