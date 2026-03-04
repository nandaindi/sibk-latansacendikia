{{-- Shared Navbar – digunakan oleh layouts/siswa.blade.php dan layouts/bk.blade.php --}}
@php
    $isBK      = request()->routeIs('bk.*');
    $homeRoute = $isBK ? route('bk.dashboard') : route('siswa.dashboard');
    $homeActive = $isBK ? request()->routeIs('bk.dashboard') : request()->routeIs('siswa.dashboard');
    $kelas = auth()->user()->kelas;
    $jurusan = auth()->user()->jurusan;
    $kelasText = $kelas ? ($jurusan ? $kelas . ' ' . $jurusan : $kelas) : 'XII Inovatif';
    $subtitle  = $isBK ? 'Halo Selamat Datang!' : $kelasText;

    // Cek ada notifikasi gantung dan ambil data untuk dropdown
    $hasNotification = false;
    $notifications = [];
    
    if ($isBK) {
        $notifications = \App\Models\Konseling::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();
        $hasNotification = $notifications->count() > 0;
    } else {
        $notifications = \App\Models\Konseling::with('bk')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['dipanggil', 'selesai'])
            ->latest()
            ->take(3)
            ->get();
        // Dot merah hanya jika ada yang belum dibaca
        $hasNotification = $notifications->where('is_read', false)->count() > 0;
    }
@endphp

<!-- Header -->
<header class="bg-white sticky top-0 z-50 border-b border-[#eaeaea] shadow-[0_2px_10px_rgba(0,0,0,0.03)] w-full">
    <div class="w-full px-5 md:px-6 py-4 flex items-center justify-between">

        <!-- User Info -->
        <div class="flex items-center gap-3">
            @if(auth()->user()->avatar)
                <div class="w-11 h-11 rounded-full border-2 border-[#1a9488] overflow-hidden shrink-0">
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-11 h-11 rounded-full bg-[#e0f5f3] border-2 border-[#1a9488] flex items-center justify-center shrink-0">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
            @endif
            <div>
                <div class="text-base font-bold text-[#1a1a1a]">{{ auth()->user()->name ?? 'Test User' }}</div>
                <div class="text-xs text-[#777] mt-0.5">{{ $subtitle }}</div>
            </div>
        </div>

        <!-- Web Navigation (Desktop) -->
        <nav class="hidden md:flex items-center gap-6 lg:gap-8">
            <a href="{{ $homeRoute }}"
               class="{{ $homeActive ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Beranda
            </a>
            @if(!$isBK)
            <a href="{{ route('siswa.panggilan') }}"
               class="{{ request()->routeIs('siswa.panggilan*', 'siswa.detail-panggilan') ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Riwayat Panggilan
            </a>
            @else
            <a href="{{ route('bk.artikel.index') }}"
               class="{{ request()->routeIs('bk.artikel*') ? 'text-[#1a9488]' : 'text-[#555]' }} font-semibold text-[0.95rem] hover:text-[#1a9488] transition-colors">
               Kelola Artikel
            </a>
            @endif

            <!-- Divider -->
            <div class="h-6 w-px bg-[#e5e7eb] mx-2"></div>

            <!-- Notification Dropdown Container -->
            <div class="relative group cursor-pointer" tabindex="0">
                <button class="p-2 text-[#555] group-hover:text-[#1a9488] relative focus:outline-none transition-colors border-none bg-transparent">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" class="stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        @if($hasNotification)
                        <circle cx="19" cy="5" r="3.5" fill="#ef4444" stroke="#fff" stroke-width="1.5"/>
                        @endif
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 focus-within:opacity-100 focus-within:visible focus-within:scale-100 z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-[#eaeaea] flex items-center justify-between bg-[#fafafa]">
                        <span class="text-sm font-bold text-[#333]">Notifikasi</span>
                    </div>
                    
                    <div class="max-h-[300px] overflow-y-auto">
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
                                    <a href="{{ route('siswa.detail-laporan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline">
                                        <div class="text-[0.85rem] font-semibold text-[#1a1a1a] mb-0.5">Laporan Konseling Tersedia</div>
                                        <div class="text-xs text-[#555] mb-1">Sesi {{ ucfirst($notif->jenis) }} tanggal {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M Y') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @else
                                    @php $isUnread = !$notif->is_read && $notif->status === 'dipanggil'; @endphp
                                    <a href="{{ route('siswa.detail-panggilan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline {{ $isUnread ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnread ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Panggilan Konseling</div>
                                        </div>
                                        <div class="text-xs text-[#555] mb-1 {{ $isUnread ? '' : 'text-[#999]' }}">Jadwal: {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M') }} pkl {{ \Carbon\Carbon::parse($notif->waktu)->format('H:i') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @endif
                                @endif
                            @endforeach
                        @else
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

            <!-- Profile Dropdown Container -->
            <div class="relative group cursor-pointer" tabindex="0">
                <div class="flex items-center gap-2 hover:bg-[#f8f9fa] py-2 px-3 rounded-xl transition-colors">
                    @if(auth()->user()->avatar)
                        <div class="w-8 h-8 rounded-full border border-[#1a9488] overflow-hidden shrink-0 shadow-sm">
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full bg-[#1a9488] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                    @endif
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#1a9488] transition-colors"><path d="m6 9 6 6 6-6"/></svg>
                </div>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 focus-within:opacity-100 focus-within:visible focus-within:scale-100 z-50">
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

        <!-- Mobile Icons -->
        <div class="flex md:hidden items-center gap-2">
            <!-- Home -->
            <a href="{{ $homeRoute }}" class="p-2 {{ $homeActive ? 'text-[#1a9488]' : 'text-[#333]' }}">
                <svg width="22" height="22" viewBox="0 0 24 24"
                     fill="{{ $homeActive ? '#1a9488' : 'none' }}"
                     stroke="{{ $homeActive ? '#1a9488' : 'currentColor' }}"
                     stroke-width="{{ $homeActive ? '0.5' : '2' }}"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
                </svg>
            </a>
            <!-- Bell Notification Dropdown (Mobile) -->
            <div class="relative group" tabindex="0">
                <button class="p-2 text-[#333] relative focus:outline-none cursor-pointer border-none bg-transparent">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        @if($hasNotification)
                        <circle cx="19" cy="5" r="3" fill="#ef4444" stroke="#fff" stroke-width="1.5"/>
                        @endif
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div class="absolute right-[-40px] mt-2 w-72 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 group-focus-within:scale-100 z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-[#eaeaea] flex items-center justify-between bg-[#fafafa]">
                        <span class="text-sm font-bold text-[#333]">Notifikasi</span>
                    </div>
                    
                    <div class="max-h-[300px] overflow-y-auto">
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
                                    <a href="{{ route('siswa.detail-laporan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline">
                                        <div class="text-[0.85rem] font-semibold text-[#1a1a1a] mb-0.5">Laporan Konseling Tersedia</div>
                                        <div class="text-xs text-[#555] mb-1">Sesi {{ ucfirst($notif->jenis) }} tanggal {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M Y') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @else
                                    @php $isUnread = !$notif->is_read && $notif->status === 'dipanggil'; @endphp
                                    <a href="{{ route('siswa.detail-panggilan', $notif->id) }}" class="block p-3 border-b border-[#f5f5f5] hover:bg-[#f0f9f8] transition-colors no-underline {{ $isUnread ? 'bg-[#f0fdf9]' : 'opacity-60' }}">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            @if($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-[#1a9488] shrink-0"></span>
                                            @endif
                                            <div class="text-[0.85rem] font-semibold {{ $isUnread ? 'text-[#1a1a1a]' : 'text-[#777]' }}">Panggilan Konseling</div>
                                        </div>
                                        <div class="text-xs text-[#555] mb-1 {{ $isUnread ? '' : 'text-[#999]' }}">Jadwal: {{ \Carbon\Carbon::parse($notif->tanggal)->translatedFormat('d M') }} pkl {{ \Carbon\Carbon::parse($notif->waktu)->format('H:i') }}</div>
                                        <div class="text-[0.7rem] text-[#888]">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</div>
                                    </a>
                                    @endif
                                @endif
                            @endforeach
                        @else
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
            <!-- Logout -->
            <button onclick="document.getElementById('logout-form').submit()" class="p-2 text-[#333] focus:outline-none cursor-pointer">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </button>
        </div>

    </div>
</header>
