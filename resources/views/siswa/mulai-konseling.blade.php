@extends('layouts.siswa')

@section('title', 'Mulai Konseling – BK')

@section('content')
<main class="w-full px-4 md:px-6 py-6 md:py-10 flex flex-col gap-6 flex-1 pb-[100px] md:pb-10">

    <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a9488]">Silahkan Bercerita</h2>

    @if(!$konseling)
    <!-- Tidak ada sesi aktif -->
    <div class="flex flex-col items-center justify-center py-16 gap-4 text-center">
        <div class="w-16 h-16 rounded-full bg-[#e0f5f3] flex items-center justify-center">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
            </svg>
        </div>
        <p class="text-[#555] text-[0.95rem]">Belum ada sesi konseling online yang disetujui.</p>
        <a href="{{ route('siswa.dashboard') }}" class="px-5 py-2 bg-[#1a9488] text-white rounded-xl text-sm font-semibold hover:bg-[#12635a] transition-colors no-underline">
            Kembali ke Dashboard
        </a>
    </div>
    @else

    <!-- Deskripsi Card -->
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 shadow-sm">
        <p class="text-[1.05rem] font-extrabold text-[#1a1a1a] mb-5">Deskripsi</p>
        <div class="flex flex-col gap-3">
            <div class="flex items-start gap-2">
                <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[90px] shrink-0">Nama BK</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                {{-- Show first BK user's name, or a generic label --}}
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">Guru BK</span>
            </div>
            <div class="flex items-start gap-2">
                <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[90px] shrink-0">Date</span>
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
            @if($konseling->link_meet)
            <div class="flex items-start gap-2">
                <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[90px] shrink-0">Link Meet</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                <a href="{{ $konseling->link_meet }}" target="_blank"
                   class="text-[0.9rem] text-[#1a9488] font-semibold hover:underline break-all">
                    {{ $konseling->link_meet }}
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Tombol Mulai Chat -->
    <div class="flex justify-end mt-4">
        <a href="{{ route('siswa.chat-konseling') }}"
           class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] transition-all duration-150 hover:brightness-105 hover:-translate-y-0.5 no-underline inline-block">
            Mulai Chat
        </a>
    </div>

    @endif

</main>
@endsection
