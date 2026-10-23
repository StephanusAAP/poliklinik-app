<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $antrianAktif = DaftarPoli::with('jadwalPeriksa.dokter.poli')
            ->where('id_pasien', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->whereDoesntHave('periksas')
            ->first();

        $antrianSekarang = 0;

        if ($antrianAktif) {
            $antrianSekarang = DaftarPoli::where('id_jadwal', $antrianAktif->id_jadwal)
                ->whereDate('created_at', Carbon::today())
                ->whereHas('periksas')
                ->max('no_antrian') ?? 0;
        }

        $jadwals = JadwalPeriksa::with('dokter.poli')->get();

        foreach ($jadwals as $jadwal) {
            $jadwal->antrian_sekarang = DaftarPoli::where('id_jadwal', $jadwal->id)
                ->whereDate('created_at', Carbon::today())
                ->whereHas('periksas')
                ->max('no_antrian') ?? 0;
        }

        return view('pasien.dashboard', compact('antrianAktif', 'antrianSekarang', 'jadwals'));
    }
}
