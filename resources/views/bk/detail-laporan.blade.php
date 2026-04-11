@extends('layouts.bk')

@section('title', 'Detail Laporan – BK')

@section('content')

<div id="main-content" class="w-full px-4 md:px-6 py-6 pb-[100px] md:pb-10">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-2">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('bk.laporan-konseling') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Laporan</h2>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-4 mt-4 ml-9">
                <button onclick="window.print()"
                        class="px-5 py-2.5 bg-[#1a9488] text-white rounded-xl flex items-center gap-2 hover:brightness-105 transition-all shadow-md group border-none cursor-pointer font-bold text-[0.9rem]"
                        title="Cetak Laporan">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Cetak Laporan
                </button>
            </div>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-bold">
            Riwayat Konseling / Detail
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white border-[2px] border-[#1a9488] rounded-[24px] p-6 lg:p-8 flex flex-col sm:flex-row items-center gap-6 md:gap-10 shadow-sm mb-8 animate-[fadeIn_0.5s_ease-out]">
        {{-- Illustration Area --}}
        <div class="w-24 h-24 md:w-32 md:h-32 shrink-0 rounded-3xl bg-[#e0f5f3] flex items-center justify-center text-[#1a9488] p-5 shadow-inner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-full h-full">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
        </div>

        {{-- Details --}}
        <div class="flex flex-col gap-2.5 md:gap-3 text-[1.05rem] md:text-[1.15rem] flex-1">
            <div class="flex items-start">
                <span class="font-bold text-[#555] w-[95px] shrink-0">Nama Laporan</span>
                <span class="font-bold text-[#1a9488] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ $laporan->nama_laporan }}</span>
            </div>
            <div class="flex items-start">
                <span class="font-bold text-[#555] w-[95px] shrink-0">Penulis</span>
                <span class="font-bold text-[#1a9488] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ $laporan->author->name ?? 'BK' }}</span>
            </div>
            <div class="flex items-start">
                <span class="font-bold text-[#555] w-[95px] shrink-0">Tanggal</span>
                <span class="font-bold text-[#1a9488] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
        </div>
    </div>

    {{-- Session Details List --}}
    <div class="flex flex-col gap-6">
        <h3 class="text-[1.1rem] font-extrabold text-[#1a9488] ml-2 flex items-center gap-2">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Detail Catatan Sesi
        </h3>
        
        @forelse($items as $item)
        @php
            // Split catatan_bk into sections
            $note = $item->catatan_bk;
            $problem = '';
            $solution = '';
            $additional = '';

            if (preg_match('/Problem:\s*(.*?)(?=Solution:|Note:|$)/s', $note, $matches)) {
                $problem = trim($matches[1]);
            }
            if (preg_match('/Solution:\s*(.*?)(?=Note:|$)/s', $note, $matches)) {
                $solution = trim($matches[1]);
            }
            if (preg_match('/Note:\s*(.*)/s', $note, $matches)) {
                $additional = trim($matches[1]);
            }

            // Fallback if structure is different
            if (empty($problem) && empty($solution) && !empty($note)) {
                $problem = $note;
            }
        @endphp

        <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] shadow-sm overflow-hidden flex flex-col group animate-[fadeInUp_0.4s_ease-out]">
            {{-- Card Header --}}
            <div class="bg-[#fcfdfd] border-b border-[#edf2f1] px-8 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#1a9488] text-white flex items-center justify-center font-black text-lg shadow-[0_4px_12px_rgba(26,148,136,0.2)]">
                        {{ substr($item->user->name ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-black text-[#1a1a1a] text-[1.1rem]">Siswa: {{ $item->user->name ?? '-' }}</h4>
                        <div class="text-[0.85rem] text-[#777] mt-0.5 font-bold flex items-center gap-3">
                            <span class="flex items-center gap-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </span>
                            <span class="text-[#ddd]">|</span>
                            <span class="flex items-center gap-1.5 {{ $item->jenis == 'online' ? 'text-blue-600' : 'text-emerald-600' }} uppercase tracking-widest text-[0.7rem] font-black">
                                @if($item->jenis == 'online')
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                @else
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                @endif
                                {{ $item->jenis }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Body: Parsed Notes --}}
            <div class="p-8 flex flex-col gap-6">
                {{-- Problem Section --}}
                @if($problem)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-[0.72rem] font-black text-[#e67e22] uppercase tracking-[0.1em]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Permasalahan (Problem)
                    </div>
                    <div class="text-[0.98rem] text-[#333] leading-relaxed pl-5 border-l-4 border-[#e67e22]/30 py-1">
                        {!! nl2br(e($problem)) !!}
                    </div>
                </div>
                @endif

                {{-- Solution Section --}}
                @if($solution)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-[0.72rem] font-black text-[#1a9488] uppercase tracking-[0.1em]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Solusi (Solution)
                    </div>
                    <div class="text-[0.98rem] text-[#333] leading-relaxed pl-5 border-l-4 border-[#1a9488]/30 py-1">
                        {!! nl2br(e($solution)) !!}
                    </div>
                </div>
                @endif

                {{-- Note Section --}}
                @if($additional)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-[0.72rem] font-black text-[#666] uppercase tracking-[0.1em]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Catatan Tambahan
                    </div>
                    <div class="text-[0.9rem] text-[#666] italic leading-relaxed pl-5 border-l-4 border-gray-200 py-1 bg-gray-50/50 rounded-r-xl">
                        {!! nl2br(e($additional)) !!}
                    </div>
                </div>
                @endif

                @if(!$problem && !$solution && !$additional)
                    <div class="text-center py-4 italic text-gray-400 text-[0.9rem]">Tidak ada detail catatan tersedia.</div>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-[#888] font-medium bg-white rounded-[24px] border border-[#eee] shadow-sm">
            <svg class="mx-auto mb-3 opacity-20" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
            Belum ada data sesi pada laporan ini.
        </div>
        @endforelse
    </div>

</div>

{{-- Area cetak – disiapkan statis dan hanya muncul saat window.print() --}}
<div id="printArea">
    <div class="pr-header">
        <h1>Laporan Hasil Konseling</h1>
        <div class="pr-subtitle">Sistem Informasi Bimbingan Konseling &ndash; Latansa Cendekia</div>
    </div>
    
    <div class="pr-section">
        <h2 class="pr-section-title">Informasi Laporan</h2>
        <div class="pr-field"><label>Nama Laporan</label><span>: {{ $laporan->nama_laporan }}</span></div>
        <div class="pr-field"><label>Penulis (BK)</label><span>: {{ $laporan->author->name ?? 'BK' }}</span></div>
        <div class="pr-field"><label>Tanggal Terbit</label><span>: {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span></div>
    </div>

    <div class="pr-section">
        <h2 class="pr-section-title">Isi Laporan / Catatan Sesi</h2>
        <div class="pr-log-container">
            @forelse($items as $index => $item)
            <div class="pr-log-item">
                <div class="pr-log-title">
                    Sesi: {{ $item->user->name ?? '-' }}
                    <span style="font-weight:normal; font-size:0.85em; color:#555;">
                        ({{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} - {{ ucfirst($item->jenis) }})
                    </span>
                </div>
                <div class="pr-log-content">
                    {!! $item->catatan_bk ? nl2br(e(trim($item->catatan_bk))) : '<i>Tidak ada catatan.</i>' !!}
                </div>
            </div>
            @empty
            <div class="pr-field" style="font-style: italic;">Belum ada sesi pada laporan ini.</div>
            @endforelse
        </div>
    </div>

    <div class="pr-footer">
        Dicetak pada: <span id="printDate"></span>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Sembunyikan printArea saat normal */
#printArea { display: none; }

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

@media print {
    aside, header, nav, .no-print { display: none !important; }
    
    main { padding: 0 !important; background: white !important; }
    #main-content { display: none !important; }

    #printArea {
        display: block !important;
        font-family: Arial, sans-serif;
        padding: 40px;
        color: #1a1a1a;
        width: 100%;
    }
    #printArea .pr-header {
        border-bottom: 4px solid #1a9488;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    #printArea .pr-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a9488;
        margin: 0 0 6px;
    }
    #printArea .pr-subtitle {
        font-size: 0.9rem;
        color: #666;
    }
    #printArea .pr-section {
        margin-bottom: 30px;
    }
    #printArea .pr-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a9488;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e0f5f3;
        padding-bottom: 8px;
        margin-bottom: 15px;
        margin-top: 0;
    }
    #printArea .pr-field {
        display: flex;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 1rem;
    }
    #printArea .pr-field label {
        font-weight: 700;
        min-width: 160px;
        color: #333;
    }
    #printArea .pr-log-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    #printArea .pr-log-item {
        border: 1px solid #cce8e5;
        border-radius: 10px;
        overflow: hidden;
        page-break-inside: avoid;
    }
    #printArea .pr-log-title {
        background-color: #f0f9f8;
        padding: 12px 16px;
        font-weight: bold;
        color: #1a9488;
        border-bottom: 1px solid #cce8e5;
    }
    #printArea .pr-log-content {
        padding: 16px;
        font-size: 0.95rem;
        line-height: 1.7;
        color: #1a1a1a;
    }
    #printArea .pr-footer {
        margin-top: 60px;
        font-size: 0.85rem;
        color: #999;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
        const printDateEl = document.getElementById('printDate');
        if(printDateEl) printDateEl.innerText = today;
    });
</script>
@endpush
