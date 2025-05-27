<?php

namespace App\Controllers;
use App\Models\AnggotaModel;

class Home extends BaseController
{
    public function __construct()
    {
      $this->angg = new AnggotaModel();
    }
    public function index()
    {
        $data['act']='';
        $data['title']='Pencarian Data';
        return view('home', $data);
    }

    public function cariSiswa(){
        $nisn=esc($this->request->getPost('nisn'));
        $tgl=esc($this->request->getPost('tgl'));
        if(!$this->validate([
          'nisn' => [
            'rules'=> 'required|regex_match[/^[0-9]{10}$/]',
            'errors' => [
              'required'=>'NISN Wajib Diisi',
              'regex_match'=>'NISN harus 10 karakter angka',
            ]
          ],
          'tgl'=>[
            'rules'=>'required|valid_date',
            'errors'=>[
              'required'=>'Tanggal Lahir Wajib Diisi',
              'valid_date'=> 'Format tanggal "yyyy-mm-dd"'
            ]
          ]
        ]))
        {
          return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }else{
          $info=$this->angg->getNisnPublik($nisn,$tgl);
          if(empty($info)){
            return redirect()->to(base_url('/'))->withInput()->with('nodata', 'Data Tidak ditemukan, ulangi pencarian!');
          }elseif($info->ag_cetak!='1'){
            return redirect()->to(base_url('/'))->withInput()->with('nodata', 'Kartu Belum Dicetak, Hubungi Administrator!');
          }else{
            $nisn=$info->ag_nisn;
            $nota=$info->ag_nota;
            // return redirect()->to(base_url('cetak_pdf/'.$nota.'/'.$nisn.'/2')); 
            $data=[
                'act'=>'',
                'title'=>'Pencarian NISN '.$nisn,
                'nisn'=>$nisn,
                'nota'=>$nota,
            ];
            return view('home', $data);
          }
        }
    }
}
