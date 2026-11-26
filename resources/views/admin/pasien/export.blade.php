
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Export Data Pasien</title>

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
    <h2>Data Pasien</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
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
                    <td data-type="s">{{ $pasien->nama }}</td>
                    <td data-type="s">{{ $pasien->alamat }}</td>
                    <td data-type="s">{{ $pasien->no_ktp }}</td>
                    <td data-type="s">{{ $pasien->no_hp }}</td>
                    <td data-type="s">{{ $pasien->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
