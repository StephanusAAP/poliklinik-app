<header class="bg-base-100 border-b border-base-300 h-16 flex items-center px-6 gap-4 sticky top-0 z-30 shadow-sm">

    {{-- Mobile Hamburger --}}
    <button onclick="toggleSidebar()" class="btn btn-square btn-ghost lg:hidden">
        <i data-lucide="menu" class="w-5 h-5"></i>
    </button>

    {{-- Breadcrumb --}}
    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm">
            <span class="text-base-content/50">Poliklinik</span>
            <i data-lucide="chevron-right" class="w-4 h-4 text-base-content/30"></i>
            <span class="font-semibold text-base-content">
                {{ $title ?? 'Dashboard' }}
            </span>
        </div>
    </div>

    {{-- Fullscreen --}}
    <button onclick="toggleFullscreen()" class="btn btn-square btn-ghost">
        <i id="fsIcon" class="fas fa-expand w-5 h-5"></i>
    </button>

    {{-- Bell Icon Notifikasi --}}
    <div class="dropdown dropdown-end mr-4">
        <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <i class="fas fa-bell text-xl text-slate-600"></i>
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span
                        class="badge badge-sm badge-error indicator-item">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </div>
        </label>
        <ul tabindex="0"
            class="mt-3 p-2 shadow-lg border border-slate-100 menu menu-compact dropdown-content bg-base-100 rounded-box w-80 max-h-[400px] overflow-y-auto z-50">
            <li class="menu-title px-4 py-2 border-b border-slate-100">
                <span class="font-bold text-slate-700">Notifikasi</span>
            </li>

            @forelse(auth()->user()->notifications as $notification)
                <li
                    class="border-b border-slate-50 last:border-0 {{ $notification->read_at ? 'opacity-60 bg-white' : 'bg-indigo-50/50' }}">
                    <a href="{{ route('notifications.read', $notification->id) }}"
                        class="flex flex-col items-start gap-1 py-3 px-4 hover:bg-slate-100 transition">
                        <div class="flex items-center justify-between w-full">
                            <span class="font-bold text-sm text-slate-800">{{ $notification->data['title'] }}</span>
                            @if (!$notification->read_at)
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            @endif
                        </div>
                        <span
                            class="text-xs text-slate-600 whitespace-normal leading-relaxed">{{ $notification->data['message'] }}</span>
                        <span class="text-[10px] text-slate-400 mt-1"><i
                                class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                </li>
            @empty
                <li><span class="text-sm text-slate-400 text-center py-6 block">Belum ada notifikasi.</span></li>
            @endforelse
        </ul>
    </div>

    {{-- User Info --}}
    <div class="flex items-center gap-3">

        <div class="text-right hidden sm:block">
            <div class="text-sm font-semibold leading-tight">
                {{ auth()->user()->name ?? 'Pengguna' }}
            </div>
            <div class="text-xs text-base-content/50 leading-tight">
                {{ auth()->user()->role ?? 'Admin Sistem' }}
            </div>
        </div>

        <div class="avatar">
            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                <span class="text-sm font-semibold leading-none">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </span>
            </div>
        </div>
    </div>

</header>

<script>
    function toggleFullscreen() {
        const icon = document.getElementById('fsIcon');

        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            icon.classList.remove('fa-expand');
            icon.classList.add('fa-compress');
        } else {
            document.exitFullscreen();
            icon.classList.remove('fa-compress');
            icon.classList.add('fa-expand');
        }
    }
</script>
