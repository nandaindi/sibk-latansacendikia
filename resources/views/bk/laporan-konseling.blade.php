@extends('layouts.bk')

@section('title', 'Laporan Konseling – BK')

@section('content')
<main class="w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10">

    <!-- Title -->
    <div class="mb-6 flex items-center justify-between flex-wrap gap-3">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Laporan Konseling</h2>
        <span class="text-[0.85rem] text-[#888]">Total: {{ $laporans->total() }} laporan</span>
    </div>

    {{-- Success Flash --}}
    @if(session('sukses'))
    <div class="mb-5 flex items-center gap-3 bg-[#e0f5f3] border border-[#1a9488] rounded-2xl px-5 py-4 text-[0.9rem] font-semibold text-[#1a1a1a]">
        <svg width="20" height="20" fill="none" stroke="#1a9488" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('sukses') }}
    </div>
    @endif

    <!-- Laporan list dari DB -->
    <div class="flex flex-col gap-4 mb-8">
        <h3 class="text-[1rem] font-extrabold text-[#1a9488] border-l-4 border-[#1a9488] pl-3 mb-1">Daftar Laporan</h3>
        
        @forelse($laporans as $laporan)
        <div class="bg-white border-[2px] border-[#edf2f1] rounded-3xl p-6 shadow-sm hover:shadow-md hover:border-[#1a9488]/30 transition-all group">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                
                {{-- Left Side: Student Info & Type --}}
                <div class="flex flex-col gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        @if(($laporan->konseling->jenis ?? '') == 'online')
                        <span class="flex items-center gap-1.5 text-[0.68rem] font-black px-3 py-1 rounded-full bg-blue-100 text-blue-700 uppercase tracking-widest">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            Online
                        </span>
                        @else
                        <span class="flex items-center gap-1.5 text-[0.68rem] font-black px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 uppercase tracking-widest">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Offline
                        </span>
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <h4 class="text-[1.1rem] font-extrabold text-[#1a1a1a] group-hover:text-[#1a9488] transition-colors leading-tight">
                            {{ $laporan->user->name ?? ($laporan->nama_laporan) }}
                        </h4>
                        <div class="flex items-center gap-2 text-[0.88rem] text-[#777] mt-1 font-semibold">
                            {{ $laporan->user->kelas ?? '-' }} {{ $laporan->user->jurusan ?? '' }}
                        </div>
                    </div>
                </div>

                {{-- Right Side: Date & Actions --}}
                <div class="flex flex-col md:items-end justify-between gap-4">
                    <div class="text-left md:text-right">
                        <div class="text-[0.9rem] font-bold text-[#1a1a1a]">
                            {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </div>
                        @if($laporan->konseling->waktu ?? null)
                        <div class="text-[0.85rem] font-black text-[#1a9488] mt-0.5">
                            {{ \Carbon\Carbon::parse($laporan->konseling->waktu)->format('H:i') }} WIB
                        </div>
                        @else
                        <div class="text-[0.85rem] font-bold text-[#aaa] mt-0.5 italic">Waktu tidak tercatat</div>
                        @endif
                    </div>

                    <a href="{{ route('bk.detail-laporan', ['id' => $laporan->id]) }}"
                        class="w-full md:w-auto px-6 py-2.5 bg-[#1a9488] text-white text-[0.85rem] font-extrabold rounded-full hover:bg-[#12635a] hover:shadow-lg transition-all flex items-center justify-center gap-2 no-underline shadow-[0_4px_12px_rgba(26,148,136,0.15)]">
                        Lihat Detail
                    </a>
                </div>

            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500 font-medium bg-white rounded-3xl border-[2px] border-dashed border-[#edf2f1]">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            Belum ada laporan yang dibuat.
        </div>
        @endforelse
        <div class="mt-4">{{ $laporans->links() }}</div>
    </div>

    </div>

</main>

@endsection

