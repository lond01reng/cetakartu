<?php

namespace App\Controllers;
use App\Models\UseradmModel;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $useradm;
    public function __construct()
    {
        $this->useradm = new UseradmModel();
    }
    public function index()
    {
        // echo password_hash(strrev('loroG2022'),PASSWORD_BCRYPT);
        return view('auth');
    }

    public function proses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if(!$this->validate([
            'username' => [
                'rules'=> 'required|trim|regex_match[/^[a-z0-9]{5,}$/]',
                'errors' => [
                    'required'=> "Username wajib diisi",
                    'regex_match'=>'Username minimal 5 digit huruf kecil atau angka'
                ]
            ],
            'password'=>[
                'rules'=> 'required|trim|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/]',
                'errors'=> [
                    'required'=>'Password Wajib diisi',
                    'regex_match' => 'Format password tidak sesuai'
                ]
            ]
        ])){
            return redirect()->to(base_url('admin'))->withInput()->with('errors', $this->validator->getErrors());
        }else{
            $cekus=$this->useradm->cekuser($username);
            if(!empty($cekus)){
                $pasw=$cekus->adm_pasw;
                $verifpas=password_verify(strrev($password),$pasw);
                if($verifpas AND $cekus->adm_status=='vl'){
                    $sessdata=[
                        'name'=>$cekus->adm_nama,
                        'isAdmin'=>strrev(md5($cekus->adm_uname)),
                        'level'=> $cekus->adm_level,

                    ];
                    session()->set($sessdata);
                    return redirect()->to(base_url('admin/beranda'));
                }else{
                    session()->setFlashdata('errors.password', 'Password salah');
                    return redirect()->to(base_url('admin'))->withInput();
                }
            }else{
                session()->setFlashdata('errors.username', 'User tidak diketemukan');
                return redirect()->to(base_url('admin'))->withInput();
            }
        }
    }

    private function validateUser($username, $password)
    {
        return $this->useradm->cekuser($username, $password);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}

