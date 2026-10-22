<!DOCTYPE html>
<html>

<head>
    <title>Export Data Dokter</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Alamat</th>
                <th>No KTP</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Spesialis/Poli</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dokters as $index => $dokter)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $dokter->nama }}</td>
                    <td>{{ $dokter->alamat }}</td>
                    <td>{{ $dokter->no_ktp }}</td>
                    <td>{{ $dokter->no_hp }}</td>
                    <td>{{ $dokter->email }}</td>
                    <td>{{ $dokter->poli->nama_poli ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>

</html>
