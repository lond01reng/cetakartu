<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['act']='';
        $data['title']='Home';
        return view('home', $data);
    }

}
