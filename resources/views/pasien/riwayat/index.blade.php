<x-layouts.app title="Riwayat Pendaftaran Poli">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Riwayat Pendaftaran
        </h2>
    </div>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Poli</th>
                        <th class="px-6 py-4 font-semibold">Dokter</th>
                        <th class="px-6 py-4 font-semibold">Jadwal Periksa</th>
                        <th class="px-6 py-4 font-semibold">No Antrian</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($riwayatPendaftaran as $riwayat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ optional($riwayat->jadwalPeriksa->dokter->poli)->nama_poli }}
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                                {{ optional($riwayat->jadwalPeriksa->dokter)->nama }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $riwayat->jadwalPeriksa->hari ?? '-' }} <br>
                                <span class="text-xs text-slate-400">
                                    {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($riwayat->jadwalPeriksa->jam_selesai)->format('H:i') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 font-bold text-slate-600">
                                    {{ $riwayat->no_antrian }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($riwayat->periksas && $riwayat->periksas->count() > 0)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Sudah Diperiksa</span>
                                @else
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Menunggu Antrian</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($riwayat->periksas && $riwayat->periksas->count() > 0)
                                    <a href="{{ route('pasien.riwayat.show', $riwayat->id) }}"
                                        class="btn btn-sm bg-blue-500 hover:bg-blue-600 text-white border-none rounded-lg px-4">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                @else
                                    <span class="text-slate-400 italic text-xs">Belum tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-inbox text-3xl"></i>
                                    <span>Anda belum memiliki riwayat pendaftaran.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
