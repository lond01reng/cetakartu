<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use TCPDF;
use App\Models\AnggotaModel;

class Cetakkartu extends BaseController
{
    public function generatePdf($nota = null)
    {
        // Load library TCPDF
        $pdf = new TCPDF();

        // Set document properties
        $pdf->SetCreator('Your Name');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Hello World');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // Add a page
        $pdf->SetMargins(4,4,4);
        $pdf->SetAutoPageBreak(1,5);
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);
        
        for($i=1;$i<70;$i++){
            $pdf->Cell(0,5,$pdf->GetY(),1,1,'l');
        }

        // Add content to the page
        $pdf->Write(0, 'Hello, World!');
        $this->response->setContentType('application/pdf');
        // Save the PDF to a file (you can also use methods like Output(), which sends PDF to the browser)
        $pdf->Output('hello_world.pdf', 'I');
    }
}
