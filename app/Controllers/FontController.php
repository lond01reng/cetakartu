<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF_FONTS;

class FontController extends BaseController
{
    public function index()
    {
        return view('font_upload');
    }
    public function upload()
    {
        $file = $this->request->getFile('font_file');

        if (!$file->isValid() || $file->getClientExtension() != 'ttf') {
            return redirect()->back()->with('error', 'Invalid TTF file.');
        }

        // Ambil nama asli file tanpa ekstensi & aman untuk nama file
        $originalName = pathinfo($file->getName(), PATHINFO_FILENAME);
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($originalName)) . '.ttf';

        // Path upload sementara
        $uploadPath = ROOTPATH . 'public/uploads/' . $safeName;
        $file->move(ROOTPATH . 'public/uploads', $safeName);

        // Output folder fonts TCPDF
        $outputPath = ROOTPATH . 'vendor/tecnickcom/tcpdf/fonts/';

        // Nama file hasil (.php & .z)
        $fontNameBase = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($originalName));
        $phpFontFile = $outputPath . $fontNameBase . '.php';
        $zFontFile   = $outputPath . $fontNameBase . '.z';

        // Hapus file lama jika sudah ada
        if (file_exists($phpFontFile)) {
            unlink($phpFontFile);
        }

        if (file_exists($zFontFile)) {
            unlink($zFontFile);
        }

        // Convert TTF to .php and .z (overwrite mode)
        $fontname = TCPDF_FONTS::addTTFfont(
            $uploadPath,
            'TrueTypeUnicode',
            '',
            32,
            $outputPath
        );

        // Hapus file upload sementara
        unlink($uploadPath);

        if ($fontname) {
            return redirect()->back()->with('success', "Font converted successfully: $fontname");
        } else {
            return redirect()->back()->with('error', 'Font conversion failed.');
        }
    }
}
