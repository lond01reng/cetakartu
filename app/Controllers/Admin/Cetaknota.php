<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use TCPDF;
use App\Models\AnggotaModel;
use App\Models\NotaModel;

class Cetaknota extends BaseController
{
    public function __construct()
    {
      $this->angg = new AnggotaModel();
      $this->nota = new NotaModel();
    }
    public function index($nota = null)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(148,210));
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('kang_didikw|k-dir');
        $pdf->SetTitle('cetaKartu');
        $pdf->SetSubject('cetaKartu');
        $pdf->SetKeywords('SMKNNgadirojo');
        $pdf->setPrintHeader(false);
        $nt=$this->nota->getNota1($nota);
        $ntgl=date_id(date('Y-m-d', strtotime($nt->nt_cr)));
        $pdf->SetMargins(10,10,10);
        $pdf->SetAutoPageBreak(1,5);
        $pdf->AddPage();
        $pdf->Image(base_url('uploads/kdir.png'),10,10,0,12); //bg
        $pdf->SetFont('Ubuntu', '', 9);
        $pdf->SetTextColor(29,32,136);
        $pdf->Cell(85,5,'', 0, 0, 'C');
        $pdf->Cell(45,5,'Pacitan, '.$ntgl, 0, 2, 'L');
        $pdf->Cell(45,5,'Kepada '.$nt->sch_nama, 0, 1, 'L');
        $pdf->Cell(120,7,'UP TJKT SMKN Ngadirojo', 0, 1, 'L');
        $pdf->Ln(10);
        $pdf->Cell(120,7,'Nota No. '.$nt->nt_id.date('ymd', strtotime($nt->nt_cr)), 0, 1, 'L');
        $ctAg=$this->angg->ctAgg($nota);
        $harga=8000;
        $harga1=number_format($harga,2,',','.');
        $jml=number_format($ctAg*$harga,2,',','.');
        $tbl = <<<EOD
        <table cellspacing="0" cellpadding="4" border="0.5">
            <tr style="background-color: blue;color: white; text-align: center; border: 1px solid #ddd;">
                <th width="35">QTY</th>
                <th width="170">Nama Barang</th>
                <th width="65">Harga</th>
                <th width="95">Jumlah</th>
            </tr>
            <tr>
                <td style="text-align: center;">{$ctAg}</td>
                <td>Cetak Kartu OSIS</td>
                <td style="text-align: right;">Rp.{$harga1}</td>
                <td style="text-align: right;">Rp.{$jml}</td>
            </tr>
            <tr>
                <td style="text-align: center;"></td>
                <td></td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"></td>
            </tr>
        </table>
        EOD;
        
        $pdf->writeHTML($tbl, true, false, false, false, '');
        
        // echo 'cetak nota';
        $this->response->setContentType('application/pdf');
        $pdf->Output('NotaPDF_.pdf', 'I');
    }
}
