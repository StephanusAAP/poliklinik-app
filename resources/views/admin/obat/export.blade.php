<!DOCTYPE html>
<html>
<head>
    <title>Export Data Obat</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th style="font-weight: bold; text-align: center;">No</th>
                <th style="font-weight: bold; text-align: center;">Nama Obat</th>
                <th style="font-weight: bold; text-align: center;">Kemasan</th>
                <th style="font-weight: bold; text-align: center;">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obats as $index => $obat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->kemasan }}</td>
                <td>{{ $obat->harga }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
