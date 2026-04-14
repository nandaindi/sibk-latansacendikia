@extends('layouts.siswa')

@section('title', 'Panggilan Pelanggaran – BK')

@section('content')
    <!-- Content -->
    <main class="w-full px-4 md:px-6 py-6 md:py-10 flex-1">
        <div class="bg-white rounded-[16px] md:rounded-[24px] p-5 md:p-12 flex flex-col gap-4 shadow-[0_4px_12px_rgba(0,0,0,0.02)] md:shadow-[0_10px_40px_rgba(0,0,0,0.05)] border border-[#edf2f1] md:border-none min-h-[calc(100vh-140px)] md:min-h-0 w-full mb-20 md:mb-0">

            <div class="text-[0.95rem] md:text-[1.2rem] font-bold text-[#1a9488] uppercase tracking-[0.5px] mb-2 border-b-2 border-[#e0f5f3] pb-2 md:mb-5 mt-2 md:mt-0">
                Panggilan Masuk
            </div>

            @php $panggilanAktif = $panggilan->where('status', 'menunggu'); @endphp

            @forelse($panggilanAktif as $item)
            @php $sudahDibaca = $item->is_read; @endphp
            <a href="{{ route('siswa.detail-panggilan', $item->id) }}" class="rounded-2xl border-l-[5px] border-l-[#1a9488] border-t border-r border-b p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-3 md:gap-5 cursor-pointer no-underline transition-all duration-200 hover:shadow-[0_10px_24px_rgba(26,148,136,0.12)] hover:translate-x-1.5 shrink-0
                {{ $sudahDibaca
                    ? 'bg-[#f9fafb] border-t-[#f0f0f0] border-r-[#f0f0f0] border-b-[#f0f0f0] opacity-60'
                    : 'bg-white border-t-[#f0f0f0] border-r-[#f0f0f0] border-b-[#f0f0f0] ring-1 ring-[#1a9488]/20 shadow-sm' }}">
                <div class="w-14 h-14 rounded-[14px] {{ $sudahDibaca ? 'bg-[#f0f0f0]' : 'bg-[#e0f5f3]' }} flex-shrink-0 flex items-center justify-center">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="{{ $sudahDibaca ? '#aaa' : '#1a9488' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.61 19a19.5 19.5 0 0 1-6.06-6.06 19.79 19.79 0 0 1-2.09-8.21 2 2 0 0 1 1.99-2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 10a16 16 0 0 0 6.06 6.06l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <div class="flex-1 w-full md:mr-0 mb-3 md:mb-0">
                    <div class="text-[1.1rem] font-bold {{ $sudahDibaca ? 'text-[#888]' : 'text-[#1a1a1a]' }} mb-1">Guru BK</div>
                    <div class="text-[0.9rem] text-[#777]">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }} · {{ $item->waktu ?? '-' }}</div>
                    @if($item->catatan_pemanggilan)
                    <div class="text-[0.82rem] text-[#555] mt-1 line-clamp-2">{{ $item->catatan_pemanggilan }}</div>
                    @endif
                </div>
                @if($sudahDibaca)
                    <span class="text-[0.85rem] font-bold px-4 py-1.5 rounded-full bg-[#f0f0f0] text-[#aaa] border border-[#e0e0e0] self-start md:self-center">Dilihat</span>
                @else
                    <span class="text-[0.85rem] font-bold px-4 py-1.5 rounded-full bg-[#fff3cd] text-[#c97a00] border border-[#ffeeba] self-start md:self-center">Baru</span>
                @endif
            </a>
            @empty
            <div class="text-center py-8 text-gray-500 font-medium bg-[#f9fafb] rounded-2xl border border-[#edf2f1]">
                Tidak ada panggilan masuk saat ini.
            </div>
            @endforelse

            <div class="text-[0.95rem] md:text-[1.2rem] font-bold text-[#1a9488] uppercase tracking-[0.5px] mt-2 mb-2 md:mt-6 border-b-2 border-[#e0f5f3] pb-2">
                Riwayat
            </div>

            {{-- Riwayat: selesai/tidak hadir dari tabel pelanggarans --}}
            @php
                $riwayatPanggilan = \App\Models\Pelanggaran::where('user_id', auth()->id())
                    ->whereIn('status', ['selesai', 'tidak_hadir'])
                    ->latest()->take(5)->get();
            @endphp

            @forelse($riwayatPanggilan as $item)
            <div class="bg-[#f9fafb] rounded-2xl border-l-[5px] border-l-[#94a3b8] border-t border-r border-b border-[#f0f0f0] p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-3 md:gap-5 cursor-default transition-all duration-200 shrink-0">
                <div class="w-14 h-14 rounded-[14px] bg-[#f1f5f9] flex-shrink-0 flex items-center justify-center opacity-60">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11.61 19"/>
                        <path d="M14.05 2l5 5M2 2l20 20"/>
                    </svg>
                </div>
                <div class="flex-1 w-full md:mr-0 mb-3 md:mb-0 opacity-60">
                    <div class="text-[1.1rem] font-bold text-[#1a1a1a] mb-1">Guru BK</div>
                    <div class="text-[0.9rem] text-[#777]">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }} · {{ $item->waktu ?? '-' }}</div>
                </div>
                <div class="flex items-center gap-2 self-start md:self-center">
                    @if($item->status == 'selesai')
                        {{-- Untuk pelanggaran, mungkin belum ada file laporan khusus, tampilkan badge saja atau detail --}}
                        <a href="{{ route('siswa.detail-panggilan', $item->id) }}" class="text-[0.85rem] font-bold px-4 py-1.5 rounded-full bg-[#1a9488] text-white hover:brightness-105 hover:shadow-md transition-all no-underline">Lihat Detail</a>
                    @endif
                    <span class="text-[0.85rem] font-bold px-4 py-1.5 rounded-full bg-[#e0f5f3] text-[#1a9488] border border-[#c7ece8] capitalize">{{ $item->status }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-gray-400 text-sm">Belum ada riwayat.</div>
            @endforelse

        </div>
    </main>
@endsection
