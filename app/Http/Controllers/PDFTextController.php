<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;

class PDFTextController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName(); // Rename file to avoid conflicts
        $path = $file->move(public_path('file_upload'), $namaFile);

        // Parse PDF file and build necessary objects.
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($path);

        // extract text of the whole PDF
        $text = $pdf->getText();
        echo $text;

        // Define required skills
        $requiredSkills = [
            'jujur',
            'berpenampilan menarik',
            // Add other skills here
        ];

        // Check if any of the required skills are in the PDF text
        $foundSkills = [];
        foreach ($requiredSkills as $skill) {
            if (stripos($text, $skill) !== false) {
                $foundSkills[] = $skill;
            }
        }

        // Determine result
        if (!empty($foundSkills)) {
            $result = 'Lolos menuju step selanjutnya. Skills found: ' . implode(', ', $foundSkills);
        } else {
            $result = 'Tidak lolos. Required skills not found.';
        }

        return view('result', compact('result'));
    }
}
