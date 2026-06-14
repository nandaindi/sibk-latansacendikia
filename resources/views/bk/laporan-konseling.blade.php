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
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-3">
        @forelse($laporans as $laporan)
        <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-4 py-3.5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-[0.95rem] text-[#1a1a1a]">{{ $laporan->user->name ?? ($laporan->nama_laporan) }}</div>
                <div class="text-[0.82rem] text-[#888] mt-0.5">
                    {{ $laporan->user->kelas ?? '-' }} {{ $laporan->user->jurusan ?? '' }}
                    <span class="ml-2 text-[#1a9488] font-medium uppercase text-xs px-2 py-0.5 bg-[#e0f5f3] rounded-full">
                        {{ ($laporan->konseling->jenis ?? '') == 'online' ? 'Online' : 'Offline' }}
                    </span>
                </div>
                <div class="text-[0.78rem] text-[#aaa] mt-0.5">
                    {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                    @if($laporan->konseling->waktu ?? null)
                        · {{ \Carbon\Carbon::parse($laporan->konseling->waktu)->format('H:i') }} WIB
                    @endif
                </div>
            </div>
            <a href="{{ route('bk.detail-laporan', ['id' => $laporan->id]) }}" class="text-[#1a9488] text-[0.9rem] font-semibold shrink-0 no-underline hover:text-[#12635a] transition-colors">
                Detail
            </a>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">
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
