<x-layouts.app title="Pendaftaran Poli">

    <div class="flex justify-center items-center py-6">
        <div class="card w-full max-w-2xl bg-base-100 shadow-lg rounded-2xl border border-slate-200">
            <div class="card-body p-8">

                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg">
                        <i class="fas fa-notes-medical text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        Pendaftaran Poli
                    </h2>
                </div>

                {{-- Alert Pesan Sukses --}}
                @if (session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
                    </div>
                @endif

                <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                    @csrf

                    {{-- Hidden Input ID Pasien --}}
                    <input type="hidden" name="id_pasien" value="{{ $user->id }}">

                    {{-- Nomor Rekam Medis --}}
                    <div class="form-control mb-5">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">Nomor Rekam Medis</span>
                        </label>
                        {{-- Mengambil field no_rm dari user, jika tidak ada pakai id --}}
                        <input type="text" value="{{ $user->no_rm ?? $user->id }}"
                            class="input input-bordered bg-slate-100 border-2 px-4 w-full rounded-lg text-sm text-slate-500"
                            readonly>
                    </div>

                    {{-- Pilih Poli --}}
                    <div class="form-control mb-5">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">
                                Pilih Poli <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <select name="id_poli" id="id_poli"
                            class="select select-bordered border-2 px-4 w-full rounded-lg text-sm @error('id_poli') select-error @enderror"
                            required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" {{ old('id_poli') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_poli')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Pilih Jadwal Periksa --}}
                    <div class="form-control mb-5">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">
                                Pilih Jadwal Periksa <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <select name="id_jadwal" id="id_jadwal"
                            class="select select-bordered border-2 px-4 w-full rounded-lg text-sm @error('id_jadwal') select-error @enderror"
                            required disabled>
                            <option value="">-- Pilih Jadwal --</option>
                            {{-- Data jadwal dirender secara tersembunyi, lalu difilter menggunakan JS --}}
                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-id-poli="{{ $jadwal->dokter->id_poli }}"
                                    class="jadwal-option hidden"
                                    {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                                    Dr. {{ $jadwal->dokter->nama }} | {{ $jadwal->hari }}
                                    ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_jadwal')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Keluhan --}}
                    <div class="form-control mb-8">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">Keluhan</span>
                        </label>
                        <textarea name="keluhan"
                            class="textarea textarea-bordered border-2 p-4 w-full rounded-lg text-sm h-28 @error('keluhan') textarea-error @enderror"
                            placeholder="Tulis keluhan anda...">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-[#2d4499] hover:bg-[#1e2d6b] text-white rounded-lg text-sm font-semibold transition shadow-md">
                            Daftar Poli
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Script JavaScript untuk Filter Dropdown Jadwal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const poliSelect = document.getElementById('id_poli');
            const jadwalSelect = document.getElementById('id_jadwal');
            const jadwalOptions = document.querySelectorAll('.jadwal-option');

            // Fungsi untuk memfilter jadwal
            function filterJadwal() {
                const selectedPoliId = poliSelect.value;
                let isJadwalAvailable = false;

                jadwalOptions.forEach(option => {
                    if (option.getAttribute('data-id-poli') === selectedPoliId) {
                        option.classList.remove('hidden');
                        isJadwalAvailable = true;
                    } else {
                        option.classList.add('hidden');
                    }
                });

                if (selectedPoliId !== "") {
                    jadwalSelect.disabled = false;
                } else {
                    jadwalSelect.disabled = true;
                }
            }

            // Jalankan filter saat halaman dimuat (berguna jika ada old() value setelah error validasi)
            if (poliSelect.value !== "") {
                filterJadwal();
            }

            // Jalankan filter setiap kali Pilihan Poli diganti
            poliSelect.addEventListener('change', function() {
                jadwalSelect.value = ""; // Reset pilihan jadwal
                filterJadwal();
            });
        });
    </script>
</x-layouts.app>
