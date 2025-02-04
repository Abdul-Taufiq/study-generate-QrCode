@extends('layout');

<style>
    #center {
        text-align: center;
    }
</style>

@section('content')
    <div class="container">
        <div class="" id="center">
            <h1>QR Code with Logo</h1>
            <img src="{{ asset($output_file) }}" alt="QR Code with Logo">
            <p>Scan QR code ini untuk akses web.</p>
        </div>
    </div>
@endsection
