<?php

namespace App\Controllers\Admin;
use App\Models\NotaModel;
use App\Models\DaftarSekolahModel;
use App\Models\AnggotaModel;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function __construct()
    {
        $this->nota = new NotaModel();
        $this->ls_sch = new DaftarSekolahModel();
        $this->anggota = new AnggotaModel();
    }
    public function index()
    {
        $data=[
            'act'   => $this->request->uri->getSegment(2),
            'title' => 'Beranda',
            'notas' => $this->nota->getNota(),
            'ct_agg' => []
        ];

        foreach ($data['notas'] as $nota) {
            $ctAngg = $this->anggota->where('ag_nota', $nota->nt_id)->countAllResults();
            $data['ct_agg'][$nota->nt_id] = $ctAngg;
            // $data['jurs'][$nota->nt_id] = $this->anggota->getJurusan($nota->nt_id);
            $data['jurs'][$nota->nt_id] = $this->anggota->getJurusan($nota->nt_id);
            // echo ($this->anggota->getLastQuery());
        }
        // $data=[];'jurs'  => $this->anggota->getJurusan(),

        // print_r($data);
        return view('admin/home', $data);
    }
    public function mTambahNota()
    {
        $data['lsch']=$this->ls_sch->getSch();
        return view('admin/modal_nota', $data);
    }

    public function save_nota()
    {
        $sch_id = $this->request->getPost('sch_id');
        $ks_name = $this->request->getPost('ks_name');
        $tgl_ttd = $this->request->getPost('tgl_ttd');
        $tmpl = $this->request->getPost('tmpl');
        $data=['nt_sch'=>$sch_id,'nt_ks'=>$ks_name,'nt_tgl'=>$tgl_ttd, 'nt_tmpl'=>$tmpl];
        if(!$this->validate([
            'sch_id'=>[
                'rules'=>'required|regex_match[/^[0-9]{8}$/]',
                'errors'=>[
                    'required'=>'Belum memilih sekolah',
                    'regex_match'=>'Kode sekolah 8 digit angka'
                ]
            ],
            'ks_name'=>[
                'rules'=>'required|regex_match[/^[a-zA-Z., ]{5,64}$/]', //^[A-Za-z,. ]{5,64}$
                'errors'=>[
                    'required'=>'Nama Kepala Sekolah belum diisi',
                    'regex_match'=>'Penulisan Kepala Sekolah salah'
                ]
            ],
            'tgl_ttd'=>[
                'rules'=>'required|valid_date',
                'errors'=>[
                    'required'=>'Tanggal tanda tangan belum diisi',
                    'valid_date'=>'Format tanggal salah'
                ]
            ],
            'tmpl'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Belum memilih template'
                ]
            ]

        ]))
        {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('admin/beranda'));
        }else{
            session()->setFlashdata('success', 'Input Nota Berhasil!!!');
            $this->nota->simpan_nota($data);
            return redirect()->to(base_url('admin/beranda'));
        }
    }
    public function tambah_gambar($nota)
    {
        $data=[
            'act'   =>'beranda',
            'title' =>'Tambah Gambar',
            'nt'    => $nota
        ];
        return view('admin/tambah_gambar', $data);
    }
    public function save_gambar($nota)
    {
        $folder=$nota;

        $valRules = [
            'stamp' => 'uploaded[stamp]|max_size[stamp,1024]|mime_in[stamp,image/png]',
            'bg1' => 'uploaded[bg1]|max_size[bg1,1024]|mime_in[bg1,image/png]',
            'bg2' => 'uploaded[bg2]|max_size[bg2,1024]|mime_in[bg2,image/png]',
        ];

        $valError = [
            'stamp' => [
                'uploaded' => 'Harap pilih file stampel.',
                'max_size' => 'Ukuran file stampel tidak boleh melebihi 1 MB.',
                'mime_in' => 'Format file stampel harus berupa PNG.'
            ],
            'bg1' => [
                'uploaded' => 'Harap pilih file background depan.',
                'max_size' => 'Ukuran file background depan tidak boleh melebihi 1 MB.',
                'mime_in' => 'Format file background depan harus berupa png.'
            ],
            'bg2' => [
                'uploaded' => 'Harap pilih file background belakang.',
                'max_size' => 'Ukuran file background belakang tidak boleh melebihi 1 MB.',
                'mime_in' => 'Format file background belakang harus berupa png.'
            ],
        ];

        if(!$this->validate($valRules, $valError)){
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('admin/beranda'));
        }else{
            if(!is_dir(ROOTPATH. 'public/uploads/'.$folder)){
                mkdir (ROOTPATH. 'public/uploads/'.$folder, 0777, true);
            }
            $stpFile = $this->request->getFile('stamp');
            $stm_name='stp_'.$nota.'.png';
            $stpPath = $this->processImage($stpFile,$stm_name, 100, $folder);

            $bg1File = $this->request->getFile('bg1');
            $bg1_name='bg1_'.$nota.'.jpg';
            $bg1Path = $this->processImage($bg1File,$bg1_name, 688, $folder);

            $bg2File = $this->request->getFile('bg2');
            $bg2_name='bg2_'.$nota.'.jpg';
            $bg2Path = $this->processImage($bg2File,$bg2_name, 688, $folder);

            return redirect()->to('admin/beranda')->with('success', 'Gambar berhasil diupload.');
        }        
    }
    private function processImage($fileimg, $prefix, $height, $folder)
    {
        $image = \Config\Services::image();
        $imageName = $prefix;
        $fdpath= ROOTPATH . 'public/uploads/'.$folder;

        $image  ->withFile($fileimg)
                ->resize(0, $height, true, 'height')
                ->save($fdpath.'/'.$imageName, 90);
    }

    public function jsch()
    {
        $data=$this->ls_sch->jsSch();
        return $this->response->setJSON($data);
    }
}
