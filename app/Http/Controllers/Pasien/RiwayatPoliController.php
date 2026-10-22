<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPoliController extends Controller
{
    public function index()
    {
        $riwayatPendaftaran = DaftarPoli::where('id_pasien', Auth::id())
            ->with(['jadwalPeriksa.dokter.poli', 'periksas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.riwayat.index', compact('riwayatPendaftaran'));
    }

    public function show($id)
    {
        $daftarPoli = DaftarPoli::where('id_pasien', Auth::id())
            ->with([
                'jadwalPeriksa.dokter.poli',
                'periksas.detailPeriksas.obat'
            ])
            ->findOrFail($id);

        if (!$daftarPoli->periksas || $daftarPoli->periksas->count() === 0) {
            return redirect()->route('pasien.riwayat.index')->with('error', 'Pasien belum diperiksa oleh dokter.');
        }
        $periksa = $daftarPoli->periksas->first();
        return view('pasien.riwayat.show', compact('daftarPoli', 'periksa'));
    }
}
