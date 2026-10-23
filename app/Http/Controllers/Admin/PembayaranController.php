<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PembayaranLunas;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter'])
            ->whereNotNull('bukti_bayar')
            ->orderByRaw("FIELD(status_bayar, 'Menunggu Verifikasi', 'Lunas')")
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function verify($id)
    {
        $periksa = Periksa::with('daftarPoli.pasien')->findOrFail($id);
        $periksa->update(['status_bayar' => 'Lunas']);

        $pasien = $periksa->daftarPoli->pasien;
        if ($pasien) {
            $pasien->notify(new PembayaranLunas($periksa));
        }

        return back()->with('success', 'Pembayaran pasien berhasil diverifikasi menjadi Lunas.');
    }
    public function reject($id)
    {
        $periksa = Periksa::findOrFail($id);

        if ($periksa->bukti_bayar && Storage::disk('public')->exists($periksa->bukti_bayar)) {
            Storage::disk('public')->delete($periksa->bukti_bayar);
        }
        $periksa->update([
            'bukti_bayar' => null,
            'status_bayar' => 'Belum Dibayar'
        ]);

        return back()->with('error', 'Bukti pembayaran ditolak. Pasien diminta mengunggah ulang.');
    }
}
