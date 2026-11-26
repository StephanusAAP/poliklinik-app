
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Export Data Dokter</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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
            overflow-wrap: break-word;
        }

        th {
            background-color: #e2e8f0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Data Dokter</h2>

    <table>
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
                    <td data-type="s">{{ $dokter->nama }}</td>
                    <td data-type="s">{{ $dokter->alamat }}</td>
                    <td data-type="s">{{ $dokter->no_ktp }}</td>
                    <td data-type="s">{{ $dokter->no_hp }}</td>
                    <td data-type="s">{{ $dokter->email }}</td>
                    <td data-type="s">{{ $dokter->poli->nama_poli ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
