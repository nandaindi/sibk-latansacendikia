@extends('layouts.siswa')

@section('title', 'Dashboard Siswa – BK')

@push('preload')
    <link rel="preload" as="image" href="{{ asset('img/flying delivery robot saluting.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/gpt robot calling on phone.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/cute robot using laptop.svg') }}">
    <link rel="preload" as="image" href="{{ asset('img/friendly cute robot.svg') }}">
@endpush

@section('content')
    {{-- Alert Hub: dropdown notifikasi pojok kanan atas --}}
    <div id="alertsHub" class="fixed z-50 right-4 md:right-6 flex flex-col items-end"
         style="top: max(88px, calc(env(safe-area-inset-top, 0px) + 88px));">
        @if($activeKonselingCount > 0 || $activePelanggaranCount > 0)
            <button id="mobileAlertsToggle" type="button"
                    class="inline-flex items-center gap-2 px-3 py-2 bg-white text-[#1a9488] rounded-full border border-[#1a9488]/20 shadow-[0_4px_12px_rgba(0,0,0,0.12)] transition-all hover:bg-[#f0f9f8] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#1a9488] focus-visible:ring-offset-2 cursor-pointer"
                    aria-expanded="false" aria-controls="mobileAlertsPanel"
                    aria-label="Lihat alert aktif">
                <span class="relative flex h-2 w-2 shrink-0">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1a9488] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1a9488]"></span>
                </span>
                <span class="text-[0.78rem] font-bold">Alert aktif</span>
                <span class="relative flex h-5 min-w-5 items-center justify-center rounded-full bg-[#ef4444] px-1 text-[0.65rem] font-black text-white shrink-0">
                    <span class="animate-badge-ping absolute inline-flex h-full w-full rounded-full bg-[#ef4444] opacity-50"></span>
                    <span class="relative">{{ $activeKonselingCount + $activePelanggaranCount }}</span>
                </span>
                <svg class="h-4 w-4 transition-transform duration-200" data-alert-chevron viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
            </button>

            <div id="mobileAlertsPanel"
                 class="hidden mt-2 w-[320px] max-w-[calc(100vw-2rem)] flex-col gap-3 overflow-y-auto overscroll-contain"
                 style="max-height: min(70dvh, 500px);"
                 aria-live="polite">
        
        @foreach($activeAlerts as $alert)
            @if($alert->alert_type == 'konseling')
                {{-- Kartu Konseling Aktif --}}
                <div id="activeKonselingCard" data-alert-card class="bg-white rounded-2xl overflow-hidden w-full shadow-[0_4px_20px_rgba(0,0,0,0.08)]" style="display:none;">
                    @if($alert->status == 'disetujui')
                    <div class="px-4 py-3.5">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-[#e6f7f5] flex items-center justify-center shrink-0">
                                        <svg width="15" height="15" fill="none" stroke="#1a9488" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[0.85rem] text-[#1a1a1a] leading-tight">Jadwal Konseling</div>
                                        <div class="text-[0.7rem] text-[#1a9488] font-semibold mt-0.5">Terkonfirmasi</div>
                                    </div>
                                </div>
                                <button onclick="dismissNotif('konseling', '{{ $alert->id }}')"
                                        class="w-7 h-7 flex items-center justify-center rounded-full text-[#ccc] hover:text-[#888] hover:bg-[#f5f5f5] transition-all cursor-pointer shrink-0"
                                        aria-label="Tutup">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="bg-[#f4faf9] rounded-xl px-3 py-2.5 mb-3 flex items-center gap-3">
                                <div>
                                    <div class="text-[0.72rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($alert->tanggal)->translatedFormat('d M Y') }}</div>
                                    <div class="text-[0.7rem] text-[#666]">{{ \Carbon\Carbon::parse($alert->waktu)->format('H:i') }} · {{ ucfirst($alert->jenis) }}</div>
                                </div>
                            </div>
                            <a href="{{ $alert->jenis == 'online' ? route('siswa.mulai-konseling') : route('siswa.konseling-offline') }}"
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-[#1a9488] text-white text-[0.78rem] font-bold rounded-xl hover:bg-[#157a70] active:scale-[0.98] transition-all no-underline">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Mulai Sesi Sekarang
                            </a>
                    </div>

                    @else
                    <div class="px-4 py-3.5">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                        <svg width="15" height="15" fill="none" stroke="#64748b" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[0.85rem] text-[#1a1a1a]">Menunggu Konfirmasi</div>
                                        <div class="text-[0.7rem] text-slate-500 font-semibold mt-0.5">Pengajuan {{ $alert->jenis }} diproses</div>
                                    </div>
                                </div>
                                <button onclick="dismissNotif('konseling', '{{ $alert->id }}')" class="w-7 h-7 flex items-center justify-center rounded-full text-[#ccc] hover:text-[#888] hover:bg-[#f5f5f5] transition-all cursor-pointer shrink-0" aria-label="Tutup">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                    </div>
                    @endif
                </div>
            @elseif($alert->alert_type == 'pelanggaran')
                {{-- Kartu Panggil Siswa --}}
                <div id="activePelanggaranCard" data-alert-card class="bg-white rounded-2xl overflow-hidden w-full shadow-[0_4px_20px_rgba(0,0,0,0.08)]" style="display:none;">
                    <div class="px-4 py-3.5">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                                        <svg width="15" height="15" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-[0.85rem] text-[#1a1a1a]">Panggil Siswa</div>
                                        <div class="text-[0.7rem] text-red-500 font-semibold mt-0.5">Perlu tindakan segera</div>
                                    </div>
                                </div>
                                <button onclick="dismissNotif('pelanggaran', '{{ $alert->id }}')"
                                        class="w-7 h-7 flex items-center justify-center rounded-full text-[#ccc] hover:text-[#888] hover:bg-[#f5f5f5] transition-all cursor-pointer shrink-0"
                                        aria-label="Tutup notifikasi panggilan siswa">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="bg-red-50 rounded-xl px-3 py-2.5 mb-3">
                                <div class="text-[0.72rem] font-bold text-[#1a1a1a] line-clamp-1">{{ $alert->topik }}</div>
                                <div class="text-[0.7rem] text-[#666] mt-0.5">{{ \Carbon\Carbon::parse($alert->tanggal)->translatedFormat('d M Y') }}, {{ \Carbon\Carbon::parse($alert->waktu)->format('H:i') }}</div>
                            </div>
                            <a href="{{ route('siswa.panggilan') }}"
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-red-600 text-white text-[0.78rem] font-bold rounded-xl hover:bg-red-700 active:scale-[0.98] transition-all no-underline">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Baca Detail
                            </a>
                    </div>
                </div>
            @endif
        @endforeach
            </div>
        @endif
    </div>

    {{-- Backdrop: tap di luar untuk tutup panel --}}
    <div id="alertsBackdrop" class="hidden fixed inset-0 z-40" aria-hidden="true" onclick="closeAlertsPanel()"></div>

    <script>
        (function() {
            window.dismissNotif = function(type, id) {
                const cardId = type === 'konseling' ? 'activeKonselingCard' : 'activePelanggaranCard';
                const card = document.getElementById(cardId);
                if (card) {
                    card.style.display = 'none';
                    localStorage.setItem(`dismissed_${type}_notif_${id}`, 'true');
                    updateRestoreBtn();
                    // close panel if all cards dismissed
                    const panel = document.getElementById('mobileAlertsPanel');
                    const hasVisible = panel && [...panel.querySelectorAll('[data-alert-card]')].some(c => c.style.display !== 'none');
                    if (!hasVisible) closeAlertsPanel();
                }
            };

            window.closeAlertsPanel = function() {
                const toggle = document.getElementById('mobileAlertsToggle');
                const panel = document.getElementById('mobileAlertsPanel');
                const backdrop = document.getElementById('alertsBackdrop');
                if (!toggle || !panel) return;
                toggle.setAttribute('aria-expanded', 'false');
                panel.classList.add('hidden');
                panel.classList.remove('flex', 'flex-col', 'gap-3');
                panel.querySelectorAll('[data-alert-card]').forEach(c => { c.style.display = 'none'; });
                toggle.querySelector('[data-alert-chevron]')?.classList.remove('rotate-180');
                if (backdrop) backdrop.classList.add('hidden');
            };

            window.restoreNotifs = function() {
                @foreach($activeAlerts as $alert)
                    localStorage.removeItem('dismissed_{{ $alert->alert_type }}_notif_{{ $alert->id }}');
                @endforeach
                location.reload();
            };

            function updateRestoreBtn() {
                if (window.matchMedia('(max-width: 767px)').matches) return;

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
                const mobileToggle = document.getElementById('mobileAlertsToggle');
                const mobilePanel = document.getElementById('mobileAlertsPanel');

                if (mobileToggle && mobilePanel) {
                    const backdrop = document.getElementById('alertsBackdrop');

                    mobileToggle.addEventListener('click', () => {
                        const isExpanded = mobileToggle.getAttribute('aria-expanded') === 'true';
                        if (isExpanded) {
                            closeAlertsPanel();
                            return;
                        }
                        mobileToggle.setAttribute('aria-expanded', 'true');
                        mobilePanel.classList.remove('hidden');
                        mobilePanel.classList.add('flex', 'flex-col', 'gap-3');
                        mobilePanel.querySelectorAll('[data-alert-card]').forEach(card => {
                            const type = card.id.includes('Konseling') ? 'konseling' : 'pelanggaran';
                            @foreach($activeAlerts as $alert)
                            if (card.id === '{{ $alert->alert_type == 'konseling' ? 'activeKonselingCard' : 'activePelanggaranCard' }}') {
                                if (localStorage.getItem('dismissed_{{ $alert->alert_type }}_notif_{{ $alert->id }}') !== 'true') {
                                    card.style.display = 'block';
                                }
                            }
                            @endforeach
                        });
                        mobileToggle.querySelector('[data-alert-chevron]')?.classList.add('rotate-180');
                        if (backdrop) backdrop.classList.remove('hidden');
                    });
                }

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

        @media (prefers-reduced-motion: reduce) {
            .animate-ping,
            .animate-badge-ping,
            .animate-badge-pulse,
            .animate-pulse {
                animation: none;
            }
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
        <div class="mt-8 md:mt-4 mb-4 md:mb-0 bg-gradient-to-br from-[#14736a] via-[#1a9488] to-[#22c5b0] rounded-3xl px-8 py-10 md:px-14 md:py-12 flex flex-col md:flex-row items-center justify-between relative shadow-[0_12px_40px_rgba(26,148,136,0.28)] text-center md:text-left overflow-hidden">

            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-white/5 rounded-full blur-3xl -translate-y-1/3 translate-x-1/4 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[200px] h-[200px] bg-black/5 rounded-full blur-2xl translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>

            <div class="flex-1 md:pr-10 z-10">
                <p class="text-[0.78rem] md:text-[0.85rem] text-white/75 font-semibold mb-3 uppercase tracking-[0.15em]">Hallo, Selamat Datang!</p>
                <h1 class="text-[1.7rem] md:text-[2.5rem] font-black text-white leading-tight md:leading-[1.15] mb-4 uppercase tracking-[-0.5px]">BERANI BERBICARA<br>BERANI PULIH</h1>
                <p class="text-[0.9rem] md:text-[1rem] text-white/80 leading-relaxed max-w-[460px] mx-auto md:mx-0">Bukan kuatnya kita yang membuat kita hebat,<br class="hidden md:block">tapi keberanian untuk bangkit setelah jatuh.</p>
            </div>

            <div class="w-[120px] md:w-[210px] aspect-square shrink-0 relative z-10 mt-6 md:mt-0 md:mr-4">
                <img
                    src="{{ asset('img/flying delivery robot saluting.svg') }}"
                    alt="Robot BK"
                    class="w-full h-full object-contain animate-robot-float drop-shadow-xl"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between mb-6">
                <span class="text-xl md:text-[1.3rem] font-extrabold text-[#1a1a1a]">Menu Konseling</span>
                
                @if($activeKonselingCount > 0 || $activePelanggaranCount > 0)
                <button id="restoreNotifBtn" title="Lihat jadwal aktif" onclick="restoreNotifs()" class="hidden md:items-center gap-3 px-5 py-2 bg-white text-[#1a9488] rounded-full hover:bg-[#f0f9f8] transition-all border border-[#1a9488]/20 cursor-pointer shadow-[0_6px_20px_rgba(26,148,136,0.12)] group">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1a9488] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1a9488]"></span>
                    </span>
                    <span class="text-[0.8rem] font-bold tracking-tight">Jadwal Aktif</span>
                    <span class="relative flex items-center justify-center">
                        <span class="animate-badge-ping absolute inline-flex h-full w-full rounded-full bg-[#ef4444] opacity-50"></span>
                        <span class="relative flex items-center justify-center w-5 h-5 bg-[#ef4444] text-white text-[0.7rem] font-black rounded-full shadow-sm group-hover:scale-110 transition-transform animate-badge-pulse">
                            {{ $activeKonselingCount + $activePelanggaranCount }}
                        </span>
                    </span>
                </button>
                @endif
            </div>

            @php
                $unreadPanggilanCount = \App\Models\Pelanggaran::where('user_id', auth()->id())
                    ->where('status', 'menunggu')
                    ->where('is_read', false)
                    ->count();
            @endphp

            {{-- Mobile: menu ringkas tanpa animasi, mengikuti pola kartu Guru BK. --}}
            <div class="grid grid-cols-1 gap-4 md:hidden">
                <a href="{{ route('siswa.panggilan') }}" class="no-underline">
                    <div class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden flex items-center p-5 gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] flex items-center justify-center shrink-0 relative">
                            <img src="{{ asset('img/gpt robot calling on phone.svg') }}" alt="Panggil Siswa" class="h-10 w-auto object-contain">
                            @if($unreadPanggilanCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-[#ef4444] border-2 border-white" aria-label="Ada panggilan baru"></span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="text-[1.1rem] font-bold text-[#1a1a1a] mb-1">Panggil Siswa</div>
                            <div class="text-[0.85rem] text-[#777]">Lihat panggilan dari Guru BK.</div>
                        </div>
                        <svg class="w-5 h-5 ml-auto shrink-0 text-[#1a9488]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                </a>

                <a href="{{ route('siswa.pengajuan-online') }}" class="no-underline">
                    <div class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden flex items-center p-5 gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] flex items-center justify-center shrink-0">
                            <img src="{{ asset('img/cute robot using laptop.svg') }}" alt="Pengajuan Online" class="h-10 w-auto object-contain">
                        </div>
                        <div class="min-w-0">
                            <div class="text-[1.1rem] font-bold text-[#1a1a1a] mb-1">Pengajuan Online</div>
                            <div class="text-[0.85rem] text-[#777]">Ajukan sesi konseling secara online.</div>
                        </div>
                        <svg class="w-5 h-5 ml-auto shrink-0 text-[#1a9488]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                </a>

                <a href="{{ route('siswa.pengajuan-offline') }}" class="no-underline">
                    <div class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden flex items-center p-5 gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] flex items-center justify-center shrink-0">
                            <img src="{{ asset('img/friendly cute robot.svg') }}" alt="Pengajuan Offline" class="h-10 w-auto object-contain">
                        </div>
                        <div class="min-w-0">
                            <div class="text-[1.1rem] font-bold text-[#1a1a1a] mb-1">Pengajuan Offline</div>
                            <div class="text-[0.85rem] text-[#777]">Ajukan sesi konseling tatap muka.</div>
                        </div>
                        <svg class="w-5 h-5 ml-auto shrink-0 text-[#1a9488]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    </div>
                </a>
            </div>

            {{-- Desktop: pertahankan tampilan kartu visual yang telah ada. --}}
            <div class="hidden md:grid md:grid-cols-3 gap-6">
                <!-- Card 1: Panggil Siswa (Full Width on Mobile) -->
                <div class="col-span-2 md:col-span-1 bg-white rounded-[32px] pt-10 md:pt-12 flex flex-col items-center overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(26,148,136,0.12)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full relative group/card">
                    <div class="px-6 mb-8">
                        <img src="{{ asset('img/gpt robot calling on phone.svg') }}" alt="Panggil Siswa" class="h-[120px] md:h-[160px] w-auto object-contain transition-transform duration-500 group-hover/card:scale-110 animate-robot-wave">
                    </div>
                    
                    <a href="{{ route('siswa.panggilan') }}" class="w-full @if($unreadPanggilanCount > 0) bg-[#ef4444] @else bg-[#1a9488] @endif text-white text-center text-[0.85rem] md:text-[1rem] font-black py-4 md:py-5 px-4 tracking-wider mt-auto no-underline hover:brightness-110 transition-all cursor-pointer flex items-center justify-center rounded-b-[32px]">
                        PANGGIL SISWA
                    </a>
                </div>
                <!-- Card 2: Pengajuan Online (Half Width on Mobile) -->
                <div class="col-span-1 bg-white rounded-[24px] md:rounded-[32px] pt-6 md:pt-12 flex flex-col items-center overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(26,148,136,0.12)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full group/card2">
                    <img src="{{ asset('img/cute robot using laptop.svg') }}" alt="Pengajuan Online" class="h-[80px] md:h-[160px] w-auto object-contain mb-6 md:mb-10 transition-transform duration-500 group-hover/card2:scale-110 animate-robot-float">
                    <a href="{{ route('siswa.pengajuan-online') }}" class="w-full bg-[#1a9488] text-white text-center text-[0.7rem] md:text-[1rem] font-black py-3 md:py-5 px-2 md:px-4 tracking-wide md:tracking-wider mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer flex items-center justify-center rounded-b-[24px] md:rounded-b-[32px]">PENGAJUAN ONLINE</a>
                </div>
                <!-- Card 3: Pengajuan Offline (Half Width on Mobile) -->
                <div class="col-span-1 bg-white rounded-[24px] md:rounded-[32px] pt-6 md:pt-12 flex flex-col items-center overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(26,148,136,0.12)] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] h-full group/card3">
                    <img src="{{ asset('img/friendly cute robot.svg') }}" alt="Pengajuan Offline" class="h-[80px] md:h-[160px] w-auto object-contain mb-6 md:mb-10 transition-transform duration-500 group-hover/card3:scale-110 animate-robot-wave">
                    <a href="{{ route('siswa.pengajuan-offline') }}" class="w-full bg-[#1a9488] text-white text-center text-[0.7rem] md:text-[1rem] font-black py-3 md:py-5 px-2 md:px-4 tracking-wide md:tracking-wider mt-auto no-underline hover:bg-[#157a70] transition-colors cursor-pointer flex items-center justify-center rounded-b-[24px] md:rounded-b-[32px]">PENGAJUAN OFFLINE</a>
                </div>
            </div>
        </div>

        <!-- Artikel Edukasi -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <span class="text-lg md:text-[1.3rem] font-extrabold text-[#1a1a1a]">Artikel Edukasi Bimbingan Konseling</span>
                <a href="{{ route('siswa.artikel.index') }}" class="text-sm md:text-[0.95rem] text-[#1a9488] font-semibold no-underline hover:text-[#12635a] transition-colors whitespace-nowrap ml-4">Selengkapnya</a>
            </div>
            
            <!-- Grid Layout (1 col mobile, 2 tablet, 4 desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($articles as $artikel)
                <a href="{{ route('siswa.artikel.show', $artikel->slug) }}" class="bg-white rounded-[20px] flex flex-col no-underline border border-[#edf2f1] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(26,148,136,0.12)] shadow-[0_4px_12px_rgba(0,0,0,0.04)] h-full w-full cursor-pointer group overflow-hidden">
                    {{-- Image Container --}}
                    <div class="w-full h-[140px] bg-[#f8fcfb] shrink-0 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5 z-10 group-hover:bg-transparent transition-colors duration-300"></div>
                        @if($artikel->gambar)
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center p-6 transition-transform duration-500 group-hover:scale-105">
                                <img src="{{ asset('img/flying delivery robot saluting.svg') }}" alt="{{ $artikel->judul }}" class="w-full h-full object-contain opacity-70">
                            </div>
                        @endif
                    </div>
                    
                    {{-- Text Content --}}
                    <div class="flex flex-col flex-1 p-5">
                        <h3 class="text-[1.05rem] font-bold text-[#1a1a1a] leading-snug line-clamp-2 mb-2 group-hover:text-[#1a9488] transition-colors" title="{{ $artikel->judul }}">{{ $artikel->judul }}</h3>
                        <p class="text-[0.85rem] text-[#666] leading-relaxed line-clamp-2 mb-4 flex-1">{{ strip_tags($artikel->konten) }}</p>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-[#f5f5f5]">
                            <span class="text-[0.75rem] font-bold text-[#1a9488] flex items-center gap-1">
                                Baca Artikel
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                            <span class="text-[0.7rem] text-[#888]">{{ $artikel->created_at->diffForHumans() }}</span>
                        </div>
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
