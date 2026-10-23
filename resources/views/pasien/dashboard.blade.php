<x-layouts.app title="Pasien Dashboard">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Halo Selamat Datang Pasien</h1>

    {{-- BANNER ANTRIAN AKTIF --}}
    @if (isset($antrianAktif) && $antrianAktif)
        <div
            class="bg-[#4C51F7] rounded-xl p-6 text-white flex flex-col md:flex-row justify-between items-center shadow-lg mb-8 relative overflow-hidden">
            <div class="z-10 w-full md:w-auto mb-6 md:mb-0">
                <p class="text-blue-200 text-sm font-bold tracking-wider mb-4 uppercase">Antrian Aktif Anda</p>

                <div class="flex flex-col gap-3">
                    <div>
                        <p class="text-blue-200 text-xs">Poliklinik</p>
                        <p class="font-bold text-base">{{ $antrianAktif->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs">Dokter</p>
                        <p class="font-bold text-base">{{ $antrianAktif->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs">Jadwal Periksa</p>
                        <p class="font-bold text-base">
                            {{ $antrianAktif->jadwalPeriksa->hari ?? '-' }}
                            ({{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($antrianAktif->jadwalPeriksa->jam_selesai)->format('H:i') }})
                        </p>
                    </div>
                </div>
            </div>

            <div class="z-10 flex gap-4 w-full md:w-auto justify-center md:justify-end">
                <div
                    class="bg-white/20 rounded-xl p-4 flex flex-col items-center justify-center min-w-[120px] backdrop-blur-sm">
                    <p class="text-white text-xs mb-1">Nomor Anda</p>
                    <p class="text-5xl font-bold">{{ $antrianAktif->no_antrian }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 flex flex-col items-center justify-center min-w-[120px] shadow-md">
                    <p class="text-slate-600 text-[10px] font-bold mb-1 uppercase text-center">Sedang Dilayani</p>

                    <p id="nomor-dilayani-{{ $antrianAktif->id_jadwal }}" class="text-5xl font-bold text-[#4C51F7]">
                        {{ $antrianSekarang ?? 0 }}
                    </p>

                    <div class="flex items-center gap-1 mt-2 text-[10px] font-medium text-emerald-500">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Live Update
                    </div>
                </div>
            </div>
            <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
                <svg class="w-64 h-64" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="150" cy="50" r="100" fill="currentColor" />
                    <circle cx="50" cy="150" r="80" fill="currentColor" />
                </svg>
            </div>
        </div>
    @else
        {{-- Jika tidak ada antrian aktif --}}
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center text-slate-500 mb-8">
            <i class="fas fa-ticket-alt text-4xl text-slate-300 mb-3 block"></i>
            <p>Anda belum memiliki pendaftaran antrian aktif saat ini.</p>
        </div>
    @endif

    {{-- TABEL JADWAL POLIKLINIK --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-0 overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Poli</th>
                        <th class="px-6 py-4 font-semibold">Dokter</th>
                        <th class="px-6 py-4 font-semibold">Hari</th>
                        <th class="px-6 py-4 font-semibold">Jam Periksa</th>
                        <th class="px-6 py-4 font-semibold text-center">No Dilayani</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($jadwals ?? [] as $index => $jadwal)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ optional($jadwal->dokter->poli)->nama_poli ?? '-' }}</td>
                            <td class="px-6 py-4">{{ optional($jadwal->dokter)->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $jadwal->hari }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 font-bold text-indigo-700"
                                    id="tabel-nomor-dilayani-{{ $jadwal->id }}">
                                    {{ $jadwal->antrian_sekarang ?? 0 }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                Belum ada jadwal poliklinik yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @vite(['resources/js/app.js'])
    <script type="module">
        @foreach ($jadwals as $jadwal)
            Echo.channel('antrian.{{ $jadwal->id }}')
                .listen('.AntrianDiupdate', (e) => {
                    let tabelNomor = document.getElementById('tabel-nomor-dilayani-{{ $jadwal->id }}');
                    if (tabelNomor) tabelNomor.innerText = e.nomorSekarang;
                    @if (isset($antrianAktif) && $antrianAktif)
                        if ('{{ $antrianAktif->id_jadwal }}' == e.idJadwal) {
                            let bannerNomor = document.getElementById('nomor-dilayani-{{ $antrianAktif->id_jadwal }}');
                            if (bannerNomor) bannerNomor.innerText = e.nomorSekarang;
                        }
                    @endif
                });
        @endforeach
    </script>

</x-layouts.app>
