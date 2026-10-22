<!DOCTYPE html>
<html>

<head>
    <title>Export Data Pasien</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Nama Pasien</th>
                <th>Alamat</th>
                <th>No KTP</th>
                <th>No HP</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $index => $pasien)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pasien->nama }}</td>
                    <td>{{ $pasien->alamat }}</td>
                    <td>{{ $pasien->no_ktp }}</td>
                    <td>{{ $pasien->no_hp }}</td>
                    <td>{{ $pasien->email }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>
