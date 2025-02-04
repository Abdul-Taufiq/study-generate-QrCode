<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="background-color: burlywood">
    <table>
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

    <img src="{{ asset('images/logonew.png') }}" style="border-radius: 50%; width: 30%" alt="">

</body>

</html>
