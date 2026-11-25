<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with([
            'pasien',
            'jadwalPeriksa',
            'periksas'
        ])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view(
            'dokter.periksa-pasien.index',
            compact('daftarPasien')
        );
    }

    public function create($id)
    {
        $daftarPoli = DaftarPoli::whereHas(
            'jadwalPeriksa',
            function ($query) {
                $query->where('id_dokter', Auth::id());
            }
        )->findOrFail($id);

        if ($daftarPoli->periksas()->exists()) {
            return redirect()
                ->route('periksa-pasien.index')
                ->with('error', 'Pasien sudah diperiksa.');
        }

        $obats = Obat::all();

        return view(
            'dokter.periksa-pasien.create',
            compact('obats', 'id')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|integer|exists:daftar_poli,id',
            'obat_json' => 'required|json',
            'catatan' => 'nullable|string',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        // Validasi obat yang dipilih
        Validator::make([
            'obat_json' => $obatIds,
        ], [
            'obat_json' => 'required|array|min:1',
            'obat_json.*' => 'required|integer|distinct|exists:obat,id',
        ], [
            'obat_json.required' => 'Pilih minimal satu obat.',
            'obat_json.min' => 'Pilih minimal satu obat.',
            'obat_json.*.distinct' => 'Obat tidak boleh dipilih lebih dari sekali.',
            'obat_json.*.exists' => 'Obat yang dipilih tidak tersedia.',
        ])->validate();

        DB::transaction(function () use ($request, $obatIds) {

            // Pastikan pasien merupakan pasien dokter yang login
            $daftarPoli = DaftarPoli::whereHas(
                'jadwalPeriksa',
                function ($query) {
                    $query->where('id_dokter', Auth::id());
                }
            )
                ->lockForUpdate()
                ->findOrFail($request->id_daftar_poli);

            // Mencegah pemeriksaan ganda
            if ($daftarPoli->periksas()->exists()) {
                throw ValidationException::withMessages([
                    'id_daftar_poli' => 'Pasien sudah diperiksa.',
                ]);
            }

            // Ambil obat dan kunci data stok
            $obats = Obat::whereIn('id', $obatIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($obats->count() !== count($obatIds)) {
                throw ValidationException::withMessages([
                    'obat_json' => 'Terdapat obat yang tidak tersedia.',
                ]);
            }

            // Periksa ketersediaan seluruh obat
            foreach ($obats as $obat) {
                if ($obat->stok < 1) {
                    throw ValidationException::withMessages([
                        'obat_json' =>
                            'Stok obat ' . $obat->nama_obat . ' sudah habis.',
                    ]);
                }
            }

            // Hitung harga langsung dari database
            $totalHargaObat = $obats->sum('harga');
            $biayaJasaDokter = 150000;

            // Simpan pemeriksaan
            $periksa = Periksa::create([
                'id_daftar_poli' => $daftarPoli->id,
                'tgl_periksa' => now(),
                'catatan' => $request->catatan,
                'biaya_periksa' => $totalHargaObat + $biayaJasaDokter,
            ]);

            // Simpan resep dan kurangi stok
            foreach ($obats as $obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat->id,
                ]);

                $obat->decrement('stok', 1);
            }

        }, 3);

        return redirect()
            ->route('periksa-pasien.index')
            ->with('success', 'Data periksa berhasil disimpan.');
    }
}
