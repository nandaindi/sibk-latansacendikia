@extends('layouts.siswa')

@section('title', 'Dashboard Siswa – BK')

@push('preload')
    <link rel="preload" as="image" href="{{ asset('img/flying delivery robot saluting.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/gpt robot calling on phone.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/cute robot using laptop.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/friendly cute robot.svg') }}">
@endpush

@section('content')
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
                    class="w-full h-full object-contain"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>
        </div>

        <!-- Menu Konseling -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <span class="text-xl md:text-[1.3rem] font-extrabold text-[#1a1a1a]">Menu Konseling</span>
            </div>

            {{-- Notifikasi Status Pengajuan Aktif --}}
            @if($activeKonseling)
            <div class="mb-5 flex flex-col gap-3 bg-[#e0f5f3] border border-[#1a9488] rounded-2xl px-5 py-4 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-[#1a9488] flex items-center justify-center text-white mt-0.5">
                        @if($activeKonseling->status == 'disetujui')
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($activeKonseling->status == 'dipanggil')
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        @else
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-[0.95rem] text-[#1a1a1a]">
                            @if($activeKonseling->status == 'disetujui') Pengajuan Disetujui — Jadwal Konseling Kamu!
                            @elseif($activeKonseling->status == 'dipanggil') Kamu Dipanggil oleh Guru BK!
                            @else Pengajuan Sedang Menunggu Persetujuan
                            @endif
                        </div>
                        <div class="text-[0.85rem] text-[#555] mt-1">
                            Konseling <span class="font-semibold capitalize">{{ $activeKonseling->jenis }}</span>
                            @if($activeKonseling->status == 'disetujui')
                            · <span class="font-semibold">{{ \Carbon\Carbon::parse($activeKonseling->tanggal)->format('d M Y') }}</span>
                            @if($activeKonseling->waktu) pukul <span class="font-semibold">{{ \Carbon\Carbon::parse($activeKonseling->waktu)->format('H:i') }} WIB</span>@endif
                            @else
                            · Diajukan {{ \Carbon\Carbon::parse($activeKonseling->tanggal)->format('d M Y') }}
                            @endif
                        </div>
                        @if($activeKonseling->status == 'disetujui' && $activeKonseling->link_meet)
                        <a href="{{ $activeKonseling->link_meet }}" target="_blank"
                           class="mt-2 inline-flex items-center gap-1.5 text-[0.85rem] font-semibold text-[#1a9488] hover:underline">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.236a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            Buka Google Meet
                        </a>
                        @endif
                    </div>
                    @if($activeKonseling->status == 'disetujui')
                    <a href="{{ $activeKonseling->jenis == 'online' ? route('siswa.mulai-konseling') : route('siswa.konseling-offline') }}"
                       class="shrink-0 px-4 py-2 bg-[#1a9488] text-white text-[0.85rem] font-bold rounded-xl no-underline hover:bg-[#157a70] transition-all whitespace-nowrap">
                        Mulai
                    </a>
                    @elseif($activeKonseling->status == 'pending')
                    <a href="{{ route('siswa.pengajuan-proses') }}"
                       class="shrink-0 px-4 py-2 bg-[#1a9488] text-white text-[0.85rem] font-bold rounded-xl no-underline hover:bg-[#157a70] transition-all whitespace-nowrap">
                        Lihat Status
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
                <!-- Card 1: Panggilan -->
                <div class="bg-white rounded-[16px] pt-6 md:pt-8 flex flex-col items-center overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(26,148,136,0.08)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full">
                    <img src="{{ asset('img/gpt robot calling on phone.svg') }}" alt="Panggilan Konseling" class="h-[100px] md:h-[140px] w-auto object-contain mb-6 transition-transform duration-300 hover:scale-105">
                    <a href="{{ route('siswa.panggilan') }}" class="w-full bg-[#1a9488] text-white text-center text-sm md:text-base font-bold py-3.5 md:py-4 px-4 tracking-wide mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer">Panggilan Konseling</a>
                </div>
                <!-- Card 2: Pengajuan Online -->
                <div class="bg-white rounded-[16px] pt-6 md:pt-8 flex flex-col items-center overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(26,148,136,0.08)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full">
                    <img src="{{ asset('img/cute robot using laptop.svg') }}" alt="Pengajuan Online" class="h-[100px] md:h-[140px] w-auto object-contain mb-6 transition-transform duration-300 hover:scale-105">
                    <a href="{{ route('siswa.pengajuan-online') }}" class="w-full bg-[#1a9488] text-white text-center text-sm md:text-base font-bold py-3.5 md:py-4 px-4 tracking-wide mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer">Pengajuan Online</a>
                </div>
                <!-- Card 3: Pengajuan Offline -->
                <div class="bg-white rounded-[16px] pt-6 md:pt-8 flex flex-col items-center overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(26,148,136,0.08)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full">
                    <img src="{{ asset('img/friendly cute robot.svg') }}" alt="Pengajuan Offline" class="h-[100px] md:h-[140px] w-auto object-contain mb-6 transition-transform duration-300 hover:scale-105">
                    <a href="{{ route('siswa.pengajuan-offline') }}" class="w-full bg-[#1a9488] text-white text-center text-sm md:text-base font-bold py-3.5 md:py-4 px-4 tracking-wide mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer">Pengajuan Offline</a>
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
