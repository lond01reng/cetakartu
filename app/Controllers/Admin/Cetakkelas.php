<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use TCPDF;
use App\Models\AnggotaModel;
use App\Models\NotaModel;

class Cetakkelas extends BaseController
{
  private $pdf;
  public function __construct()
  {
  //   parent::construct();
    $this->angg = new AnggotaModel();
    $this->nota = new NotaModel();
    $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(200,300));
    $xmt=8;
  }

  public function generatePdf($nota = null, $jurs=null, $kls=null)
  {
      $pdf=$this->pdf;
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('kang_didikw|k-dir');
      $pdf->SetTitle('cetaKartu');
      $pdf->SetSubject('cetaKartu');
      $pdf->SetKeywords('SMKNNgadirojo,'.$jurs);
      $pdf->setPrintHeader(false);

      $pdf->SetMargins(4,4,4);
      $pdf->SetAutoPageBreak(1,5);
      $pdf->SetLineWidth(0.1);
      $pdf->AddPage();

      $boxw=96;
      $boxh=56;
      $bgw=87;
      $bgh=55;
      $ml = 4;
      $mt = 8; //4
      $bg1 = FCPATH . 'uploads/'.$nota.'/bg1_'.$nota.'.jpg';
      $bg2 = FCPATH . 'uploads/'.$nota.'/bg2_'.$nota.'.jpg';
      $ttd = FCPATH . 'uploads/'.$nota.'/stp_'.$nota.'.png';
      $plong='';
      $data=$this->angg->cetakKelas($nota, $jurs, $kls);
      
      $nt=$this->nota->getNota1($nota);
      $tmpl=$nt->nt_tmpl;
      $i=-1;
      $row=0;
      $ct=count($data);
      $pdf->Rect($ml,$mt-5,$boxw*2,5,'D');//mal
      foreach($data as $key=>$dt){
          $i++;
          $row=$i%5;
          if (file_exists(FCPATH . 'uploads/' . $nota . '/' . $dt->ag_nisn . '.jpg')) {
              $foto= FCPATH . 'uploads/'.$nota.'/'.$dt->ag_nisn.'.jpg';
          }
          elseif(file_exists(FCPATH . 'uploads/' . $nota . '/' . $dt->ag_nisn . '.png')){
              $foto= FCPATH . 'uploads/'.$nota.'/'.$dt->ag_nisn.'.png';
          }else{
              $foto='';
          }
          $nisn=$dt->ag_nisn;
          $nama=strtoupper($dt->ag_nama);
          $nis=$dt->ag_induk;
          $prodi=$dt->ag_jurusan;
          $tgll=$dt->ag_tgl=='0000-00-00'?$dt->ag_tgl:date_id(date('Y-m-d', strtotime($dt->ag_tgl)));
          $lahir=$dt->ag_tempat.', '.$tgll;
          $ortu=$dt->ag_bapak;
          $alamat1='RT '.$dt->ag_rt.' RW '.$dt->ag_rw.' '.$dt->ag_dusun.' Desa '.$dt->ag_desa;
          $alamat2='Kec '.$dt->ag_kec.', '.$dt->ag_kab;
          $sekolah=$nt->sch_nama;
          $ks=$nt->nt_ks;
          $nip=$nt->nt_nip;
          $tgl=$nt->nt_tgl;
          $nick=$dt->ag_nick;

          // startL       
          $pdf->Rect($ml,$row*$boxh+$mt,$boxw,$boxh,'D');//mal
          $pdf->Image($bg1,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh); //bg
          $this->$tmpl($ml,$mt,$row,$boxh,$boxw,$bgw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$bg2, $plong); //pilih template
          // endL
          // startR
          $pdf->Rect($ml+$boxw,$row*$boxh+$mt,$boxw,$boxh,'D');//Mal
          // endR
          if(($row%5==4 AND $key<$ct-1)){
              $pdf->AddPage();
              $pdf->Rect($ml,$mt-5,$boxw*2,5,'D');//mal
          }
      }

      $this->response->setContentType('application/pdf');
      $pdf->Output('CetaKartu_'.$nota.'_'.$sekolah.'_'.$jurs.$kls.'.pdf', 'I');
  }

  public function pribadiPdf($nota = null, $nisn=null, $ctk=null)
  {
    if(empty(session()->get('name')) && $ctk != 2){
      return redirect()->to(base_url('/'));
    }
    $dt=$this->angg->cetakPribadi($nota, $nisn);
    if(!empty($dt)){
      $pdf=$this->pdf;
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('kang_didikw|k-dir');
      $pdf->SetTitle('cetaKartu');
      $pdf->SetSubject('cetaKartu');
      $pdf->SetKeywords('SMKNNgadirojo');
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetMargins(4,4,4);
      $pdf->SetAutoPageBreak(1,5);
      $pdf->AddPage();

      // $ctk=2; #1=cetak, 2=filepdf
      $boxw=96;
      $boxh=56;
      $bgw=87;
      $bgh=55;
      $ml = 4;
      $mt = $ctk==1?4:10;
      $bg1 = FCPATH . 'uploads/' . $nota . '/bg1_' . $nota . '.jpg';
      $bg2 = FCPATH . 'uploads/'.$nota.'/bg2_'.$nota.'.jpg';
      $plong= FCPATH . 'uploads/id_plong.png';
      $ttd = FCPATH . 'uploads/'.$nota.'/stp_'.$nota.'.png';

      // $dt=$this->angg->cetakPribadi($nota, $nisn);
      $nt=$this->nota->getNota1($nota);
      $tmpl=$nt->nt_tmpl; //template

      $row=0;
      if (file_exists(FCPATH . 'uploads/' . $nota . '/' . $dt->ag_nisn . '.jpg')) {
          $foto= FCPATH . 'uploads/'.$nota.'/'.$dt->ag_nisn.'.jpg';
      }
      elseif(file_exists(FCPATH . 'uploads/' . $nota . '/' . $dt->ag_nisn . '.png')){
          $foto= FCPATH . 'uploads/'.$nota.'/'.$dt->ag_nisn.'.png';
      }else{
          $foto='';
      }
      $nisn=$dt->ag_nisn;
      $nama=strtoupper($dt->ag_nama);
      $tgll=$dt->ag_tgl=='0000-00-00'?$dt->ag_tgl:date_id(date('Y-m-d', strtotime($dt->ag_tgl)));
      $nis=$dt->ag_induk;
      $prodi=$dt->ag_jurusan;
      $lahir=$dt->ag_tempat.', '.$tgll;
      $ortu=$dt->ag_bapak;
      $alamat1='RT '.$dt->ag_rt.' RW '.$dt->ag_rw.' '.$dt->ag_dusun.' Desa '.$dt->ag_desa;
      $alamat2='Kec '.$dt->ag_kec.', '.$dt->ag_kab;
      $sekolah=$nt->sch_nama;
      $ks=$nt->nt_ks;
      $nip=$nt->nt_nip;
      $tgl=$nt->nt_tgl;
      $nick=$dt->ag_nick;
      // startL        
      $pdf->Image($bg1,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh); //bg             
      $this->$tmpl($ml,$mt,$row,$boxh,$boxw,$bgw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$bg2, $plong);//ktp_id           
      if($ctk==1){
          $pdf->Rect($ml,$row*$boxh+$mt,$boxw,$boxh,'D');//mal
          $pdf->Rect($ml+$boxw,$row*$boxh+$mt,$boxw,$boxh,'D');//Mal
      }else{
          $pdf->Image($plong,$ml+4.3,$row*$boxh+$mt+0.5,$bgw+0.2, $bgh,'PNG'); //bg plong
          $pdf->Image($plong,$ml+$boxw+4.3,$row*$boxh+$mt+0.5,$bgw+0.2, $bgh,'PNG'); //bgplong
      }
      // endL
      $tipe=$ctk==1?'Cetak_':'';
      $this->response->setContentType('application/pdf');
      $pdf->Output($tipe.$nama.'_'.$sekolah.'.pdf', 'I');
    }else{
      return redirect()->to(base_url('/'));
    }
  }

  private function ktp_id($ml,$mt,$row,$boxh,$boxw,$bgw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$bg2, $plong){
    $qrsty = array(
      'border' => 2,
      'padding' => '2',
      'fgcolor' => array(29,32,136),
      'bgcolor' => array(255,255,255), 
      'module_width' => 1, // width of a single module in points
      'module_height' => 1 // height of a single module in points
    );
    $pdf=$this->pdf;
    $ytext=$row*$boxh+14+$mt;
    $xdt1=31;
    $xdt2=$xdt1+7;
    //cardL
    $fontaw=14;
    for ($i = 0; $i < 10; $i++) {
      $fontaw -= 0.5;
      $pdf->SetFont('Ubuntu', 'B', $fontaw);
      $lbnama= $pdf->GetStringWidth($nama);
      $lebarnm = $pdf->GetStringWidth($nama);
      if($lebarnm<78){
        break;
      }
    }
    $pdf->SetTextColor(29,32,136);
    $pdf->Text(12,$ytext,($nama));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('ubuntulight', '', 7);
    $pdf->Text(12,$ytext+5.5,'NIS. '.$nis.', '.$prodi);
    $pdf->Text($xdt1,$ytext+9,$lahir);
    $pdf->Text($xdt1,$ytext+12,'Ortu '.$ortu);
    $pdf->Text($xdt1,$ytext+15,$alamat1);
    $pdf->Text($xdt1,$ytext+18,$alamat2);
    $pdf->Text($xdt1,$ytext+21.5,'Kepala '.$sekolah);
    $pdf->SetFont('Ubuntu', 'B', 7.5);
    $pdf->Text($xdt1, $ytext+31.5,$ks);
    if(!empty($nip)){
      $pdf->SetFont('ubuntulight', '', 6.5);
      $pdf->Text($xdt1, $ytext+34,'NIP. '.$nip);
    }
    $pdf->Image($foto,$ml+9,$row*$boxh+24+$mt,18,24); //foto
    $pdf->Image($ttd,$ml+23,$row*$boxh+36.5+$mt,0,12); //ttd
    $pdf->SetFont('ubuntulight', '', 6);
    $pdf->SetXY($ml+9,$row*$boxh+46+$mt);
    $pdf->SetFillColor(255, 240, 0);
    $pdf->Rect($ml+11,$row*$boxh+47.5+$mt,14,2,'F');
    $pdf->Cell(18,5,$tgl, 0, 0, 'C');
    $pdf->SetFont('Ubuntu', 'I', 6);
    $pdf->Text($ml+8,$ytext+36.5,'Berlaku selama menjadi siswa di '.$sekolah);
    $pdf->write2DBarcode($nisn, 'QRCODE,H', $boxw-20, $row*$boxh+34.5+$mt, 15, 15, $qrsty, 'N');
    $pdf->SetXY(76,$row*$boxh+49+$mt);
    $pdf->SetFont('Ubuntu', 'B', 8);
    $pdf->Cell(15,5,$nisn, 0, 0, 'C');
    //cardL
    // ======================================
    //cardR
    $pdf->SetTextColor(29,32,136);
    $pdf->StartTransform();
    $pdf->Rotate(-90);
    $pdf->Image($bg2,$ml+38.5,$row*$boxh-51.25+$mt,$bgh); //bg
    $pdf->SetLineWidth(0.8);
    $pdf->SetDrawColor(29,32,136);
    $pdf->Image($foto,57,$row*$boxh-26.25+$mt,26,0, '', '', '', false, 300, '', false, false, 1, false, false, false); //foto
    $pdf->SetDrawColor(0);
    $pdf->SetFont('Ubuntu', 'B', 13);
    $pdf->SetXY(44.5,$row*$boxh+14+$mt);
    $pdf->Cell($bgh-4,5,strtoupper($nick), 0, 1, 'C');
    $pdf->SetFont('Ubuntu', 'B', 11);
    $pdf->SetXY(44.5,$row*$boxh+22+$mt);
    $pdf->Cell($bgh-4,5,$nisn, 0, 1, 'C');
    $pdf->StopTransform();
    $pdf->SetLineWidth(0.1);
      //cardR
  }

  private function o_smk2($ml,$mt,$row,$boxh,$boxw,$bgw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$bg2, $plong){
    $qrsty = array(
      'border' => 2,
      'padding' => '2',
      'fgcolor' => array(29,32,136),
      'bgcolor' => array(255,255,255), 
      'module_width' => 1, // width of a single module in points
      'module_height' => 1 // height of a single module in points
    );
      
    $pdf=$this->pdf;
    $ytext=$row*$boxh+14+$mt;
    $xdt1=31;
    $xdt2=$xdt1+7;
    //cardL
    $fontaw=12;
    for ($i = 0; $i < 10; $i++) {
      $fontaw -= 0.5;
      $pdf->SetFont('Arial', 'B', $fontaw);
      $lbnama= $pdf->GetStringWidth($nama);
      $lebarnm = $pdf->GetStringWidth($nama);
      if($lebarnm<78){
        break;
      }
    }
    $pdf->SetTextColor(0,0,0);
    $pdf->Text(12,$ytext,($nama));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->Text(12,$ytext+5.5,'NIS. '.$nis.' NISN '.$nisn.', '.$prodi);
    $pdf->SetFont('Helvetica', '', 7);
    $pdf->Text(12,$ytext+8.5,'Tempat Tanggal Lahir '.$lahir);
    $pdf->Text($xdt1,$ytext+11.5,'Orang Tua '.$ortu);
    $pdf->Text($xdt1,$ytext+14.5,'Alamat '.$alamat1);
    $pdf->Text($xdt1,$ytext+17.5,$alamat2);
    $pdf->Text($xdt1,$ytext+20.5,'Kartu berlaku selama menjadi siswa '.$sekolah);
    $pdf->Text($xdt1+5,$ytext+24,'Pacitan, '.$tgl);
    $pdf->Text($xdt1+5, $ytext+33.5,$ks);
    if(!empty($nip)){
        $pdf->Text($xdt1+5, $ytext+36,'NIP. '.$nip);
    }
    $pdf->Image($foto,$ml+9,$row*$boxh+28+$mt,18,24); //foto
    $pdf->Image($ttd,$ml+24,$row*$boxh+37.5+$mt,0,15); //ttd
    $pdf->SetFont('Helvetica', '', 6);
    $pdf->SetXY($ml+9,$row*$boxh+46+$mt);
    //cardL
    // ======================================
    //cardR
    $pdf->Image($bg2,$boxw+$ml+4.5,$row*$boxh+0.5+$mt,87, $bgh);
    $style = array(
        'border' => false,
        'padding' => 0,
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false,
        'stretch' => true,
    );
    $xnis=explode('/',$nis);
    $pdf->StartTransform();
    $pdf->Rotate(-90);  
    $pdf->write1DBarcode($xnis[0], 'C128C', -13,$row*$boxh-57+$ml, 29.5, 11.5, 0.5, $style, 'N');
    $pdf->StopTransform();
    $pdf->SetXY($ml+28.5,$row*$boxh+$mt+50.5);
    $pdf->Cell(0,0,$xnis[0], 0, 1, 'C');
    $pdf->SetLineWidth(0.1);
    //cardR
  }

  private function p_smk2($ml,$mt,$row,$boxh,$boxw,$bgw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$bg2, $plong){
    $qrsty = array(
      'border' => 2,
      'padding' => '2',
      'fgcolor' => array(0,0,0),
      'bgcolor' => array(255,255,255), 
      'module_width' => 1, 
      'module_height' => 1 
    );
    $rilis=$tgl=='0000-00-00'?$tgl:date_id(date('Y-m-d', strtotime($tgl)));
    $pdf=$this->pdf;
    $ytext=$row*$boxh+14+$mt;
    $xdt1=31;
    $xdt2=$xdt1+7;
    //cardL
    $pdf->SetFont('Arial', 'B', 12);
    $fontaw=14;
    for ($i = 0; $i < 10; $i++) {
      $fontaw -= 0.5;
      $pdf->SetFont('Arial', 'B', $fontaw);
      $lbnama= $pdf->GetStringWidth($nama);
      $lebarnm = $pdf->GetStringWidth($nama);
      if($lebarnm<78){ //76
        break;
      }
    }
    $pdf->SetTextColor(0,0,0);
    $pdf->Text(12,$ytext,($nama)); 
    
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Text(12,$ytext+5.5,'NIS. '.$nis.', '.$prodi);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Text($xdt1,$ytext+9,$lahir);
    $pdf->Text($xdt1,$ytext+12,$alamat1);
    $pdf->Text($xdt1,$ytext+15,$alamat2);
    $pdf->Text($xdt1,$ytext+19,'Pacitan, '.$rilis);
    $pdf->Text($xdt1,$ytext+21.5,'Kepala '.$sekolah);
    $pdf->SetFont('Arial', 'B', 7.5);
    $pdf->Text($xdt1, $ytext+31.5,$ks);
    if(!empty($nip)){
        $pdf->SetFont('Arial', '', 6.5);
        $pdf->Text($xdt1, $ytext+34,'NIP. '.$nip);
    }
    $pdf->Image($foto,$ml+9,$row*$boxh+24+$mt,18,24); //foto
    $pdf->Image($ttd,$ml+23,$row*$boxh+36.5+$mt,0,12); //ttd
    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY($ml+9,$row*$boxh+46+$mt);
    $pdf->SetFillColor(8,77,189);
    $pdf->SetTextColor(255,255,255);
    $pdf->Rect($ml+9.5,$row*$boxh+47.5+$mt,17,2,'F');
    $pdf->Cell(18,5,$nisn, 0, 0, 'C');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial', 'I', 6);
    $pdf->Text($ml+8,$ytext+36.5,'Berlaku selama menjadi siswa di '.$sekolah);
    $pdf->write2DBarcode($nisn, 'QRCODE,H', $boxw-20, $row*$boxh+34.5+$mt, 15, 15, $qrsty, 'N');
    $pdf->SetXY(76,$row*$boxh+49+$mt);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(15,5,'', 0, 0, 'C');
    //cardL
    // ======================================
    //cardR
    $pdf->SetTextColor(0,0,0);
    $pdf->StartTransform();
    $pdf->Rotate(-90);
    $pdf->Image($bg2,$ml+38.5,$row*$boxh-51.25+$mt,$bgh); //bg
    $pdf->Image($foto,45,$row*$boxh-36.25+$mt,39,48.6, '', '', '', false, 300, '', false, false, 0, false, false, false); //foto
    $pdf->SetDrawColor(0);

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetXY(37.5,$row*$boxh+14+$mt);
    $pdf->Cell($bgh-4,5,$nisn, 0, 1, 'C');
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(39,$row*$boxh+22+$mt);
    $pdf->Cell($bgh-4,5,strtoupper($nick), 0, 1, 'C');

    $pdf->StopTransform();
    $pdf->SetLineWidth(0.1);
    //cardR
  }

  private function k_bkt($ml,$mt,$row,$boxh,$boxw,$bgw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$bg2, $plong){
    $pdf=$this->pdf;
    $xdt1=31;
    $xdt2=$xdt1+7;
    //cardL
    $pdf->SetFont('Arial', 'B', 12);
    $fontaw=12;
    for ($i = 0; $i < 10; $i++) {
      $fontaw -= 0.5;
      $pdf->SetFont('Arial', 'B', $fontaw);
      $lbnama= $pdf->GetStringWidth($nama);
      $lebarnm = $pdf->GetStringWidth($nama);
      if($lebarnm<40){ //76
        break;
      }
    }
    $pdf->SetXY(33.3,$row*$boxh+$mt+6.7);
    $pdf->StartTransform();
    $pdf->Rotate(-90);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(42,6,$nama, 0, 1, 'C');
    $pdf->SetXY(33.3, ($row * $boxh + $mt + 6.7) + 11.2);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(42,6,$nick, 0, 1, 'C');
    // Left Start
    // Left End 
    $pdf->StopTransform();
    // Right Start
    $pdf->Image($bg2,$boxw+$ml+4.5,$row*$boxh+$mt+0.5,$bgw,$bgh); //bg   
  }

}

