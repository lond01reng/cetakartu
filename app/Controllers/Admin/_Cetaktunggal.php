<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use TCPDF;
use App\Models\AnggotaModel;
use App\Models\NotaModel;

class Cetaktunggal extends BaseController
{
    private $pdf;
    public function __construct()
    {
    //   parent::construct();
      $this->angg = new AnggotaModel();
      $this->nota = new NotaModel();
      $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(200,300));

    }
    public function generatePdf($nota = null, $jurs=null)
    {
        $pdf=$this->pdf;
        $data=$this->angg->cetakAnggota($nota, $jurs);
        
        foreach($data as $dt){
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(200,300));
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('kang_didikw|k-dir');
            $pdf->SetTitle('cetaKartu');
            $pdf->SetSubject('cetaKartu');
            $pdf->SetKeywords('SMKNNgadirojo,'.$jurs);
            $pdf->setPrintHeader(false);
            $pdf->SetMargins(4,4,4);
            $pdf->SetAutoPageBreak(1,5);
            $pdf->AddPage();
            
            $boxw=96;
            $boxh=56;
            $bgw=87;
            $bgh=55;
            $ml = 4;
            $mt = 4;
            $bg1 = base_url('uploads/'.$nota.'/bg1_'.$nota.'.jpg');
            $bg2 = base_url('uploads/'.$nota.'/bg2_'.$nota.'.jpg');
            $ttd = base_url('uploads/'.$nota.'/stp_'.$nota.'.png');
            $plong='';
            //dfcard
            //pdfStyle
            $qrsty = array(
                'border' => 2,
                'padding' => '2',
                'fgcolor' => array(29,32,136),
                'bgcolor' => array(255,255,255), //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            
            
            $nt=$this->nota->getNota1($nota);
            $tmpl=$nt->nt_tmpl;
            $i=-1;
            $row=0;
            $ct=count($data);
            
            $i++;
            $row=$i%5;
            $foto= base_url('uploads/'.$nota.'/'.$dt->ag_nisn.'.jpg');
            $nisn=$dt->ag_nisn;
            $nama=$dt->ag_nama;
            $nis=$dt->ag_induk;
            $prodi=$dt->ag_jurusan;
            $lahir=$dt->ag_tempat.', '.date_id(date('Y-m-d', strtotime($dt->ag_tgl)));
            $ortu='Ortu '.$dt->ag_bapak;
            $alamat1='RT '.$dt->ag_rt.' RW '.$dt->ag_rw.' '.$dt->ag_dusun.' Desa '.$dt->ag_desa;
            $alamat2='Kec '.$dt->ag_kec.', '.$dt->ag_kab;
            $sekolah=$nt->sch_nama;
            $ks=$nt->nt_ks;
            $nip=$nt->nt_nip;
            $tgl=$nt->nt_tgl;
            $nick=$dt->ag_nick;

            // startL
            // $pdf->Rect($ml,$row*$boxh+$mt,$boxw,$boxh,'D');//mal
            $pdf->Image($bg1,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh); //bg
            
            $pdf->Image($plong,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh,'PNG'); //bg plong
            $pdf->Cell(18,5,$tgl, 0, 0, 'C');
            // $this->ktp_id($ml,$row,$boxh,$boxw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$qrsty,$bg2, $plong);
            // $pdf->Rect($ml+5,$row*$boxh+$mt+1,$bgw-1,$bgh-1,'D'); //batas potong kartu
            // endL
            // ==================================================================================
            // startR
            // $pdf->Rect($ml+$boxw,$row*$boxh+$mt,$boxw,$boxh,'D');//Mal
            // $pdf->Rect($ml+$boxw+5,$mt+1,$bgw-1,$bgh-1,'D'); //batas potong kartu
            // endR
            $pdf->Image($plong,$ml+$boxw+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh,'PNG');

            $outputFilePath = WRITEPATH . 'pdf/' . 'filename_' . $dt->ag_nisn . '.pdf';
            $pdf->Output($outputFilePath, 'I');
            unset($pdf);
        }
    }
    public function generatePdf2($nota = null, $jurs=null)
    {

        // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(200,300));
        $data=$this->angg->cetakAnggota($nota, $jurs);
        foreach($data as $key=>$dt){
        $pdf=$this->pdf;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('kang_didikw|k-dir');
        $pdf->SetTitle('cetaKartu');
        $pdf->SetSubject('cetaKartu');
        $pdf->SetKeywords('SMKNNgadirojo,'.$jurs);
        $pdf->setPrintHeader(false);

        $pdf->SetMargins(4,4,4);
        $pdf->SetAutoPageBreak(1,5);
        $pdf->AddPage();

        // $pdf->SetFont('helvetica', '', 8);
        //dfcard
        $boxw=96;
        $boxh=56;
        $bgw=87;
        $bgh=55;
        $ml = 4;
        $mt = 4;
        $bg1 = base_url('uploads/'.$nota.'/bg1_'.$nota.'.jpg');
        $bg2 = base_url('uploads/'.$nota.'/bg2_'.$nota.'.jpg');
        $ttd = base_url('uploads/'.$nota.'/stp_'.$nota.'.png');
        $plong='';
        //dfcard
        //pdfStyle
        $qrsty = array(
            'border' => 2,
            'padding' => '2',
            'fgcolor' => array(29,32,136),
            'bgcolor' => array(255,255,255), //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        
        
        $nt=$this->nota->getNota1($nota);
        $tmpl=$nt->nt_tmpl;
        $i=-1;
        $row=0;
        $ct=count($data);
        
            $pdf->AddPage();
            $i++;
            $row=$i%5;
            $foto= base_url('uploads/'.$nota.'/'.$dt->ag_nisn.'.jpg');
            $nisn=$dt->ag_nisn;
            $nama=$dt->ag_nama;
            $nis=$dt->ag_induk;
            $prodi=$dt->ag_jurusan;
            $lahir=$dt->ag_tempat.', '.date_id(date('Y-m-d', strtotime($dt->ag_tgl)));
            $ortu='Ortu '.$dt->ag_bapak;
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
            $pdf->Image($plong,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh,'PNG'); //bg plong
            $this->ktp_id($ml,$row,$boxh,$boxw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$qrsty,$bg2, $plong);
            // $pdf->Rect($ml+5,$row*$boxh+$mt+1,$bgw-1,$bgh-1,'D'); //batas potong kartu
            // endL
            // ==================================================================================
            // startR
            // $pdf->Rect($ml+$boxw,$row*$boxh+$mt,$boxw,$boxh,'D');//Mal
            // $pdf->Rect($ml+$boxw+5,$mt+1,$bgw-1,$bgh-1,'D'); //batas potong kartu
            // endR
            $pdf->Image($plong,$ml+$boxw+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh,'PNG');
            // if(($row%5==4 AND $key<$ct-1)){
            //     $pdf->AddPage();
            // }

            $this->response->setContentType('application/pdf');
            $pdf->Output($dt->ag_nisn.'_'.$sekolah.'_'.$jurs.'.pdf', 'D');
            $pdf->reset();
        }


    }


    private function ktp_id($ml,$row,$boxh,$boxw,$bgh,$nisn,$nama,$nis,$prodi,$lahir,$ortu,$alamat1,$alamat2,$sekolah,$ks,$nip,$foto,$ttd,$tgl,$nick,$qrsty,$bg2, $plong){
        $pdf=$this->pdf;
        $ytext=$row*$boxh+18;
        $xdt1=31;
        $xdt2=$xdt1+7;
        //cardL
        $pdf->SetFont('Ubuntu', 'B', 14);
        $pdf->SetTextColor(29,32,136);
        $pdf->Text(12,$ytext,strtoupper($nama));
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('UbuntuL', '', 7);
        $pdf->Text(12,$ytext+5.5,'NIS. '.$nis.', '.$prodi);
        $pdf->Text($xdt1,$ytext+9,$lahir);
        $pdf->Text($xdt1,$ytext+12,$ortu);
        $pdf->Text($xdt1,$ytext+15,$alamat1);
        $pdf->Text($xdt1,$ytext+18,$alamat2);
        $pdf->Text($xdt1,$ytext+21.5,'Kepala '.$sekolah);
        $pdf->Text($xdt1, $ytext+31.5,$ks);
        if(!empty($nip)){
            $pdf->Text($xdt1, $ytext+34,'NIP. '.$nip);
        }
        $pdf->Image($foto,$ml+9,$row*$boxh+28,18,24); //foto
        $pdf->Image($ttd,$ml+23,$row*$boxh+40.5,0,12); //ttd
        $pdf->SetFont('UbuntuL', '', 6);
        $pdf->SetXY($ml+9,$row*$boxh+50);
        $pdf->Cell(18,5,$tgl, 0, 0, 'C');
        $pdf->SetFont('Ubuntu', 'I', 6);
        $pdf->Text($ml+8,$ytext+36.5,'Berlaku selama menjadi siswa di '.$sekolah);
        $pdf->write2DBarcode($nisn, 'QRCODE,H', $boxw-20, $row*$boxh+38.5, 15, 15, $qrsty, 'N');
        $pdf->SetXY(76,$row*$boxh+53);
        $pdf->SetFont('Ubuntu', 'B', 8);
        $pdf->Cell(15,5,$nisn, 0, 0, 'C');
        //cardL
        // ======================================
        //cardR
        $pdf->SetTextColor(29,32,136);
        $pdf->StartTransform();
        $pdf->Rotate(-90);
        $pdf->Image($bg2,42.5,$row*$boxh-47.25,$bgh); //bg
        // $pdf->Image($plong,42.5,$row*$boxh-47.25,$bgh); //bg
        // $pdf->Image($plong,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh,'PNG');
        $pdf->SetLineWidth(0.8);
        $pdf->SetDrawColor(29,32,136);
        $pdf->Image($foto,57,$row*$boxh-22.25,26,0, '', '', '', false, 300, '', false, false, 1, false, false, false); //foto
        $pdf->SetLineWidth(0.1);
        $pdf->SetDrawColor(0);
        $pdf->SetFont('Ubuntu', 'B', 13);
        $pdf->SetXY(44.5,$row*$boxh+18);
        $pdf->Cell($bgh-4,5,strtoupper($nick), 0, 1, 'C');
        $pdf->SetFont('Ubuntu', 'B', 11);
        $pdf->SetXY(44.5,$row*$boxh+25);
        $pdf->Cell($bgh-4,5,$nisn, 0, 1, 'C');
        $pdf->StopTransform();
        //cardR
    }
}

