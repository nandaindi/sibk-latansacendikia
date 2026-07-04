@extends('layouts.bk')

@section('title', 'Laporan Konseling – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Laporan Konseling</h2>
    </div>

    <!-- Tabs -->
    <div class="bg-[#2a9488] flex overflow-x-auto">
        <a href="{{ route('bk.laporan-konseling') }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ !$jenis ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Semua
        </a>
        <a href="{{ route('bk.laporan-konseling', ['jenis' => 'online']) }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ $jenis == 'online' ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Online
        </a>
        <a href="{{ route('bk.laporan-konseling', ['jenis' => 'offline']) }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ $jenis == 'offline' ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Offline
        </a>
    </div>

    {{-- Success Flash --}}
    @if(session('sukses'))
    <div class="mx-4 md:mx-6 mt-4 mb-1 flex items-center gap-3 bg-[#e0f5f3] border border-[#1a9488] rounded-2xl px-5 py-3.5 text-[0.9rem] font-semibold text-[#1a1a1a]">
        <svg width="20" height="20" fill="none" stroke="#1a9488" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('sukses') }}
    </div>
    @endif

    <!-- List -->
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-4">
        @forelse($laporans as $laporan)
        <div class="bg-white border border-[#edf2f1] rounded-2xl p-4 md:p-5 hover:border-[#1a9488] hover:shadow-[0_8px_30px_rgba(26,148,136,0.06)] transition-all flex gap-4">
            
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <h3 class="font-bold text-[1rem] text-[#1a1a1a] truncate">{{ $laporan->user->name ?? ($laporan->nama_laporan) }}</h3>
                    <span class="shrink-0 px-2.5 py-1 text-[0.65rem] font-bold uppercase rounded-md tracking-wider {{ ($laporan->konseling->jenis ?? '') == 'online' ? 'bg-[#e0f5f3] text-[#1a9488]' : 'bg-[#f3e0f5] text-[#941a7d]' }}">
                        {{ ($laporan->konseling->jenis ?? '') == 'online' ? 'Online' : 'Offline' }}
                    </span>
                </div>
                
                <p class="text-[0.85rem] text-[#666] mb-4">
                    {{ $laporan->user->kelas ?? '-' }} {{ $laporan->user->jurusan ?? '' }}
                </p>
                
                <div class="flex items-center justify-between pt-3 border-t border-[#f5f5f5]">
                    <div class="text-[0.8rem] text-[#888] flex flex-wrap items-center gap-1.5">
                        <div class="flex items-center gap-1">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <span>{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        @if($laporan->konseling->waktu ?? null)
                        <span class="text-[#ccc]">|</span>
                        <div class="flex items-center gap-1">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>{{ \Carbon\Carbon::parse($laporan->konseling->waktu)->format('H:i') }} WIB</span>
                        </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('bk.detail-laporan', ['id' => $laporan->id]) }}" class="text-[#1a9488] text-[0.85rem] font-bold no-underline hover:text-[#12635a] flex items-center gap-1 group">
                        Lihat Detail
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-[#888] font-medium bg-white rounded-2xl border border-[#edf2f1]">
            Belum ada laporan yang dibuat.
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 px-4 md:px-6">
        {{ $laporans->links() }}
    </div>

</div>
@endsection
