<?php

namespace App\Controllers\Admin;
use App\Models\AnggotaModel;
use App\Controllers\BaseController;

class Dataexcel extends BaseController
{
    public function __construct()
    {
      $this->angg = new AnggotaModel();
    }
    public function index()
    {
      $file_name = 'student_details_on_'.date('Ymd').'.csv'; 
      header("Content-Description: File Transfer"); 
      header("Content-Disposition: attachment; filename=$file_name"); 
      header("Content-Type: application/csv;");
   
     // get data 
     $student_data = $this->angg->fetch_data();

     // file creation 
     $file = fopen('php://output', 'w');
 
     $header = array("Student Name","Student Phone"); 
     fputcsv($file, $header);
     foreach ($data->result_array() as $key => $value)
     { 
       fputcsv($file, $value); 
     }
     fclose($file); 
     exit; 
    }
}
