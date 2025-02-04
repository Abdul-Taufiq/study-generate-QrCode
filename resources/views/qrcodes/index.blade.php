@extends('layout');


@section('content')
    <div class="container py-4">
        <h4>QRcode scan link!</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No Telp</th>
                    <th>Email</th>
                    <th>button</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($qrcodes as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->no_telp }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            <a href="/generate/{{ $data->id }}">Generate </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
