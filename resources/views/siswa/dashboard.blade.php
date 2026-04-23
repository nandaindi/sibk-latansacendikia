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
    {{-- Hub Notifikasi Aktif (Floating Pojok Kanan Atas) --}}
    <div id="alertsHub" class="fixed z-[9999] w-fit flex flex-col gap-4 animate-in fade-in slide-in-from-right-10 duration-700 ease-out" 
         style="top: 100px; right: 24px; left: auto !important;">
        
        @foreach($activeAlerts as $alert)
            @if($alert->alert_type == 'konseling')
                {{-- 1. Kartu Konseling Aktif --}}
                <div id="activeKonselingCard" class="bg-white border border-[#1a9488]/30 rounded-2xl p-4 shadow-[0_20px_50px_rgba(26,148,136,0.2)] flex items-start ring-1 ring-black/5 relative overflow-hidden w-full md:w-[380px]" style="display: none;">
                    {{-- Close Button --}}
                    <button onclick="dismissNotif('konseling', '{{ $alert->id }}')" class="absolute z-10 p-1 bg-white shadow-sm border border-red-100 text-red-500 hover:bg-red-500 hover:text-red-500
                     rounded-full transition-all cursor-pointer flex items-center justify-center group" style="top: 8px; right: 8px; left: auto !important;" title="Tutup">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="flex-1 min-w-0 pr-8">
                        <div class="font-black text-[0.95rem] text-[#1a1a1a] leading-tight tracking-tight uppercase mb-1">
                            @if($alert->status == 'disetujui') Jadwal Konseling Aktif
                            @elseif($alert->status == 'dipanggil') Kamu Dipanggil Guru BK
                            @else Menunggu Persetujuan
                            @endif
                        </div>
                        <p class="text-[0.8rem] text-[#555] font-medium leading-relaxed">
                            @if($alert->status == 'disetujui')
                                {{ ucfirst($alert->jenis) }} · <span class="font-bold text-[#1a9488]">{{ \Carbon\Carbon::parse($alert->tanggal)->format('d M') }} pkl {{ \Carbon\Carbon::parse($alert->waktu)->format('H:i') }}</span>
                            @elseif($alert->status == 'dipanggil')
                                Segera ke ruang BK hari ini sesuai instruksi Guru BK.
                            @else
                                Pengajuan {{ $alert->jenis }} sedang diproses.
                            @endif
                        </p>
                        <div class="mt-3 flex items-center gap-2">
                            @if($alert->status == 'disetujui')
                            <a href="{{ $alert->jenis == 'online' ? route('siswa.mulai-konseling') : route('siswa.konseling-offline') }}"
                               class="px-4 py-1.5 bg-[#1a9488] text-white text-[0.75rem] font-black rounded-lg hover:bg-[#157a70] transition-all no-underline shadow-sm">
                                MULAI SESI
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($alert->alert_type == 'pelanggaran')
                {{-- 2. Kartu Panggilan Pelanggaran --}}
                <div id="activePelanggaranCard" class="bg-red-50 border border-red-500/30 rounded-2xl p-4 shadow-[0_20px_50px_rgba(239,68,68,0.2)] flex items-start ring-1 ring-red-500/10 relative overflow-hidden w-full md:w-[380px]" style="display: none;">
                    {{-- Close Button --}}
                    <button onclick="dismissNotif('pelanggaran', '{{ $alert->id }}')" class="absolute z-10 p-1 bg-white shadow-sm border border-red-100 text-red-500 hover:bg-red-500 hover:text-red-500 rounded-full transition-all cursor-pointer flex items-center justify-center" style="top: 8px; right: 8px; left: auto !important;" title="Tutup">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="flex-1 min-w-0 pr-8">
                        <div class="flex items-center mb-1">
                            <div class="font-black text-[1rem] text-red-700 leading-tight tracking-tight uppercase">Panggilan Pelanggaran!</div>
                            <span class="flex h-1.5 w-1.5 rounded-full bg-red-600 animate-pulse shrink-0 ml-2"></span>
                        </div>
                        
                        <div class="text-[0.85rem] font-black text-red-800 uppercase tracking-wide mb-1">
                            TOPIK: {{ strtoupper($alert->topik) }}
                        </div>
                        
                        <p class="text-[0.8rem] text-red-600 font-medium leading-relaxed">
                            Jadwal: <span class="font-bold text-red-700">{{ \Carbon\Carbon::parse($alert->tanggal)->format('d M') }} pkl {{ \Carbon\Carbon::parse($alert->waktu)->format('H:i') }}</span> di Ruang BK.
                        </p>

                        <div class="mt-3 flex items-center gap-3">
                            <a href="{{ route('siswa.panggilan') }}"
                               style="background-color: #b91c1c !important; color: white !important;"
                               class="px-5 py-2 text-white text-[0.8rem] font-black rounded-lg hover:brightness-110 transition-all no-underline shadow-md active:scale-95 inline-flex items-center justify-center">
                                BACA DETAIL
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script>
        (function() {
            window.dismissNotif = function(type, id) {
                const cardId = type === 'konseling' ? 'activeKonselingCard' : 'activePelanggaranCard';
                const storageKey = `dismissed_${type}_notif_${id}`;
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.display = 'none';
                    localStorage.setItem(storageKey, 'true');
                    updateRestoreBtn();
                }
            };

            window.restoreNotifs = function() {
                @foreach($activeAlerts as $alert)
                    localStorage.removeItem('dismissed_{{ $alert->alert_type }}_notif_{{ $alert->id }}');
                @endforeach
                location.reload();
            };

            function updateRestoreBtn() {
                let anyDismissed = false;
                @foreach($activeAlerts as $alert)
                    if (localStorage.getItem('dismissed_{{ $alert->alert_type }}_notif_{{ $alert->id }}') === 'true') anyDismissed = true;
                @endforeach

                const btn = document.getElementById('restoreNotifBtn');
                if (btn) {
                    if (anyDismissed) {
                        btn.classList.remove('hidden');
                        btn.classList.add('flex');
                    } else {
                        btn.classList.add('hidden');
                        btn.classList.remove('flex');
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                @foreach($activeAlerts as $alert)
                    if (localStorage.getItem('dismissed_{{ $alert->alert_type }}_notif_{{ $alert->id }}') !== 'true') {
                        const cardId = '{{ $alert->alert_type == 'konseling' ? "activeKonselingCard" : "activePelanggaranCard" }}';
                        const c = document.getElementById(cardId);
                        if (c) c.style.display = 'block';
                    }
                @endforeach

                updateRestoreBtn();
            });
        })();
    </script>

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
                
                @if($activeKonselingCount > 0 || $activePelanggaranCount > 0)
                <button id="restoreNotifBtn" title="Lihat jadwal aktif" onclick="restoreNotifs()" class="hidden items-center gap-3 px-5 py-2 bg-white text-[#1a9488] rounded-full hover:bg-[#f0f9f8] transition-all border border-[#1a9488]/20 cursor-pointer shadow-[0_6px_20px_rgba(26,148,136,0.12)] group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1a9488] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1a9488]"></span>
                    </span>
                    <span class="text-[0.8rem] font-bold tracking-tight">Jadwal Aktif</span>
                    
                    {{-- Badge with Animation --}}
                    <span class="relative flex items-center justify-center">
                        <span class="animate-badge-ping absolute inline-flex h-full w-full rounded-full bg-[#ef4444] opacity-50"></span>
                        <span class="relative flex items-center justify-center w-5 h-5 bg-[#ef4444] text-white text-[0.7rem] font-black rounded-full shadow-sm group-hover:scale-110 transition-transform animate-badge-pulse">
                            {{ $activeKonselingCount + $activePelanggaranCount }}
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

</script>
@endpush
