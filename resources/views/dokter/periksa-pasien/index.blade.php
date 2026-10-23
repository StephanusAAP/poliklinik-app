<x-layouts.app title="Daftar Periksa Pasien">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Card Table --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">ID</th>
                        <th class="px-6 py-4 font-semibold">PASIEN</th>
                        <th class="px-6 py-4 font-semibold">KELUHAN</th>
                        <th class="px-6 py-4 font-semibold">NO ANTRIAN</th>
                        <th class="px-6 py-4 font-semibold text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($daftarPasien as $daftar)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">{{ $daftar->id }}</td>

                            {{-- Memanggil nama dari tabel pasien yang direlasikan --}}
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $daftar->pasien->nama ?? 'Nama tidak ditemukan' }}
                            </td>

                            <td class="px-6 py-4">{{ $daftar->keluhan }}</td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 font-bold text-slate-600">
                                    {{ $daftar->no_antrian }}
                                </span>
                            </td>

                            <td class="px-6 py-4 flex justify-center gap-2">
                                {{-- Jika data periksa sudah ada, tampilkan badge "Sudah Diperiksa" --}}
                                @if ($daftar->periksas && $daftar->periksas->count() > 0)
                                    <span
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                        <i class="fas fa-check-circle"></i> Sudah Diperiksa
                                    </span>
                                @else
                                    {{-- Jika belum diperiksa, tampilkan tombol "Periksa" --}}
                                    <a href="{{ route('periksa-pasien.create', $daftar->id) }}"
                                        class="inline-flex items-center gap-2 px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold rounded-full transition">
                                        <i class="fas fa-stethoscope"></i> Periksa
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Belum ada antrian pasien untuk jadwal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>
