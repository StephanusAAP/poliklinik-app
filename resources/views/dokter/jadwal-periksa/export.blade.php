<!DOCTYPE html>
<html>
<head>
    <title>Export Jadwal Periksa</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th style="font-weight: bold; text-align: center;">No</th>
                <th style="font-weight: bold; text-align: center;">Hari</th>
                <th style="font-weight: bold; text-align: center;">Jam Mulai</th>
                <th style="font-weight: bold; text-align: center;">Jam Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $index => $jadwal)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ $jadwal->jam_mulai }}</td>
                <td>{{ $jadwal->jam_selesai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
