@extends('layouts.bk')

@section('title', 'Riwayat Panggilan – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Riwayat Panggilan Siswa</h2>
    </div>

    <!-- Tabs -->
    <div class="bg-[#2a9488] flex overflow-x-auto">
        <a href="{{ route('bk.riwayat-panggilan') }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ !$status ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Semua
        </a>
        <a href="{{ route('bk.riwayat-panggilan', ['status' => 'menunggu']) }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ $status == 'menunggu' ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Menunggu
        </a>
        <a href="{{ route('bk.riwayat-panggilan', ['status' => 'selesai']) }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ $status == 'selesai' ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Selesai
        </a>
        <a href="{{ route('bk.riwayat-panggilan', ['status' => 'tidak_hadir']) }}"
           class="flex-none px-6 py-3.5 text-white font-bold text-[0.9rem] border-b-[3px] transition-all no-underline
                  {{ $status == 'tidak_hadir' ? 'border-white' : 'border-transparent text-white/70 hover:text-white' }}">
            Tidak Hadir
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
        @forelse($riwayatPanggilan as $item)
        <div class="bg-white border border-[#edf2f1] rounded-2xl p-4 md:p-5 hover:border-[#1a9488] hover:shadow-[0_8px_30px_rgba(26,148,136,0.06)] transition-all flex gap-4">
            
            <div class="w-12 h-12 shrink-0 rounded-full overflow-hidden bg-[#e0f5f3] border border-[#edf2f1]">
                <img src="{{ $item->user->avatar ? asset('storage/' . $item->user->avatar) : asset('img/default-profile.png') }}" class="w-full h-full object-cover">
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3 mb-1">
                    <h3 class="font-bold text-[1rem] text-[#1a1a1a] truncate">{{ $item->user->name }}</h3>
                    <div class="md:text-right">
                        <span class="px-3 py-1 font-bold rounded-full text-[0.7rem] uppercase tracking-wider inline-block
                        {{ $item->status == 'selesai' ? 'bg-[#e0f5f3] text-[#1a9488]' : ($item->status == 'diterima' ? 'bg-green-100 text-green-600' : ($item->status == 'menunggu' ? 'bg-[#fdf3e1] text-[#f59e0b]' : 'bg-red-100 text-red-600')) }}">
                        {{ $item->status == 'selesai' ? 'Selesai' : ($item->status == 'diterima' ? 'Diterima' : ($item->status == 'menunggu' ? 'Menunggu' : 'Tidak Hadir')) }}
                        </span>
                    </div>
                </div>
                
                <p class="text-[0.85rem] text-[#666] mb-4 truncate" title="{{ $item->topik }}">
                    {{ $item->topik }}
                </p>
                
                <div class="flex items-center justify-between pt-3 border-t border-[#f5f5f5]">
                    <div class="text-[0.8rem] text-[#888] flex flex-wrap items-center gap-1.5">
                        <div class="flex items-center gap-1">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <span>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</span>
                        </div>
                        <span class="text-[#ccc]">|</span>
                        <div class="flex items-center gap-1">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('bk.panggil-siswa.detail', $item->id) }}" class="text-[#1a9488] text-[0.85rem] font-bold no-underline hover:text-[#12635a] flex items-center gap-1 group">
                        Lihat Detail
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-[#888] font-medium bg-white rounded-2xl border border-[#edf2f1]">
            Belum ada riwayat panggilan.
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 px-4 md:px-6">
        {{ $riwayatPanggilan->links() }}
    </div>

</div>
@endsection
