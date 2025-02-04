<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodes;

use function Termwind\style;

class QrcodeController extends Controller
{
    public function index()
    {
        $qrcodes = Qrcode::all();

        return view('qrcodes.index', compact('qrcodes'));
    }


    public function generate($id)
    {
        $data = Qrcode::find($id);

        // pengarahan ketika habis discan
        $url = route('qrcode.show', ['qrcode' => $id]);

        // membuat qr
        $qrcode = QrCodes::size(300)->generate($url);

        return view('qrcodes.generate', compact('qrcode', 'data'));
    }


    public function show(Qrcode $qrcode)
    {
        // hasil scan akan diarahkan kesini lewat qrcode
        dd($qrcode);
    }


    public function generateQrCodeWithLogo()
    {
        // URL yang akan disimpan dalam QR code
        $url = 'https://bprkusumasumbing.com';
        // Path ke logo di direktori public
        $logoPath = public_path('images/logonew.png');

        // Membuat QR code dengan logo di tengahnya
        $qrcode = QrCodes::format('png')
            ->merge($logoPath, 0.5, true) // Path ke logo, ukuran dan transparansi
            ->size(300)
            ->errorCorrection('H')
            ->generate($url);

        // Menyimpan QR code ke file atau mengirim langsung ke view
        $output_file = 'qrcode_with_logo.png';
        Storage::disk('local')->put($output_file, $qrcode);

        return view('qrcodes.index2', compact('output_file'));
    }


    //VCARD
    public function generateContactQrCode()
    {
        // Personal Information
        $firstName = 'John';
        $lastName = 'Doe';
        $title = 'Mr.';
        $email = 'john.doe@example.com';
        $company = "Acme Inc.";
        $job = "Developer";
        $url = "https://example.com";

        // Addresses
        $homeAddress = "123 my street st;My Beautiful Town;LV;Neverland;12345-678";
        $workAddress = "123 my work street st;My Dreadful Town;LV;Hell;12345-678";

        // Phones
        $workPhone = 'TEL;WORK:001 555-1234';
        $homePhone = 'TEL;HOME:001 555-4321';
        $cellPhone = 'TEL;CELL:001 9999-8888';

        // Building vCard string
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

        // Generate QR code
        $filepath = public_path('images/logo-rounded.png', style('border-radius: 50%'));
        $qrCode = QrCodes::size(512)
            ->style('dot') // style menjadi titik
            ->eye('circle') // menambahkan pojok kotak dan bulat
            // ->merge($filepath, 0.3, true)
            ->merge($filepath, 0.5, true)
            ->color(0, 102, 204) // Warna biru (sesuaikan dengan gambar yang diunggah)
            ->color(0, 0, 0) // Warna hitam
            ->margin(2)
            ->errorCorrection('M') //L = low, M = medium, Q = Quartile, H = high
            ->format('png')
            ->generate($vCard);

        // Menyimpan QR code ke file di direktori public/hasil/
        $output_file = public_path('hasil/qrcode_witfddh_logo.png');
        File::put($output_file, $qrCode);

        // tampilkan hasil generate as image
        return response($qrCode)
            ->header('Content-Type', 'image/png');
    }
}
