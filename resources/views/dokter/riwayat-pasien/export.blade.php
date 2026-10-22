<!DOCTYPE html>
<html>

<head>
    <title>Export Riwayat Pasien</title>
</head>

<body>
    <table border="1">
        <thead>
            <tr>
                <th style="font-weight: bold; text-align: center;">No</th>
                <th style="font-weight: bold; text-align: center;">Tanggal Periksa</th>
                <th style="font-weight: bold; text-align: center;">Nama Pasien</th>
                <th style="font-weight: bold; text-align: center;">No Antrian</th>
                <th style="font-weight: bold; text-align: center;">Keluhan</th>
                <th style="font-weight: bold; text-align: center;">Catatan Dokter</th>
                <th style="font-weight: bold; text-align: center;">Obat yang Diresepkan</th>
                <th style="font-weight: bold; text-align: center;">Total Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayatPasien as $index => $riwayat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d/m/Y H:i') }}</td>
                    <td>{{ $riwayat->daftarPoli->pasien->nama ?? '-' }}</td>
                    <td>{{ $riwayat->daftarPoli->no_antrian }}</td>
                    <td>{{ $riwayat->daftarPoli->keluhan }}</td>
                    <td>{{ $riwayat->catatan }}</td>
                    <td>
                        @if ($riwayat->detailPeriksas->count() > 0)
                            {{ $riwayat->detailPeriksas->pluck('obat.nama_obat')->implode(', ') }}
                        @else
                            Tidak ada
                        @endif
                    </td>
                    <td>{{ $riwayat->biaya_periksa }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
