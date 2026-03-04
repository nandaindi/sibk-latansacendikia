@extends('layouts.siswa')

@section('title', 'Pengajuan Sedang Diproses – BK')

@section('content')
<!-- Center Content -->
<main class="flex-1 flex flex-col items-center justify-center py-[60px] px-6 text-center bg-white">
    <!-- Animated Hourglass Illustration -->
    <div class="w-[220px] h-[220px] md:w-[280px] md:h-[280px] mb-6 md:mb-10">
        <img src="{{ asset('img/hourglass-animated.svg') }}" alt="Pengajuan Diproses" class="w-full h-full object-contain">
    </div>

    <h2 class="text-[1.3rem] md:text-[1.6rem] font-extrabold text-[#1a1a1a] mb-3">Pengajuan Sedang Progres...</h2>
    <p class="text-[0.95rem] md:text-[1.05rem] text-[#666] leading-relaxed max-w-[500px] mb-12">Silahkan ditunggu pengajuan sedang divalidasi</p>

    <a href="{{ route('siswa.dashboard') }}" class="px-12 md:px-16 py-3.5 md:py-4 bg-[#1a9488] text-white rounded-full text-[1rem] md:text-[1.1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] transition-all duration-150 ease-out hover:brightness-105 hover:-translate-y-0.5 font-sans no-underline inline-block">Home</a>
</main>
@endsection
