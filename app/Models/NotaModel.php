<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaModel extends Model
{
    protected $table            = 'nota';
    protected $primaryKey       = 'nt_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'nt_cr';
    protected $updatedField  = 'nt_up';
    protected $deletedField  = 'nt_dl';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    public function getNota()
    {
        $this->orderBy('nt_id', 'DESC');
        return $this->findAll();
    }
    public function getNota1($nota)
    {
        $this->join('ls_sekolah', 'sch_npsn = nt_sch', 'LEFT');
        $this->select('ls_sekolah.sch_nama');
        $this->select('nota.*');
        $this->where('nt_id',$nota);
        return $this->first();
    }
    public function simpan_nota($data)
    {
        $this->insert($data);
    }
}
