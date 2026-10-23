<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\BuktiBayarDiunggah;

class PembayaranController extends Controller
{
    public function index()
    {
        $tagihans = Periksa::whereHas('daftarPoli', function ($query) {
            $query->where('id_pasien', Auth::id());
        })->with(['daftarPoli.jadwalPeriksa.dokter.poli'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.tagihan.index', compact('tagihans'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_bayar.required' => 'Pilih file bukti pembayaran terlebih dahulu.',
            'bukti_bayar.image' => 'File harus berupa gambar.',
            'bukti_bayar.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $periksa = Periksa::whereHas('daftarPoli', function ($query) {
            $query->where('id_pasien', Auth::id());
        })->findOrFail($id);

        if ($periksa->bukti_bayar && Storage::disk('public')->exists($periksa->bukti_bayar)) {
            Storage::disk('public')->delete($periksa->bukti_bayar);
        }

        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        $periksa->update([
            'bukti_bayar' => $path,
            'status_bayar' => 'Menunggu Verifikasi'
        ]);

        $dokter = $periksa->daftarPoli->jadwalPeriksa->dokter;
        if ($dokter) {
            $dokter->notify(new BuktiBayarDiunggah($periksa));
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
