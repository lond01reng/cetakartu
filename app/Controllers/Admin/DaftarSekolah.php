<?php

namespace App\Controllers\Admin;
use App\Models\DaftarSekolahModel;

use App\Controllers\BaseController;

class DaftarSekolah extends BaseController
{
    public function __construct()
    {
        $this->ls_sch = new DaftarSekolahModel();
    }
    public function index()
    {
        $data['act'] = $this->request->getUri()->getSegment(2);;
        $data['title'] = 'Daftar Sekolah';
        $data['sch'] = $this->ls_sch->getSch();
        return view('admin/ls_sekolah', $data);
    }
}
