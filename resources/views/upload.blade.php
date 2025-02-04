@extends('layout');


@section('content')
    <div class="container">

        <h1 class="mb-4">Cek Data dari PDF</h1>
        <form action="{{ route('upload.handle') }}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="file">Upload PDF:</label>
            <input type="file" name="file" id="file" accept="application/pdf">
            <button type="submit">Upload</button>
        </form>
    </div>
@endsection
