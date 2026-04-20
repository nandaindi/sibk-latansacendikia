@extends('layouts.bk')

@section('title', 'Setujui Pengajuan Konseling – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5 flex items-center gap-3">
        <a href="{{ route('bk.validasi-pengajuan', ['id' => $konseling->id]) }}" class="text-white hover:text-white/80 transition-colors mr-1">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Setujui Pengajuan Konseling</h2>
    </div>

    <!-- Content -->
    <div class="flex flex-col items-center justify-center flex-1 px-4 py-10 gap-8">

        <!-- Info Siswa -->
        <div class="w-full max-w-sm bg-[#e0f5f3] border border-[#1a9488] rounded-2xl px-6 py-4 text-sm text-[#1a1a1a]">
            <div class="font-bold text-[1rem] mb-1">{{ $konseling->user->name ?? '-' }}</div>
            <div class="text-[#555]">{{ $konseling->user->kelas ?? '-' }} · Konseling <span class="capitalize">{{ $konseling->jenis }}</span></div>
        </div>

        <!-- Form Input Jadwal -->
        <form action="{{ route('bk.setujui-pengajuan.store') }}" method="POST" class="w-full max-w-sm flex flex-col gap-4">
            @csrf
            <input type="hidden" name="konseling_id" value="{{ $konseling->id }}">

            <div>
                <label class="text-[0.85rem] font-bold text-[#555] mb-1 block">Tanggal Konseling</label>
                <div class="flex items-center border-[2px] border-[#1a9488] rounded-full px-5 py-3.5 bg-white">
                    <input type="date" name="tanggal" required
                        value="{{ $konseling->tanggal }}"
                        class="flex-1 border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium appearance-none"/>
                </div>
            </div>

            <div>
                <label class="text-[0.85rem] font-bold text-[#555] mb-1 block">Waktu</label>
                <div class="flex items-center border-[2px] border-[#1a9488] rounded-full px-5 py-3.5 bg-white">
                    <input type="time" name="waktu" required
                        value="{{ $konseling->waktu ? \Carbon\Carbon::parse($konseling->waktu)->format('H:i') : '' }}"
                        class="flex-1 border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium appearance-none"/>
                </div>
            </div>

            @if($konseling->jenis == 'online')
            <div>
                <label class="text-[0.85rem] font-bold text-[#555] mb-1 block">
                    Link Meeting
                    <span class="font-normal text-[#999]">(Google Meet, Zoom, dll)</span>
                </label>
                <div class="flex items-center border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white gap-2">
                    <input type="text" name="link_meet"
                        placeholder="https://meet.google.com/xxx-yyyy-zzz  atau  https://zoom.us/j/..."
                        class="flex-1 border-none outline-none text-[0.9rem] text-[#1a1a1a] bg-transparent font-medium"/>
                </div>
                {{-- Panduan buat link baru --}}
                <div class="mt-2 flex flex-wrap gap-2">
                    <a href="https://meet.google.com/" target="_blank"
                       class="inline-flex items-center gap-1.5 text-[0.78rem] font-semibold text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors no-underline">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.236a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Buat Google Meet
                    </a>
                    <a href="https://zoom.us/start/videomeeting" target="_blank"
                       class="inline-flex items-center gap-1.5 text-[0.78rem] font-semibold text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full hover:bg-blue-100 transition-colors no-underline">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.236a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Buat Zoom Meeting
                    </a>
                </div>
                <p class="text-[0.75rem] text-[#aaa] mt-1.5">💡 Buat meeting terlebih dahulu, lalu copy & paste link-nya di sini.</p>
            </div>
            @endif

            <button type="submit"
                class="w-full py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold text-center shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all mt-2">
                Konfirmasi &amp; Setujui
            </button>
        </form>

    </div>
</div>
@endsection
