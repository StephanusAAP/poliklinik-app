<x-layouts.app title="Verifikasi Pembayaran">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Upload</th>
                        <th class="px-6 py-4 font-semibold">Nama Pasien</th>
                        <th class="px-6 py-4 font-semibold">Total Tagihan</th>
                        <th class="px-6 py-4 font-semibold text-center">Bukti Transfer</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($pembayarans as $bayar)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($bayar->updated_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="font-semibold text-slate-800">{{ optional($bayar->daftarPoli->pasien)->nama }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-indigo-600">
                                Rp {{ number_format($bayar->biaya_periksa, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ asset('storage/' . $bayar->bukti_bayar) }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-blue-500 hover:text-blue-700 hover:underline">
                                    <i class="fas fa-image"></i> Lihat Foto
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                @if ($bayar->status_bayar === 'Lunas')
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Lunas</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($bayar->status_bayar === 'Menunggu Verifikasi')
                                    <div class="flex gap-2 justify-center">
                                        <form action="{{ route('admin.pembayaran.verify', $bayar->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin memverifikasi pembayaran ini menjadi Lunas?');">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white border-none rounded-lg px-3">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pembayaran.reject', $bayar->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menolak dan menghapus bukti pembayaran ini?');">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm bg-red-500 hover:bg-red-600 text-white border-none rounded-lg px-3">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic text-xs"><i
                                            class="fas fa-check-double text-green-500 mr-1"></i>Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                Belum ada data pembayaran yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
