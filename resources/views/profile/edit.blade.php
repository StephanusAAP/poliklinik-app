<x-layouts.app title="Ganti Password">
    @php
        $backUrl = route('pasien.dashboard'); // Default
        if (auth()->user()->role === 'admin') {
            $backUrl = route('admin.dashboard');
        } elseif (auth()->user()->role === 'dokter') {
            $backUrl = route('dokter.dashboard');
        }
    @endphp

    <div class="flex justify-center py-8">
        <div class="card w-full max-w-lg bg-base-100 shadow-md rounded-2xl border border-slate-200">
            <div class="card-body p-8">

                {{-- Header dengan Tombol Back --}}
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ $backUrl }}"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </a>

                    <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-lock text-indigo-500 mr-2"></i> Ganti Password
                    </h2>
                </div>

                {{-- Alert Sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    {{-- Password Lama --}}
                    <div class="form-control mb-4">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">Password Lama</span>
                        </label>
                        <input type="password" name="current_password"
                            class="input input-bordered border-2 px-4 w-full rounded-lg text-sm @error('current_password') input-error @enderror"
                            required>
                        @error('current_password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div class="form-control mb-4">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">Password Baru</span>
                        </label>
                        <input type="password" name="password"
                            class="input input-bordered border-2 px-4 w-full rounded-lg text-sm @error('password') input-error @enderror"
                            required>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div class="form-control mb-8">
                        <label class="label pb-1">
                            <span class="text-sm font-semibold text-gray-700">Konfirmasi Password Baru</span>
                        </label>
                        <input type="password" name="password_confirmation"
                            class="input input-bordered border-2 px-4 w-full rounded-lg text-sm" required>
                    </div>

                    {{-- Buttons: Simpan dan Batal --}}
                    <div class="flex flex-col gap-3">
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center gap-2 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition">
                            <i class="fas fa-save"></i> Simpan Password Baru
                        </button>

                        <a href="{{ $backUrl }}"
                            class="w-full text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-semibold transition">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layouts.app>
