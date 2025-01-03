<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use TCPDF;
use App\Models\AnggotaModel;
use App\Models\NotaModel;

class Cetakkartu extends BaseController
{
    public function __construct()
    {
    //   parent::construct();
      $this->angg = new AnggotaModel();
      $this->nota = new NotaModel();

    }

    public function generatePdf($nota = null, $jurs=null)
    {
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

        $pdf->SetFont('helvetica', '', 8);
        $boxw=96;
        $boxh=56;
        $bgw=87;
        $bgh=55;
        $ml = 4;
        $mt = 4;
        $bg1 = base_url('uploads/'.$nota.'/bg1_'.$nota.'.jpg');
        $bg2 = base_url('uploads/'.$nota.'/bg2_'.$nota.'.jpg');
        $ttd = base_url('uploads/'.$nota.'/stp_'.$nota.'.png');
        // dd($ttd);
        $nisn= '1234567890';
        

        //pdfStyle
        $style = array(
            'border' => 2,
            'padding' => '2',
            'fgcolor' => array(29,32,136),
            'bgcolor' => array(255,255,255), //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        $data=$this->angg->cetakAnggota($nota, $jurs);
        
        $nt=$this->nota->getNota1($nota);
        $i=-1;
        $row=0;
        $ct=count($data);
        foreach($data as $key=>$dt){
            $i++;
            $row=$i%5;
            $ytext=$row*$boxh+18;
            $xdt1=31;
            $xdt2=$xdt1+7;
            $foto= base_url('uploads/'.$nota.'/'.$dt->ag_nisn.'.jpg');


            // endR
            if(($row%5==4 AND $key<$ct-1)){
                $pdf->AddPage();
            }
        }
        // dd('CetakPDF'.$nota.'_'.$jurs.'.pdf');
        $this->response->setContentType('application/pdf');
        $pdf->Output('CetakPDF'.$nota.'_'.$jurs.'.pdf', 'I');
        
    }
    private function ktp_id(){
                    // startL
            $pdf->Rect($ml,$row*$boxh+$mt,$boxw,$boxh,'D');//mal
            $pdf->Image($bg1,$ml+4.5,$row*$boxh+$mt+0.5,$bgw, $bgh); //bg
            $pdf->SetFont('Ubuntu', 'B', 14);
            $pdf->SetTextColor(29,32,136);
            $pdf->Text(12,$ytext,strtoupper($dt->ag_nama));
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('UbuntuL', '', 7);
            $pdf->Text(12,$ytext+5.5,'NIS. '.$dt->ag_induk.', '.$dt->ag_jurusan);
            $pdf->Text($xdt1,$ytext+9,$dt->ag_tempat.', '.date_id(date('Y-m-d', strtotime($dt->ag_tgl))));
            $pdf->Text($xdt1,$ytext+12,'Ortu '.$dt->ag_bapak);
            $pdf->Text($xdt1,$ytext+15,'RT '.$dt->ag_rt.' RW '.$dt->ag_rw.' '.$dt->ag_dusun.' Desa '.$dt->ag_desa);
            $pdf->Text($xdt1,$ytext+18,'Kec '.$dt->ag_kec.', '.$dt->ag_kab);
            $pdf->Text($xdt1,$ytext+21.5,'Kepala '.$nt->sch_nama);
            $pdf->Text($xdt1, $ytext+31.5,$nt->nt_ks);
            if(!empty($nt->nt_nip)){
                $pdf->Text($xdt1, $ytext+34,'NIP. '.$nt->nt_nip);
            }
            $pdf->Image($foto,$ml+9,$row*$boxh+28,18,24); //foto
            $pdf->Image($ttd,$ml+23,$row*$boxh+40.5,0,12); //ttd
            $pdf->SetFont('UbuntuL', '', 6);
            $pdf->SetXY($ml+9,$row*$boxh+50);
            $pdf->Cell(18,5,$nt->nt_tgl, 0, 0, 'C');
            $pdf->SetFont('Ubuntu', 'I', 6);
            $pdf->Text($ml+8,$ytext+36.5,'Berlaku selama menjadi siswa di '.$nt->sch_nama);
            $pdf->write2DBarcode($dt->ag_nisn, 'QRCODE,H', $boxw-20, $row*$boxh+38.5, 15, 15, $style, 'N');
            $pdf->SetXY(76,$row*$boxh+53);
            $pdf->SetFont('Ubuntu', 'B', 8);
            $pdf->Cell(15,5,$dt->ag_nisn, 0, 0, 'C');
            $pdf->Rect($ml+5,$row*$boxh+$mt+1,$bgw-1,$bgh-1,'D'); //batas potong kartu
            // endL
            // ==================================================================================
            // startR
            $pdf->Rect($ml+$boxw,$row*$boxh+$mt,$boxw,$boxh,'D');//Mal
            
            $pdf->SetTextColor(29,32,136);
            $pdf->StartTransform();
            $pdf->Rotate(-90);
            $pdf->Image($bg2,42.5,$row*$boxh-47.25,$bgh); //bg
            $pdf->SetLineWidth(0.8);
            $pdf->SetDrawColor(29,32,136);
            $pdf->Image($foto,57,$row*$boxh-22.25,26,0, '', '', '', false, 300, '', false, false, 1, false, false, false); //foto
            $pdf->SetLineWidth(0.2);
            $pdf->SetDrawColor(0);
            $pdf->SetFont('Ubuntu', 'B', 13);
            $pdf->SetXY(44.5,$row*$boxh+18);
            $pdf->Cell($bgh-4,5,strtoupper($dt->ag_nick), 0, 1, 'C');
            $pdf->SetFont('Ubuntu', 'B', 11);
            $pdf->SetXY(44.5,$row*$boxh+25);
            $pdf->Cell($bgh-4,5,strtoupper($dt->ag_nisn), 0, 1, 'C');
            $pdf->StopTransform();
            $pdf->Rect($ml+$boxw+5,$mt+1,$bgw-1,$bgh-1,'D'); //batas potong kartu
    }
}
