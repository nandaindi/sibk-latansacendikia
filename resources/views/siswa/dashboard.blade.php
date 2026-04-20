@extends('layouts.siswa')

@section('title', 'Dashboard Siswa – BK')

@push('preload')
    <link rel="preload" as="image" href="{{ asset('img/flying delivery robot saluting.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/gpt robot calling on phone.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/cute robot using laptop.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/friendly cute robot.svg') }}">
@endpush

@section('content')
    {{-- Notifikasi Status Pengajuan Aktif (Floating Pojok Kanan Atas - Dibawah Profile) --}}
    @if($activeKonseling)
    <div id="activeKonselingCard" class="fixed z-[9999] w-[calc(100%-32px)] md:w-[380px] animate-in fade-in slide-in-from-right-10 duration-700 ease-out" 
         style="top: 100px; right: 24px; left: auto !important; display: none;">
        <div class="bg-white border border-[#1a9488]/30 rounded-2xl p-4 shadow-[0_20px_50px_rgba(26,148,136,0.2)] flex items-start ring-1 ring-black/5 relative overflow-hidden">
            
            {{-- Close Button --}}
            <button onclick="dismissActiveNotif()" class="absolute z-10 p-1 bg-white shadow-sm border border-red-100 text-red-500 hover:bg-red-500 hover:text-red rounded-full transition-all cursor-pointer flex items-center justify-center group" style="top: 8px; right: 8px; left: auto !important;" title="Tutup">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" class="group-hover:scale-90 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="flex-1 min-w-0 pr-8">
                <div class="font-black text-[1rem] text-[#1a1a1a] leading-tight tracking-tight capitalize">
                    @if($activeKonseling->status == 'disetujui') Jadwal Konseling Aktif!
                    @elseif($activeKonseling->status == 'dipanggil') Kamu Dipanggil Guru BK!
                    @else Menunggu Persetujuan...
                    @endif
                </div>
                <p class="text-[0.85rem] text-[#555] mt-1 font-medium leading-relaxed">
                    @if($activeKonseling->status == 'disetujui')
                        {{ ucfirst($activeKonseling->jenis) }} · <span class="font-bold text-[#1a9488]">{{ \Carbon\Carbon::parse($activeKonseling->tanggal)->format('d M') }} pkl {{ $activeKonseling->waktu ? \Carbon\Carbon::parse($activeKonseling->waktu)->format('H:i') : '--:--' }}</span>
                    @else
                        Pengajuan {{ $activeKonseling->jenis }} sedang diproses oleh Guru BK.
                    @endif
                </p>
                
                <div class="mt-4 flex items-center gap-2">
                    @if($activeKonseling->status == 'disetujui')
                    <a href="{{ $activeKonseling->jenis == 'online' ? route('siswa.mulai-konseling') : route('siswa.konseling-offline') }}"
                       class="px-5 py-2 bg-[#1a9488] text-white text-[0.85rem] font-black rounded-xl hover:bg-[#157a70] transition-all shadow-md hover:shadow-lg active:scale-95 no-underline">
                        Mulai Sesi
                    </a>
                    @elseif($activeKonseling->status == 'pending')
                    <a href="{{ route('siswa.pengajuan-proses') }}"
                       class="px-5 py-2 border-2 border-[#1a9488] text-[#1a9488] text-[0.85rem] font-black rounded-xl hover:bg-[#1a9488] hover:text-white transition-all no-underline">
                        Lihat Status
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($activeCounseling = $activeKonseling)
    <script>
        (function() {
            const key = 'dismissed_active_notif_{{ $activeCounseling->id }}';
            if (localStorage.getItem(key) !== 'true') {
                document.getElementById('activeKonselingCard').style.display = 'block';
            } else {
                document.addEventListener('DOMContentLoaded', () => {
                    const btn = document.getElementById('restoreNotifBtn');
                    if (btn) {
                        btn.classList.remove('hidden');
                        btn.classList.add('flex');
                    }
                });
            }
        })();
    </script>
    @endif

    @push('styles')
    <style>
        @keyframes custom-ping {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(2.2); opacity: 0; }
        }
        @keyframes badge-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }
        .animate-badge-ping {
            animation: custom-ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        .animate-badge-pulse {
            animation: badge-pulse 2s ease-in-out infinite;
        }
    </style>
    @endpush

    <!-- Content -->
    <main class="w-full px-4 md:px-6 py-6 md:py-10 flex flex-col gap-6 md:gap-12 flex-1 pb-[100px] md:pb-10">
        
        {{-- Warning Flash --}}
        @if(session('warning_pengajuan'))
        <div id="warningFlash" class="flex items-center gap-4 bg-amber-50 border border-amber-400 rounded-2xl px-5 py-4 shadow-sm">
            <div class="w-10 h-10 shrink-0 rounded-full bg-amber-400 flex items-center justify-center text-white">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            </div>
            <div class="flex-1 text-[0.9rem] font-semibold text-amber-800">{{ session('warning_pengajuan') }}</div>
            <button onclick="document.getElementById('warningFlash').remove()" class="text-amber-600 hover:text-amber-800 transition-colors">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif

        <!-- Hero Banner -->
        <div class="bg-gradient-to-br from-[#177a70] via-[#1a9488] to-[#20b2a0] rounded-2xl p-8 md:p-12 lg:px-14 flex flex-col md:flex-row items-center justify-between relative shadow-[0_10px_30px_rgba(26,148,136,0.25)] text-center md:text-left">
            <div class="flex-1 md:pr-10 z-10">
                <p class="text-[0.85rem] md:text-base text-white/90 font-medium mb-3 uppercase tracking-wide">Hallo Selamat Datang!</p>
                <h1 class="text-[1.8rem] md:text-[2.6rem] font-black text-white leading-tight md:leading-[1.2] mb-4 uppercase tracking-[-0.5px]">BERANI BERBICARA<br>BERANI PULIH</h1>
                <p class="text-[0.95rem] md:text-[1.05rem] text-white/85 leading-relaxed max-w-[500px] mx-auto md:mx-0 mb-6 md:mb-0">Bukan kuatnya kita yang membuat kita hebat<br>tapi keberanian untuk bangkit setelah jatuh.</p>
            </div>
            <div class="w-[140px] md:w-[240px] aspect-square shrink-0 relative z-10 md:mr-5">
                <img 
                    src="{{ asset('img/flying delivery robot saluting.svg') }}"
                    alt="Robot BK"
                    class="w-full h-full object-contain animate-robot-float"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between mb-6">
                <span class="text-xl md:text-[1.3rem] font-extrabold text-[#1a1a1a]">Menu Konseling</span>
                
                @if($activeKonselingCount > 0)
                <button id="restoreNotifBtn" title="Lihat jadwal aktif" onclick="restoreActiveNotif()" class="hidden items-center gap-3 px-5 py-2 bg-white text-[#1a9488] rounded-full hover:bg-[#f0f9f8] transition-all border border-[#1a9488]/20 cursor-pointer shadow-[0_6px_20px_rgba(26,148,136,0.12)] group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1a9488] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1a9488]"></span>
                    </span>
                    <span class="text-[0.8rem] font-bold tracking-tight">Jadwal Aktif</span>
                    
                    {{-- Badge with Animation --}}
                    <span class="relative flex items-center justify-center">
                        <span class="animate-badge-ping absolute inline-flex h-full w-full rounded-full bg-[#ef4444] opacity-50"></span>
                        <span class="relative flex items-center justify-center w-5 h-5 bg-[#ef4444] text-white text-[0.7rem] font-black rounded-full shadow-sm group-hover:scale-110 transition-transform animate-badge-pulse">
                            {{ $activeKonselingCount }}
                        </span>
                    </span>
                </button>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
                @php
                    $unreadPanggilanCount = \App\Models\Pelanggaran::where('user_id', auth()->id())
                        ->where('status', 'menunggu')
                        ->where('is_read', false)
                        ->count();
                @endphp
                
                <!-- Card 1: Panggilan Pelanggaran -->
                <div class="bg-white rounded-[32px] pt-10 md:pt-12 flex flex-col items-center overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(26,148,136,0.12)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full relative group/card">
                    {{-- Badge inside Card - Clean No Shadow --}}
                    @if($unreadPanggilanCount > 0)
                        <div class="absolute z-20 flex items-center justify-center animate-bounce-slow" style="top: 20px; right: 20px; background: transparent !important;">
                            <span class="flex items-center justify-center min-w-[28px] h-[28px] px-2 bg-[#ef4444] text-white text-[0.75rem] font-black rounded-full border-2 border-white">
                                {{ $unreadPanggilanCount }}
                            </span>
                        </div>
                    @endif

                    <div class="px-6 mb-8">
                        <img src="{{ asset('img/gpt robot calling on phone.svg') }}" alt="Panggilan Pelanggaran" class="h-[120px] md:h-[160px] w-auto object-contain transition-transform duration-500 group-hover/card:scale-110 animate-robot-wave">
                    </div>
                    
                    <a href="{{ route('siswa.panggilan') }}" class="w-full @if($unreadPanggilanCount > 0) bg-[#ef4444] @else bg-[#1a9488] @endif text-white text-center text-sm md:text-[1rem] font-black py-5 px-4 tracking-wider mt-auto no-underline hover:brightness-110 transition-all cursor-pointer flex items-center justify-center rounded-b-[32px]">
                        PANGGILAN PELANGGARAN
                    </a>
                </div>
                <!-- Card 2: Pengajuan Online -->
                <div class="bg-white rounded-[32px] pt-10 md:pt-12 flex flex-col items-center overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(26,148,136,0.12)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full group/card2">
                    <img src="{{ asset('img/cute robot using laptop.svg') }}" alt="Pengajuan Online" class="h-[120px] md:h-[160px] w-auto object-contain mb-10 transition-transform duration-500 group-hover/card2:scale-110 animate-robot-float">
                    <a href="{{ route('siswa.pengajuan-online') }}" class="w-full bg-[#1a9488] text-white text-center text-sm md:text-[1rem] font-black py-5 px-4 tracking-wider mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer flex items-center justify-center rounded-b-[32px]">PENGAJUAN ONLINE</a>
                </div>
                <!-- Card 3: Pengajuan Offline -->
                <div class="bg-white rounded-[32px] pt-10 md:pt-12 flex flex-col items-center overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(26,148,136,0.12)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full group/card3">
                    <img src="{{ asset('img/friendly cute robot.svg') }}" alt="Pengajuan Offline" class="h-[120px] md:h-[160px] w-auto object-contain mb-10 transition-transform duration-500 group-hover/card3:scale-110 animate-robot-wave">
                    <a href="{{ route('siswa.pengajuan-offline') }}" class="w-full bg-[#1a9488] text-white text-center text-sm md:text-[1rem] font-black py-5 px-4 tracking-wider mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer flex items-center justify-center rounded-b-[32px]">PENGAJUAN OFFLINE</a>
                </div>
            </div>
        </div>

        <!-- Artikel Edukasi -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <span class="text-lg md:text-[1.3rem] font-extrabold text-[#1a1a1a]">Artikel Edukasi Bimbingan Konseling</span>
                <a href="{{ route('siswa.artikel.index') }}" class="text-sm md:text-[0.95rem] text-[#1a9488] font-semibold no-underline hover:text-[#12635a] transition-colors whitespace-nowrap ml-4">Selengkapnya</a>
            </div>
            
            <!-- Horizontal scroll on mobile, Grid on Web -->
            <div class="flex overflow-x-auto md:grid md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 hide-scroll snap-x snap-mandatory pb-2 md:pb-0">
                @forelse($articles as $artikel)
                <a href="{{ route('siswa.artikel.show', $artikel->slug) }}" class="bg-white rounded-[16px] p-4 flex flex-col gap-4 no-underline border border-[#edf2f1] transition-all duration-300 hover:-translate-y-1.5 hover:shadow-[0_12px_30px_rgba(26,148,136,0.1)] shadow-[0_4px_12px_rgba(0,0,0,0.03)] h-full shrink-0 w-[260px] md:w-auto snap-start cursor-pointer group">
                    {{-- Image Container (Fixed Aspect Ratio) --}}
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden bg-[#f8fcfb] shrink-0 relative">
                        <div class="absolute inset-0 bg-black/5 z-10 group-hover:bg-transparent transition-colors duration-300"></div>
                        @if($artikel->gambar)
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center p-6">
                                <img src="{{ asset('img/flying delivery robot saluting.svg') }}" alt="{{ $artikel->judul }}" class="w-full h-full object-contain opacity-80">
                            </div>
                        @endif
                    </div>
                    
                    {{-- Text Content --}}
                    <div class="flex flex-col flex-1">
                        <h3 class="text-[1.05rem] md:text-[1.15rem] font-extrabold text-[#1a1a1a] leading-snug line-clamp-2 mb-2 group-hover:text-[#1a9488] transition-colors" title="{{ $artikel->judul }}">{{ $artikel->judul }}</h3>
                        <p class="text-[0.85rem] md:text-[0.9rem] text-[#666] leading-relaxed line-clamp-3 mt-auto">{{ strip_tags($artikel->konten) }}</p>
                    </div>
                </a>
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-8 text-[#888] font-medium bg-white rounded-2xl border border-[#edf2f1]">
                    Belum ada artikel edukasi terbaru.
                </div>
                @endforelse
            </div>
        </div>

    </main>
@endsection

@push('scripts')
<script>
    const STORAGE_KEY = 'dismissed_active_notif_{{ $activeKonseling->id ?? 0 }}';
    const notifCard = document.getElementById('activeKonselingCard');
    const restoreBtn = document.getElementById('restoreNotifBtn');

    function dismissActiveNotif() {
        if (notifCard) {
            notifCard.style.display = 'none';
            localStorage.setItem(STORAGE_KEY, 'true');
            if (restoreBtn) {
                restoreBtn.classList.remove('hidden');
                restoreBtn.classList.add('flex');
            }
        }
    }

    function restoreActiveNotif() {
        if (notifCard) {
            notifCard.style.display = 'block';
            localStorage.removeItem(STORAGE_KEY);
            if (restoreBtn) {
                restoreBtn.classList.add('hidden');
                restoreBtn.classList.remove('flex');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem(STORAGE_KEY) === 'true') {
            if (notifCard) notifCard.classList.add('hidden');
            if (restoreBtn) {
                restoreBtn.classList.remove('hidden');
                restoreBtn.classList.add('flex');
            }
        }
    });
</script>
@endpush
