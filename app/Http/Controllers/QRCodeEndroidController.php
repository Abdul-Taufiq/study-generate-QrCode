<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Illuminate\Support\Facades\Storage;

class QRCodeEndroidController extends Controller
{
    public function generateQrCodeWithCustomStyle()
    {
        // Informasi Pribadi
        $firstName = 'John';
        $lastName = 'Doe';
        $title = 'Mr.';
        $email = 'john.doe@example.com';
        $company = "Acme Inc.";
        $job = "Developer";
        $url = "https://example.com";

        // Alamat
        $homeAddress = "123 my street st;My Beautiful Town;LV;Neverland;12345-678";
        $workAddress = "123 my work street st;My Dreadful Town;LV;Hell;12345-678";

        // Telepon
        $workPhone = 'TEL;WORK:001 555-1234';
        $homePhone = 'TEL;HOME:001 555-4321';
        $cellPhone = 'TEL;CELL:001 9999-8888';

        // Membangun string vCard
        $vCard = "BEGIN:VCARD\n";
        $vCard .= "VERSION:3.0\n";
        $vCard .= "FN:$firstName $lastName\n";
        $vCard .= "N:$lastName;$firstName;;$title\n";
        $vCard .= "EMAIL:$email\n";
        $vCard .= "ORG:$company\n";
        $vCard .= "TITLE:$job\n";
        $vCard .= "URL:$url\n";
        $vCard .= "ADR;TYPE=HOME:;;$homeAddress\n";
        $vCard .= "ADR;TYPE=WORK:;;$workAddress\n";
        $vCard .= "$workPhone\n";
        $vCard .= "$homePhone\n";
        $vCard .= "$cellPhone\n";
        $vCard .= "END:VCARD";

        // Path ke logo di direktori public
        $filepath = public_path('images/Logo.png');

        // Menghasilkan QR code dengan Endroid QrCode
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($vCard)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::Medium)
            ->size(512)
            ->margin(2)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath($filepath)
            ->logoResizeToWidth(150)
            ->logoResizeToHeight(150)
            ->labelText('My Custom QR')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->labelMargin(new Margin(15, 5, 5, 5))
            ->backgroundColor(new Color(255, 255, 255))
            ->foregroundColor(new Color(0, 102, 204))
            ->build();

        // Menyimpan QR code ke file di direktori public/hasil/
        // $output_file = public_path('hasil/qrcode_with_custom_style.png');
        // Storage::disk('public')->put($output_file, $result->getString());

        // Mengembalikan URL ke file yang disimpan
        // $url = asset('hasil/qrcode_with_custom_style.png');

        // tampilkan hasil generate as image
        // return response($result)
        //     ->header('Content-Type', 'image/png');

        // Directly output the QR code
        header('Content-Type: ' . $result->getMimeType());
        echo $result->getString();
    }
}
