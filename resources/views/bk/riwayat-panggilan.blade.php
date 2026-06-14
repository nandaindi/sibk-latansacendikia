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
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-3">
        @forelse($riwayatPanggilan as $item)
        <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-4 py-3.5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-12 h-12 shrink-0 border border-[#edf2f1] rounded-full overflow-hidden bg-[#e0f5f3]">
                <img src="{{ $item->user->avatar ? asset('storage/' . $item->user->avatar) : asset('img/default-profile.png') }}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-[0.95rem] text-[#1a1a1a]">{{ $item->user->name }}</div>
                <div class="text-[0.82rem] text-[#888] mt-0.5">
                    {{ $item->topik }}
                    <span class="ml-2 text-[#1a9488] font-medium uppercase text-xs px-2 py-0.5 bg-[#e0f5f3] rounded-full">
                        {{ $item->status == 'selesai' ? 'Selesai' : ($item->status == 'menunggu' ? 'Menunggu' : 'Tidak Hadir') }}
                    </span>
                </div>
                <div class="text-[0.78rem] text-[#aaa] mt-0.5">
                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }} · {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}
                </div>
            </div>
            <a href="{{ route('bk.panggil-siswa.detail', $item->id) }}" class="text-[#1a9488] text-[0.9rem] font-semibold shrink-0 no-underline hover:text-[#12635a] transition-colors">
                Detail
            </a>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">
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
