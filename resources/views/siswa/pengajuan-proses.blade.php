@extends('layouts.siswa')

@section('title', 'Pengajuan Sedang Diproses – BK')

@section('content')
<!-- Center Content -->
<main class="flex-1 flex flex-col items-center justify-center py-[60px] px-6 text-center bg-white">
    <!-- Animated Hourglass Illustration -->
    <div class="w-[220px] h-[220px] md:w-[280px] md:h-[280px] mb-6 md:mb-10">
        <img src="{{ asset('img/hourglass-animated.svg') }}" alt="Pengajuan Diproses" class="w-full h-full object-contain">
    </div>

    <h2 class="text-[1.3rem] md:text-[1.6rem] font-extrabold text-[#1a1a1a] mb-3 flex items-center justify-center gap-2">
        Pengajuan Sedang Progres
        <span class="flex gap-1">
            <span class="w-1.5 h-1.5 bg-[#1a9488] rounded-full animate-bounce" style="animation-delay: 0s;"></span>
            <span class="w-1.5 h-1.5 bg-[#1a9488] rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
            <span class="w-1.5 h-1.5 bg-[#1a9488] rounded-full animate-bounce" style="animation-delay: 0.4s;"></span>
        </span>
    </h2>
    <p class="text-[0.95rem] md:text-[1.05rem] text-[#666] leading-relaxed max-w-[500px] mb-12 animate-pulse">Silahkan ditunggu pengajuan sedang divalidasi</p>

    <a href="{{ route('siswa.dashboard') }}" class="px-12 md:px-16 py-3 md:py-3.5 bg-white text-[#1a9488] border-2 border-[#1a9488]/30 rounded-full text-[0.95rem] md:text-[1rem] font-bold shadow-sm transition-all duration-150 ease-out hover:bg-gray-50 hover:border-[#1a9488]/60 font-sans no-underline inline-block">Kembali ke Home</a>
</main>
@endsection
