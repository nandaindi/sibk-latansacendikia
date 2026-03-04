@extends('layouts.siswa')

@section('title', 'Konseling Offline – BK')

@section('content')
<main class="w-full px-4 md:px-6 py-6 md:py-10 flex flex-col gap-6 flex-1 pb-[100px] md:pb-10">

    <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a9488]">Jadwal Konseling Offline</h2>

    @if(!$konseling)
    <div class="flex flex-col items-center justify-center py-16 gap-4 text-center">
        <div class="w-16 h-16 rounded-full bg-[#e0f5f3] flex items-center justify-center">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
            </svg>
        </div>
        <p class="text-[#555] text-[0.95rem]">Belum ada sesi konseling offline yang disetujui.</p>
        <a href="{{ route('siswa.dashboard') }}" class="px-5 py-2 bg-[#1a9488] text-white rounded-xl text-sm font-semibold hover:bg-[#12635a] transition-colors no-underline">
            Kembali ke Dashboard
        </a>
    </div>
    @else

    <!-- Info Card -->
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 shadow-sm">
        <div class="flex flex-col gap-3">
            <div class="flex items-start gap-2">
                <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[90px] shrink-0">Tanggal</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="flex items-start gap-2">
                <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[90px] shrink-0">Jam</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ $konseling->waktu ?? '-' }} WIB</span>
            </div>
            <div class="flex items-start gap-2">
                <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[90px] shrink-0">Status</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                <span class="text-[0.95rem] font-bold text-[#1a9488] capitalize">{{ $konseling->status }}</span>
            </div>
        </div>
    </div>

    <!-- Center illustration + note -->
    <div class="flex flex-col items-center justify-center flex-1 py-8 gap-4">
        <div class="w-[180px] h-[180px] md:w-[240px] md:h-[240px]">
            <img src="{{ asset('img/Stationery and physics book for education.svg') }}"
                 alt="Konseling Offline"
                 class="w-full h-full object-contain">
        </div>
        <p class="text-[1.1rem] md:text-[1.25rem] font-semibold text-[#1a1a1a] text-center">
            Silahkan datang ke ruang BK!
        </p>
        <p class="text-[0.9rem] text-[#777] text-center">
            Pada tanggal <strong>{{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('d F Y') }}</strong>
            pukul <strong>{{ $konseling->waktu ?? '-' }} WIB</strong>
        </p>
    </div>

    @endif

</main>
@endsection
