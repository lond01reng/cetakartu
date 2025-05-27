<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'ag_nisn';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'ag_cr';
    protected $updatedField  = 'ag_up';
    protected $deletedField  = 'ag_dl';

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
    public function getAnggota($nota)
    {
        $this->orderBy('ag_jurusan','ASC');
        $this->orderBy('ag_klas', 'ASC');
        $this->orderBy('ag_nama', 'ASC');
        $this->where('ag_nota',$nota);
        // return $this->find();
        return $this->withDeleted()->find();
    }
    public function getNisn($nisn){
        $this->where('ag_nisn',$nisn);
        return $this->withDeleted()->first();
    }

    public function getNisnPublik($nisn,$tgl){
        $this->where('ag_nisn',$nisn);
        $this->where('ag_tgl',$tgl);
        // $this->where('ag_cetak','1');
        return $this->first();
    }

    public function getJurusan($nota)
    {
        $this->select('ag_jurusan, ag_klas');
        $this->where('ag_nota',$nota);
        $this->distinct();
        $this->orderBy('ag_jurusan','ASC');
        return $this->find();
    }

    public function ctAgg($nota)
    {
        $this->where('ag_nota',$nota);
        return $this->countAllResults();
    }
    
    public function simpan_csv($data, $nota)
    {
        $existingRecord = $this->where('ag_nisn', $data['ag_nisn'])->first();
        $data['ag_nota'] = $nota;
        $this->save($data, $existingRecord);
    }
    public function updateBio($nisn, $data){
        return $this->update(['ag_nisn' => $nisn],$data);
    }
    public function cetakAnggota($nota=null, $jur=null)
    {
        $jurs=str_replace('-',' ',$jur);
        $this->orderBy('ag_jurusan','ASC');
        $this->orderBy('ag_nama', 'ASC');
        $this->where('ag_nota',$nota);
        $this->where('ag_jurusan', $jurs);
        return $this->find();
    }
    public function cetakPribadi($nota=null, $nisn=null)
    {
        $this->where('ag_nota',$nota);
        $this->where('ag_nisn', $nisn);
        return $this->first();
    }

    public function cetakKelas($nota=null, $jur=null, $kls=null)
    {
        $jurs=str_replace('-',' ',$jur);
        $this->orderBy('ag_jurusan','ASC');
        $this->orderBy('ag_nama', 'ASC');
        $this->where('ag_nota',$nota);
        $this->where('ag_jurusan', $jurs);
        $this->where('ag_klas', $kls);
        return $this->find();
    }

    public function status_cetak($nisn=null)
    {
        $data=['ag_cetak' => '1'];
        return $this->update(['ag_nisn' => $nisn],$data);
    }
}
