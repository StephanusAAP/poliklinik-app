<x-layouts.app title="Periksa Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('periksa-pasien.index') }}"
            class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <h2 class="text-xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Card Form --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('periksa-pasien.store') }}" method="POST" id="form-periksa">
                @csrf

                {{-- ID Daftar Poli Hidden --}}
                <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                {{-- Data JSON Obat & Total Harga Hidden (Diisi oleh JavaScript) --}}
                <input type="hidden" name="obat_json" id="obat_json" value="[]">
                <input type="hidden" name="biaya_periksa" id="biaya_periksa" value="0">

                {{-- Pilih Obat --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Pilih Obat <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <select id="pilih_obat" class="select select-bordered border-2 px-4 w-full rounded-lg text-sm">
                        <option value="" disabled selected>-- Pilih Obat --</option>
                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                data-harga="{{ $obat->harga }}">
                                {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Obat Terpilih --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Obat Terpilih</span>
                    </label>
                    <div id="list_obat_terpilih"
                        class="flex flex-wrap gap-2 p-4 border-2 border-slate-200 rounded-lg bg-slate-50 min-h-[70px] items-center">
                        <span class="text-slate-400 text-sm italic" id="empty_obat_msg">Belum ada obat yang
                            dipilih...</span>
                    </div>
                    @error('obat_json')
                        <span class="text-red-500 text-xs mt-1">Obat wajib dipilih minimal satu.</span>
                    @enderror
                </div>

                {{-- Total Harga --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Total Harga (Obat)</span>
                    </label>
                    <div class="text-lg font-bold text-slate-800 bg-slate-100 px-4 py-3 rounded-lg border border-slate-200"
                        id="display_total_harga">
                        Rp 0
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="form-control mb-8">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">Catatan (Opsional)</span>
                    </label>
                    <textarea name="catatan" class="textarea textarea-bordered border-2 p-4 w-full rounded-lg text-sm h-28"
                        placeholder="Masukkan catatan..."></textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#2d4499] hover:bg-[#1e2d6b] text-white rounded-lg text-sm font-semibold transition">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>

                    <a href="{{ route('periksa-pasien.index') }}"
                        class="btn btn-ghost bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg px-6">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Script JavaScript untuk Logika Obat & Harga --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectObat = document.getElementById('pilih_obat');
            const listObatTerpilih = document.getElementById('list_obat_terpilih');
            const displayTotal = document.getElementById('display_total_harga');
            const inputObatJson = document.getElementById('obat_json');
            const inputBiayaPeriksa = document.getElementById('biaya_periksa');

            let selectedObatList = [];
            let totalHarga = 0;

            // Trigger saat dropdown obat dipilih
            selectObat.addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                if (!option.value) return;

                const id = option.value;
                const nama = option.getAttribute('data-nama');
                const harga = parseInt(option.getAttribute('data-harga'));

                // Cek apakah obat sudah ada di daftar
                if (selectedObatList.find(o => o.id === id)) {
                    alert('Obat ini sudah dipilih!');
                    this.value = "";
                    return;
                }

                // Masukkan obat ke dalam array state
                selectedObatList.push({
                    id,
                    nama,
                    harga
                });

                // Render ulang UI
                renderList();

                // Reset dropdown ke pilihan default
                this.value = "";
            });

            // Fungsi Hapus Obat (Dipanggil dari tombol X)
            window.hapusObat = function(id) {
                selectedObatList = selectedObatList.filter(o => o.id !== id.toString());
                renderList();
            };

            // Fungsi Utama untuk mengupdate UI dan Hidden Input
            function renderList() {
                // Kalkulasi total harga
                totalHarga = selectedObatList.reduce((sum, obat) => sum + obat.harga, 0);

                // Update text Total Harga
                displayTotal.innerHTML = `Rp ${totalHarga.toLocaleString('id-ID')}`;

                // Update value di hidden input agar terbaca oleh Controller
                inputBiayaPeriksa.value = totalHarga;
                // Controller Anda membutuhkan format array JSON dari ID obat
                inputObatJson.value = JSON.stringify(selectedObatList.map(o => o.id));

                // Bersihkan list view
                listObatTerpilih.innerHTML = '';

                // Jika kosong, tampilkan pesan default
                if (selectedObatList.length === 0) {
                    listObatTerpilih.innerHTML =
                        '<span class="text-slate-400 text-sm italic" id="empty_obat_msg">Belum ada obat yang dipilih...</span>';
                    return;
                }

                // Render badge obat
                selectedObatList.forEach(obat => {
                    const badge = document.createElement('div');
                    badge.className =
                        'inline-flex items-center gap-2 bg-blue-100 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-full text-sm font-medium';
                    badge.innerHTML = `
                        ${obat.nama}
                        <button type="button" onclick="hapusObat('${obat.id}')" class="text-blue-400 hover:text-blue-700 focus:outline-none transition">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    `;
                    listObatTerpilih.appendChild(badge);
                });
            }
        });
    </script>
</x-layouts.app>
