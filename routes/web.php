<?php

use App\Http\Controllers\PDFTextController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\PDFTotextController;
use App\Http\Controllers\QRCodeEndroidController;
use App\Http\Middleware\PermissionAccess;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('config:clear');
    // $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('view:cache');
    // $exitCode = Artisan::call('optimize:clear');
    // $exitCode = Artisan::call('logs:clear');
    return 'DONE'; //Return anything
});

Route::get('/', function () {
    return view('home');
})->middleware('permissions');

// SimpleQrcode with ID
Route::resource('qrcode', QrcodeController::class);
Route::any('/generate/{id}', [QrcodeController::class, 'generate']);
Route::get('/generate-qrcode-with-logo', [QrCodeController::class, 'generateQrCodeWithLogo'])->name('generate-logo');

// SimpleQRcode vcard
Route::get('/generate-contact-qrcode', [QrCodeController::class, 'generateContactQrCode'])->name('generate-vcard');

// with endroid qrcode
Route::get('/generate-qrcode-with-custom-style', [QRCodeEndroidController::class, 'generateQrCodeWithCustomStyle'])->name('generate-endroid');



// PDF to TEXT (Spatie) / smalot pdfparser
Route::get('/uploadp', [PDFTextController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [PDFTextController::class, 'handleUpload'])->name('upload.handle');
