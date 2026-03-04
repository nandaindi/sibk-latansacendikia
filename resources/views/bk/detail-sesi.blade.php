@extends('layouts.bk')

@section('title', 'Detail Sesi Konseling – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5 flex items-center gap-3">
        <a href="{{ route('bk.sesi-konseling') }}" class="text-white hover:text-white/80 transition-colors mr-1">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Sesi Konseling</h2>
    </div>

    <!-- Content -->
    <main class="w-full px-4 md:px-6 flex-1 flex items-center pb-[80px] md:pb-10">
        <div class="w-full flex flex-col lg:flex-row gap-10 items-center justify-center py-8">

            <!-- LEFT: Info Card -->
            <div class="flex-1 w-full">
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 shadow-sm">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-start gap-2">
                            <span class="text-[1rem] font-bold text-[#1a1a1a] w-[60px] shrink-0">Nama</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">:</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">{{ $konseling->user->name }}</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-[1rem] font-bold text-[#1a1a1a] w-[60px] shrink-0">Tanggal</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">:</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-[1rem] font-bold text-[#1a1a1a] w-[60px] shrink-0">Jam</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">:</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">{{ $konseling->waktu ?? '-' }} WIB</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-[1rem] font-bold text-[#1a1a1a] w-[60px] shrink-0">Type</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">:</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a] capitalize">{{ $konseling->jenis }}</span>
                        </div>
                        @if($konseling->link_meet)
                        <div class="flex items-start gap-2">
                            <span class="text-[1rem] font-bold text-[#1a1a1a] w-[60px] shrink-0">Meet</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">:</span>
                            <a href="{{ $konseling->link_meet }}" target="_blank"
                               class="text-[0.97rem] text-[#1a9488] font-semibold hover:underline break-all">{{ $konseling->link_meet }}</a>
                        </div>
                        @endif
                        @if($konseling->catatan_bk)
                        <div class="flex items-start gap-2">
                            <span class="text-[1rem] font-bold text-[#1a1a1a] w-[60px] shrink-0">Catatan</span>
                            <span class="text-[1rem] font-bold text-[#1a1a1a]">:</span>
                            <span class="text-[0.97rem] text-[#333] leading-relaxed">{{ $konseling->catatan_bk }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RIGHT: Illustration + Action Button -->
            <div class="flex flex-col items-center gap-6">
                <!-- Heart-gesture illustration -->
                <div class="w-40 h-40 md:w-52 md:h-52">
                    <img src="{{ asset('img/Robot hand showing heart gesture.svg') }}" alt="Robot hand showing heart gesture" class="w-full h-full object-contain">
                </div>

                @if($konseling->jenis === 'online')
                    <!-- Mulai Konseling Online → Chat -->
                    <a href="{{ route('bk.konseling-online', ['id' => $konseling->id]) }}"
                       class="w-44 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold text-center shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all no-underline inline-block">
                        Mulai Chat
                    </a>
                @else
                    <!-- Mulai Konseling Offline → Form Pencatatan -->
                    <a href="{{ route('bk.form-konseling-offline', ['id' => $konseling->id]) }}"
                       class="w-44 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold text-center shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all no-underline inline-block">
                        Mulai
                    </a>
                @endif
            </div>

        </div>
    </main>
</div>
@endsection
