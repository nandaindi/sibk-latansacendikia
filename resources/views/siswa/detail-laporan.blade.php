@extends('layouts.siswa')

@section('title', 'Detail Laporan Konseling')

@section('content')
<main class="w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10 max-w-4xl mx-auto">

    <!-- Header Section -->
    <div class="mb-6 flex flex-col gap-2">
        <a href="{{ route('siswa.riwayat-konseling') }}" class="text-[#1a9488] text-sm font-semibold hover:underline w-fit">&larr; Kembali ke Riwayat Laporan</a>
        <h2 class="text-[1.3rem] md:text-[1.8rem] font-extrabold text-[#1a1a1a]">Laporan Konseling</h2>
        <div class="text-[#555] text-sm mt-1">Sesi {{ ucfirst($laporan->jenis) }} &middot; {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('l, d F Y') }}</div>
    </div>

    <!-- Laporan Card -->
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="bg-[#e0f5f3] px-5 py-4 border-b border-[#1a9488]/30 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#1a9488] text-white flex items-center justify-center shrink-0">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-[#1a1a1a]">Hasil Konseling</h3>
                <div class="text-xs font-medium text-[#1a9488]">Bersama Guru BK</div>
            </div>
        </div>
        
        <div class="p-6">
            @if($laporan->catatan_bk)
                <div class="prose prose-sm md:prose-base max-w-none text-[#333] whitespace-pre-line leading-relaxed">
                    {{ $laporan->catatan_bk }}
                </div>
            @else
                <div class="text-center py-8 text-[#888] font-medium border-2 border-dashed border-[#edf2f1] rounded-xl flex flex-col items-center gap-2">
                    <svg width="32" height="32" fill="none" stroke="#ccc" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Belum ada catatan dari Guru BK untuk sesi ini.
                </div>
            @endif
        </div>
    </div>

</main>
@endsection
