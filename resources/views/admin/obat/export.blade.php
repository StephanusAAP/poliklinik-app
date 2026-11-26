
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Export Data Obat</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #334155;
        }

        h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #e2e8f0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Data Obat</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kemasan</th>
                <th>Harga (Rp)</th>
                <th>Stok</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($obats as $index => $obat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td data-type="s">{{ $obat->nama_obat }}</td>
                    <td data-type="s">{{ $obat->kemasan ?? '-' }}</td>
                    <td data-type="n">{{ $obat->harga }}</td>
                    <td data-type="n">{{ $obat->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
