@php
    $isBK      = request()->routeIs('bk.*');
    $homeRoute = $isBK ? route('bk.dashboard') : route('siswa.dashboard');
    $homeActive = $isBK ? request()->routeIs('bk.dashboard') : request()->routeIs('siswa.dashboard');
    $kelas = auth()->user()->kelas;
    $jurusan = auth()->user()->jurusan;
    $kelasText = $kelas ? ($jurusan ? $kelas . ' ' . $jurusan : $kelas) : 'XII IPA 1';
    $subtitle  = $isBK ? 'Halo Selamat Datang!' : $kelasText;

    $hasNotification = false;
    $notifications = [];
    $dbNotifications = auth()->check() ? auth()->user()->unreadNotifications()->take(5)->get() : collect();
    
    if ($dbNotifications->count() > 0) {
        $hasNotification = true;
    }
    
    if ($isBK) {
        $notifications = \App\Models\Konseling::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();
        $hasNotification = $notifications->count() > 0;
        $panggilanCount = \App\Models\Pelanggaran::where('status', 'menunggu')
            ->where('bk_id', auth()->id())
            ->count();
    } else {
        $konselingNotifs = \App\Models\Konseling::with('bk')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['selesai', 'disetujui'])
            ->latest()
            ->take(15)
            ->get();

        $pelanggaranNotifs = \App\Models\Pelanggaran::with('bk')
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->latest()
            ->take(15)
            ->get();

        $notifications = $konselingNotifs->concat($pelanggaranNotifs)->sortByDesc('updated_at')->take(20);
        $hasNotification = $notifications->where('is_read', false)->count() > 0;

        $unreadPanggilanCount = \App\Models\Pelanggaran::where('user_id', auth()->id())
            ->where('status', 'menunggu')
            ->where('is_read', false)
            ->count();
    }
@endphp

<header class="bg-white sticky top-0 z-50 border-b border-[#eaeaea] shadow-[0_2px_10px_rgba(0,0,0,0.03)] w-full">
    <div class="w-full px-5 md:px-6 py-4 flex items-center justify-between">

        <div class="flex items-center gap-3 max-w-[calc(100%-90px)] sm:max-w-none">
            <div class="w-11 h-11 rounded-full border-2 border-[#1a9488] overflow-hidden shrink-0">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/default-profile.png') }}" alt="Avatar" class="w-full h-full object-cover">
            </div>
            <div class="overflow-hidden">
                <div class="text-base font-bold text-[#1a1a1a] truncate">{{ auth()->user()->name ?? 'Test User' }}</div>
                <div class="text-xs text-[#777] mt-0.5 truncate">{{ $subtitle }}</div>
            </div>
        </div>

        <nav class="hidden md:flex items-center gap-6 lg:gap-8">
            <a href="{{ $homeRoute }}"
               class="{{ $homeActive ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Beranda
            </a>
            @if(!$isBK)
            <a href="{{ route('siswa.riwayat-konseling') }}"
               class="{{ request()->routeIs('siswa.riwayat-konseling*', 'siswa.detail-laporan') ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Riwayat Laporan
            </a>
            @else
            <a href="{{ route('bk.artikel.index') }}"
               class="{{ request()->routeIs('bk.artikel*') ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Kelola Artikel
            </a>
            <a href="{{ route('bk.laporan-konseling') }}"
               class="{{ request()->routeIs('bk.laporan-konseling') ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Riwayat Konseling
            </a>
            <a href="{{ route('bk.riwayat-panggilan') }}"
               class="{{ request()->routeIs('bk.riwayat-panggilan') ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors relative inline-flex items-center">
               Riwayat Panggilan
               @if(isset($panggilanCount) && $panggilanCount > 0)
               <span class="ml-1.5 flex h-4 w-4 relative">
                   <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                   <span class="relative inline-flex rounded-full h-4 w-4 bg-[#ef4444] text-white text-[0.6rem] font-bold items-center justify-center shadow-sm">
                       {{ $panggilanCount }}
                   </span>
               </span>
               @endif
            </a>
            @endif

            <div class="h-6 w-px bg-[#e5e7eb] mx-2"></div>

            <div class="relative group cursor-pointer" tabindex="0">
                <button class="p-2 text-[#555] group-hover:text-[#1a9488] relative focus:outline-none transition-colors border-none bg-transparent">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" class="stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        @if($hasNotification || (isset($unreadPanggilanCount) && $unreadPanggilanCount > 0))
                        <circle cx="19" cy="5" r="3.5" fill="#ef4444" stroke="#fff" stroke-width="1.5" class="{{ (isset($unreadPanggilanCount) && $unreadPanggilanCount > 0) ? 'animate-pulse' : '' }}"/>
                        @endif
                    </svg>
                    @if(isset($unreadPanggilanCount) && $unreadPanggilanCount > 0)
                        <span class="absolute top-1 right-1 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-600 text-white text-[0.6rem] font-black items-center justify-center">
                                {{ $unreadPanggilanCount }}
                            </span>
                        </span>
                    @endif
                </button>

                <div class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 focus-within:opacity-100 focus-within:visible focus-within:scale-100 z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-[#eaeaea] flex items-center justify-between bg-[#fafafa]">
                        <span class="text-sm font-bold text-[#333]">Notifikasi</span>
                        @if(!$isBK && ($notifications->count() > 0 || $dbNotifications->count() > 0))
                        <form action="{{ route('siswa.notifications.mark-as-read') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="text-[0.7rem] font-bold text-[#1a9488] hover:text-[#11675f] bg-transparent border-none p-0 cursor-pointer">
                                Tandai Dibaca
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    <style>
                        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
                        .custom-scrollbar::-webkit-scrollbar-track { background: #f9fafb; }
                        .custom-scrollbar::-webkit-scrollbar-thumb { background: #1a9488; border-radius: 10px; }
                        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #11675f; }
                    </style>
                    <div class="custom-scrollbar border-b border-[#f0f0f0]" style="max-height: 240px; overflow-y: auto;">
                        @if($dbNotifications->count() > 0)
                            @foreach($dbNotifications as $dbNotif)
                                <a href="{{ $dbNotif->data['link'] ?? '#' }}" class="block p-3 border-b border-[#f5f5f5] bg-[#f0fdf9] hover:bg-[#e6f9f5] transition-colors no-underline">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                        <div class="text-[0.85rem] font-semibold text-[#1a1a1a]">{{ $dbNotif->data['title'] ?? 'Pemberitahuan Baru' }}</div>
                                    </div>
                                    <div class="text-xs text-[#555] mb-1">{{ $dbNotif->data['message'] ?? '' }}</div>
                                    <div class="text-[0.7rem] text-[#888]">{{ $dbNotif->created_at->diffForHumans() }}</div>
                                </a>
                            @endforeach
                        @endif

                        @if($notifications->count() > 0)
                            @foreach($notifications as $notif)
                                @if($isBK)

                                    <a href="{{ route('bk.daftar-pengajuan') }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline">
                                        <div class="text-[0.85rem] font-semibold text-[#1a1a1a] mb-0.5">Pengajuan {{ $notif->jenis_layanan }} baru</div>
                                        <div class="text-xs text-[#555] mb-1">Dari: {{ $notif->user->name ?? 'Siswa' }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                                    </a>
                                @else

                                    @if($notif->status === 'selesai')
                                    @php $isUnreadSelesai = !$notif->is_read; @endphp
                                    <a href="{{ route('siswa.detail-laporan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline {{ $isUnreadSelesai ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnreadSelesai)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnreadSelesai ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Laporan Konseling Tersedia</div>
                                        </div>
                                        <div class="text-xs mb-1 {{ $isUnreadSelesai ? 'text-[#555]' : 'text-[#999]' }}">Sesi {{ ucfirst($notif->jenis) }} tanggal {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M Y') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @elseif($notif->status === 'disetujui')
                                    @php $isUnreadJadwal = !$notif->is_read; @endphp
                                    <a href="{{ $notif->jenis == 'online' ? route('siswa.mulai-konseling') : route('siswa.konseling-offline') }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#e6f9f5] transition-colors no-underline {{ $isUnreadJadwal ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnreadJadwal)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnreadJadwal ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Jadwal Konseling Disetujui</div>
                                        </div>
                                        <div class="text-xs text-[#555] mb-1">Sesi {{ ucfirst($notif->jenis) }}: {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M') }} pkl {{ $notif->waktu ? \Carbon\Carbon::parse($notif->waktu)->format('H:i') : '--:--' }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @else
                                    @php 
                                        $isUnreadPanggilan = !$notif->is_read && ($notif->status === 'menunggu' || $notif->status === 'dipanggil'); 
                                    @endphp
                                    <a href="{{ route('siswa.detail-panggilan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline {{ $isUnreadPanggilan ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnreadPanggilan)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnreadPanggilan ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Panggil Siswa</div>
                                        </div>
                                        <div class="text-xs text-[#555] mb-1 {{ $isUnreadPanggilan ? '' : 'text-[#999]' }}">Jadwal: {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M') }} pkl {{ \Carbon\Carbon::parse($notif->waktu)->format('H:i') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @endif
                                @endif
                            @endforeach
                        @elseif($dbNotifications->count() == 0)
                            <div class="p-6 text-center text-[#888] text-sm flex flex-col items-center gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                                Belum ada notifikasi
                            </div>
                        @endif
                    </div>
                    @if(!$isBK && ($notifications->count() > 0 || $dbNotifications->count() > 0))
                    <div class="p-2 border-t border-[#eaeaea] bg-[#fdfdfd]">
                        <a href="{{ route('siswa.notifications.index') }}" class="block w-full text-center text-xs font-bold text-[#1a9488] hover:text-[#11675f] py-2 transition-colors no-underline">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="relative cursor-pointer" id="siswaProfileMenuContainer">
                <div onclick="toggleSiswaProfileDropdown(event)" class="flex items-center gap-2 hover:bg-[#f8f9fa] py-2 px-3 rounded-xl transition-colors">
                    <div class="w-8 h-8 rounded-full border border-[#1a9488] overflow-hidden shrink-0 shadow-sm">
                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('img/default-profile.png') }}" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <svg id="siswaProfileDropdownIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-all duration-300"><path d="m6 9 6 6 6-6"/></svg>
                </div>

                <div id="siswaProfileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible transition-all duration-200 origin-top-right transform scale-95 z-50">
                    <div class="p-1.5 flex flex-col">
                        <div class="px-3 py-2 text-xs font-semibold text-[#888] uppercase tracking-wider mb-1">Akun Saya</div>
                        @php
                            $profileRoute = $isBK ? route('bk.profile.edit') : route('siswa.profile.edit');
                        @endphp
                        <a href="{{ $profileRoute }}" class="flex items-center gap-3 px-3 py-2 text-sm text-[#333] font-medium hover:bg-[#f0f9f8] hover:text-[#1a9488] rounded-lg transition-colors">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Edit Profil
                        </a>
                        <div class="h-px bg-[#eaeaea] my-1"></div>
                        <button onclick="document.getElementById('logout-form').submit()" class="flex items-center gap-3 px-3 py-2 text-sm text-[#e53e3e] font-medium hover:bg-[#fff5f5] rounded-lg transition-colors w-full cursor-pointer border-none bg-transparent">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Keluar
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex md:hidden items-center gap-1">
            <div class="relative group" tabindex="0">
                <button aria-label="Buka notifikasi" class="min-w-11 min-h-11 inline-flex items-center justify-center text-[#333] relative cursor-pointer border-none bg-transparent focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1a9488] rounded-full">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        @if($hasNotification)
                        <circle cx="19" cy="5" r="3" fill="#ef4444" stroke="#fff" stroke-width="1.5"/>
                        @endif
                    </svg>
                </button>

                <div class="absolute right-0 mt-2 w-[min(18rem,calc(100vw-2rem))] bg-white rounded-xl shadow-[0_8px_16px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 group-focus-within:scale-100 z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-[#eaeaea] flex items-center justify-between bg-[#fafafa]">
                        <span class="text-sm font-bold text-[#333]">Notifikasi</span>
                    </div>
                    
                    <div class="max-h-[300px] overflow-y-auto">
                        @if($dbNotifications->count() > 0)
                            @foreach($dbNotifications as $dbNotif)
                                <a href="{{ $dbNotif->data['link'] ?? '#' }}" class="block p-3 border-b border-[#f5f5f5] bg-[#f0fdf9] hover:bg-[#e6f9f5] transition-colors no-underline">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                        <div class="text-[0.85rem] font-semibold text-[#1a1a1a]">{{ $dbNotif->data['title'] ?? 'Pemberitahuan Baru' }}</div>
                                    </div>
                                    <div class="text-xs text-[#555] mb-1">{{ $dbNotif->data['message'] ?? '' }}</div>
                                    <div class="text-[0.7rem] text-[#888]">{{ $dbNotif->created_at->diffForHumans() }}</div>
                                </a>
                            @endforeach
                        @endif

                        @if($notifications->count() > 0)
                            @foreach($notifications as $notif)
                                @if($isBK)
                                    <!-- BK Notification Item -->
                                    <a href="{{ route('bk.daftar-pengajuan') }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline">
                                        <div class="text-[0.85rem] font-semibold text-[#1a1a1a] mb-0.5">Pengajuan {{ $notif->jenis_layanan }} baru</div>
                                        <div class="text-xs text-[#555] mb-1">Dari: {{ $notif->user->name ?? 'Siswa' }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                                    </a>
                                @else
                                    <!-- Siswa Notification Item -->
                                    @if($notif->status === 'selesai')
                                    @php $isUnreadSelesai = !$notif->is_read; @endphp
                                    <a href="{{ route('siswa.detail-laporan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline {{ $isUnreadSelesai ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnreadSelesai)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnreadSelesai ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Laporan Konseling Tersedia</div>
                                        </div>
                                        <div class="text-xs mb-1 {{ $isUnreadSelesai ? 'text-[#555]' : 'text-[#999]' }}">Sesi {{ ucfirst($notif->jenis) }} tanggal {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M Y') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @elseif($notif->status === 'disetujui')
                                    <a href="{{ $notif->jenis == 'online' ? route('siswa.mulai-konseling') : route('siswa.konseling-offline') }}" class="block p-3 border-b border-[#f5f5f5] bg-[#f0fdf9] hover:bg-[#e6f9f5] transition-colors no-underline">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            <div class="text-[0.85rem] font-semibold text-[#1a1a1a]">Jadwal Konseling Disetujui</div>
                                        </div>
                                        <div class="text-xs text-[#555] mb-1">Sesi {{ ucfirst($notif->jenis) }}: {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M') }} pkl {{ $notif->waktu ? \Carbon\Carbon::parse($notif->waktu)->format('H:i') : '--:--' }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @else
                                    @php 
                                        $isUnread = !$notif->is_read && ($notif->status === 'menunggu' || $notif->status === 'dipanggil'); 
                                    @endphp
                                    <a href="{{ route('siswa.detail-panggilan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline {{ $isUnread ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnread ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Panggil Siswa</div>
                                        </div>
                                        <div class="text-xs text-[#555] mb-1 {{ $isUnread ? '' : 'text-[#999]' }}">Jadwal: {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M') }} pkl {{ \Carbon\Carbon::parse($notif->waktu)->format('H:i') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @endif
                                @endif
                            @endforeach
                        @elseif($dbNotifications->count() == 0)
                            <div class="p-6 text-center text-[#888] text-sm flex flex-col items-center gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                                Belum ada notifikasi
                            </div>
                        @endif
                    </div>
                    
                    @if($notifications->count() > 0)
                    <div class="p-2 border-t border-[#eaeaea]">
                        <a href="{{ $isBK ? route('bk.daftar-pengajuan') : route('siswa.panggilan') }}" class="block w-full text-center text-xs font-semibold text-[#1a9488] hover:text-[#11675f] py-1.5 transition-colors no-underline">
                            Lihat Semua
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <button id="mobileMenuToggle" onclick="toggleMobileNavbar()" class="p-2 ml-1 text-[#333] focus:outline-none cursor-pointer border-none bg-transparent hover:text-[#1a9488] transition-colors rounded-lg">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobileNavbarMenu" class="md:hidden hidden flex-col absolute top-full left-0 w-full bg-white border-b border-[#eaeaea] shadow-lg overflow-y-auto max-h-[calc(100vh-80px)] z-40">
        <a href="{{ $homeRoute }}" class="px-5 py-4 border-b border-[#f5f5f5] flex items-center gap-3 {{ $homeActive ? 'text-[#1a9488] bg-[#f0f9f8]' : 'text-[#555]' }} font-semibold text-[0.95rem] transition-colors no-underline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $homeActive ? '#1a9488' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/></svg>
            Beranda
        </a>
        
        @if(!$isBK)
        <a href="{{ route('siswa.riwayat-konseling') }}" class="px-5 py-4 border-b border-[#f5f5f5] flex items-center gap-3 {{ request()->routeIs('siswa.riwayat-konseling*', 'siswa.detail-laporan') ? 'text-[#1a9488] bg-[#f0f9f8]' : 'text-[#555]' }} font-semibold text-[0.95rem] transition-colors no-underline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Riwayat Laporan
        </a>
        @else
        <a href="{{ route('bk.artikel.index') }}" class="px-5 py-4 border-b border-[#f5f5f5] flex items-center gap-3 {{ request()->routeIs('bk.artikel*') ? 'text-[#1a9488] bg-[#f0f9f8]' : 'text-[#555]' }} font-semibold text-[0.95rem] transition-colors no-underline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
            Kelola Artikel
        </a>
        <a href="{{ route('bk.laporan-konseling') }}" class="px-5 py-4 border-b border-[#f5f5f5] flex items-center gap-3 {{ request()->routeIs('bk.laporan-konseling') ? 'text-[#1a9488] bg-[#f0f9f8]' : 'text-[#555]' }} font-semibold text-[0.95rem] transition-colors no-underline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Riwayat Konseling
        </a>
        <a href="{{ route('bk.riwayat-panggilan') }}" class="px-5 py-4 border-b border-[#f5f5f5] flex items-center gap-3 {{ request()->routeIs('bk.riwayat-panggilan') ? 'text-[#1a9488] bg-[#f0f9f8]' : 'text-[#555]' }} font-semibold text-[0.95rem] transition-colors no-underline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            Riwayat Panggilan
            @if(isset($panggilanCount) && $panggilanCount > 0)
            <span class="ml-auto flex h-5 w-5 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-5 w-5 bg-[#ef4444] text-white text-[0.7rem] font-bold items-center justify-center shadow-sm">
                    {{ $panggilanCount }}
                </span>
            </span>
            @endif
        </a>
        @endif
        
        <div class="px-5 py-3 bg-[#f9fafb] text-xs font-semibold text-[#888] uppercase tracking-wider">
            Akun Saya
        </div>
        
        <a href="{{ $isBK ? route('bk.profile.edit') : route('siswa.profile.edit') }}" class="px-5 py-4 border-b border-[#f5f5f5] flex items-center gap-3 text-[#333] hover:text-[#1a9488] font-medium text-[0.95rem] transition-colors no-underline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Edit Profil
        </a>
        <button onclick="document.getElementById('logout-form').submit()" class="w-full text-left px-5 py-4 flex items-center gap-3 text-[#e53e3e] hover:bg-[#fff5f5] font-medium text-[0.95rem] border-none bg-transparent cursor-pointer transition-colors">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Keluar
        </button>
    </div>
</header>
@if(auth()->check())
<script>
    function toggleSiswaProfileDropdown(event) {
        if (event) event.stopPropagation();
        const dropdown = document.getElementById('siswaProfileDropdown');
        const icon = document.getElementById('siswaProfileDropdownIcon');
        
        if (dropdown) {
            dropdown.classList.toggle('opacity-0');
            dropdown.classList.toggle('invisible');
            dropdown.classList.toggle('scale-95');
            dropdown.classList.toggle('opacity-100');
            dropdown.classList.toggle('visible');
            dropdown.classList.toggle('scale-100');
        }
        
        if (icon) {
            icon.classList.toggle('rotate-180');
        }
    }

    function toggleMobileNavbar() {
        const menu = document.getElementById('mobileNavbarMenu');
        if (menu) {
            menu.classList.toggle('hidden');
            menu.classList.toggle('flex');
        }
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('siswaProfileDropdown');
        const container = document.getElementById('siswaProfileMenuContainer');
        const icon = document.getElementById('siswaProfileDropdownIcon');
        
        if (dropdown && container && !container.contains(event.target)) {
            dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
            
            if (icon) {
                icon.classList.remove('rotate-180');
            }
        }
    });

    window.addEventListener('load', () => {
        if (window.Echo) {
            const canAutoReload = [
                /^\/siswa\/dashboard\/?$/,
                /^\/siswa\/notifications(\/)?(\?.*)?$/,
                /^\/siswa\/riwayat-konseling\/?$/,
                /^\/siswa\/panggilan\/?$/,
                /^\/siswa\/mulai-konseling\/?$/,
                /^\/siswa\/konseling-offline\/?$/,
                /^\/siswa\/chat-konseling\/?$/,
                /^\/siswa\/pengajuan-proses\/?$/,
                /^\/siswa\/pengajuan-ditolak\/?$/
            ];
            const shouldAutoReload = canAutoReload.some((pattern) => pattern.test(window.location.pathname));

            window.Echo.private('App.Models.User.' + {{ auth()->id() }})
                .notification((notification) => {
                    if (window.showToast) {
                        window.showToast(notification.title || 'Notifikasi Baru', 'success', true);
                    }

                    const reloadableTypes = ['konseling_status', 'pelanggaran_baru', 'pelanggaran_status'];
                    if (shouldAutoReload && reloadableTypes.includes(notification?.data?.event_type) && !window.__konselingNotifReloadScheduled) {
                        window.__konselingNotifReloadScheduled = true;
                        setTimeout(() => window.location.reload(), 600);
                    }
                });
        }
    });
</script>
@endif
