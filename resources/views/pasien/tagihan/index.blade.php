<x-layouts.app title="Pembayaran Tagihan">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Tagihan Pembayaran</h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Periksa</th>
                        <th class="px-6 py-4 font-semibold">Poli / Dokter</th>
                        <th class="px-6 py-4 font-semibold">Total Tagihan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($tagihans as $tagihan)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($tagihan->tgl_periksa)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="font-semibold text-slate-800">{{ optional($tagihan->daftarPoli->jadwalPeriksa->dokter->poli)->nama_poli }}</span><br>
                                <span
                                    class="text-xs text-slate-500">{{ optional($tagihan->daftarPoli->jadwalPeriksa->dokter)->nama }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-indigo-600">
                                Rp {{ number_format($tagihan->biaya_periksa, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($tagihan->status_bayar === 'Lunas')
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lunas</span>
                                @elseif($tagihan->status_bayar === 'Menunggu Verifikasi')
                                    <span
                                        class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Menunggu
                                        Verifikasi</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Belum
                                        Dibayar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($tagihan->status_bayar === 'Lunas')
                                    <a href="{{ asset('storage/' . $tagihan->bukti_bayar) }}" target="_blank"
                                        class="text-blue-500 hover:text-blue-700 text-xs underline">Lihat Kuitansi</a>
                                @else
                                    <form action="{{ route('pasien.pembayaran.upload', $tagihan->id) }}" method="POST"
                                        enctype="multipart/form-data" class="flex flex-col items-center gap-2">
                                        @csrf
                                        <input type="file" name="bukti_bayar" accept="image/*"
                                            class="file-input file-input-bordered file-input-sm w-full max-w-xs text-xs"
                                            required>
                                        <button type="submit"
                                            class="btn btn-sm bg-indigo-600 hover:bg-indigo-700 text-white w-full border-none">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                Belum ada tagihan pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
