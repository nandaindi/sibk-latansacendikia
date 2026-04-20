@extends('layouts.admin')

@section('title', 'Detail Laporan – Admin')

@section('content')

<div id="main-content" class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-2">
        <div>
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Laporan</h2>

            {{-- Action Buttons --}}
            <div class="flex gap-4 mt-3">
                <button onclick="cetakLaporanAdmin()"
                        class="w-10 h-10 md:w-11 md:h-11 bg-[#1eb808] text-white rounded-[10px] flex items-center justify-center hover:brightness-105 transition-all shadow-sm"
                        title="Cetak Laporan">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-bold lowercase">
            kelola laporan/detail
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white border-[2px] border-[#1a9488] bg-opacity-70 backdrop-blur-md rounded-[20px] p-6 lg:p-8 flex flex-col sm:flex-row items-center gap-6 md:gap-8 shadow-sm mb-6">
        {{-- Avatar Area --}}
        <div class="w-24 h-24 md:w-32 md:h-32 shrink-0 rounded-full bg-[#1a7a70] flex items-center justify-center text-white p-2">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>

        {{-- Details --}}
        <div class="flex flex-col gap-1.5 md:gap-2 text-[1.1rem] md:text-[1.2rem]">
            <div class="flex items-start">
                <span class="font-bold text-[#1a1a1a] w-[85px] shrink-0">Nama</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ $laporan->nama_laporan }}</span>
            </div>
            <div class="flex items-start">
                <span class="font-bold text-[#1a1a1a] w-[85px] shrink-0">Autor</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ $laporan->author->name ?? 'Admin / BK' }}</span>
            </div>
            <div class="flex items-start">
                <span class="font-bold text-[#1a1a1a] w-[85px] shrink-0">Date</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
        </div>
    </div>

    {{-- Data List inside Detail --}}
    <div class="flex flex-col gap-3">
        @forelse($items as $item)
        <div class="bg-white border-[2px] border-[#1a9488] rounded-[20px] shadow-sm overflow-hidden flex flex-col mb-2">
            <div class="bg-[#f0f9f8] border-b border-[#1a9488] px-6 py-4 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-[#1a1a1a] text-[1.05rem]">Sesi: {{ $item->user->name ?? '-' }}</h3>
                    <div class="text-[0.85rem] text-[#555] mt-1">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }} &bull; {{ ucfirst($item->jenis) }}</div>
                </div>
            </div>
            <div class="p-6 text-[0.95rem] text-[#333] leading-relaxed">
                {!! $item->catatan_bk ? nl2br(e(trim($item->catatan_bk))) : '<span class="italic text-gray-500">Tidak ada catatan sesi.</span>' !!}
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500 font-medium bg-white rounded-[20px] border-[2px] border-[#edf2f1]">Belum ada data sesi pada laporan ini.</div>
        @endforelse
    </div>

</div>

{{-- Area cetak – disiapkan statis dan hanya muncul saat window.print() --}}
<div id="printArea">
    <div class="pr-header">
        <h1>Detail Laporan Konseling</h1>
        <div class="pr-subtitle">Sistem Informasi Bimbingan Konseling &ndash; Latansa Cendekia</div>
    </div>
    
    <div class="pr-section">
        <h2>Informasi Laporan</h2>
        <div class="pr-field"><label>Nama Laporan</label><span>: {{ $laporan->nama_laporan }}</span></div>
        <div class="pr-field"><label>Autor</label><span>: {{ $laporan->author->name ?? 'Admin / BK' }}</span></div>
        <div class="pr-field"><label>Tanggal Buat</label><span>: {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span></div>
    </div>

    <div class="pr-section">
        <h2>Isi Laporan / Catatan Sesi</h2>
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

@media print {
    /* Hide layout elements explicitly */
    aside, header, nav, .no-print, #app-wrapper, #main-content { display: none !important; }
    
    body { background: white !important; margin: 0; padding: 0; }

    #printWrap {
        display: block !important;
        font-family: 'Poppins', sans-serif;
        padding: 40px;
        color: #1a1a1a;
        width: 100%;
        background: white;
    }
    #printWrap .pr-header {
        border-bottom: 3px solid #1a9488;
        padding-bottom: 14px;
        margin-bottom: 24px;
    }
    #printWrap .pr-header h1 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1a9488;
        margin: 0 0 4px;
    }
    #printWrap .pr-subtitle {
        font-size: 0.85rem;
        color: #888;
    }
    #printWrap .pr-section {
        margin-bottom: 24px;
    }
    #printWrap .pr-section h2 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1a9488;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #cce8e5;
        padding-bottom: 6px;
        margin-bottom: 12px;
        margin-top: 0;
    }
    #printWrap .pr-field {
        display: flex;
        gap: 8px;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }
    #printWrap .pr-field label {
        font-weight: 700;
        min-width: 140px;
        color: #333;
    }
    #printWrap .pr-log-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 10px;
    }
    #printWrap .pr-log-item {
        border: 1px solid #cce8e5;
        border-radius: 8px;
        overflow: hidden;
        page-break-inside: avoid;
    }
    #printWrap .pr-log-title {
        background-color: #f0f9f8;
        padding: 10px 14px;
        font-weight: bold;
        color: #1a9488;
        border-bottom: 1px solid #cce8e5;
    }
    #printWrap .pr-log-content {
        padding: 14px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #333;
    }
    #printWrap .pr-footer {
        margin-top: 50px;
        font-size: 0.8rem;
        color: #888;
        border-top: 1px solid #eee;
        padding-top: 12px;
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
        document.getElementById('printDate').innerText = today;
    });

function cetakLaporanAdmin() {
    // Hide original body children
    const children = Array.from(document.body.children);
    children.forEach(child => {
        if(child.tagName !== 'SCRIPT' && child.id !== 'printWrap') {
            child.dataset.originalDisplay = child.style.display;
            child.style.display = 'none';
        }
    });

    // Create or get print container
    let printWrap = document.getElementById('printWrap');
    if(!printWrap) {
        printWrap = document.createElement('div');
        printWrap.id = 'printWrap';
        document.body.appendChild(printWrap);
    }

    // Assign content
    printWrap.innerHTML = document.getElementById('printArea').innerHTML;
    printWrap.style.display = 'block';

    // Print
    window.print();

    // Restore
    printWrap.style.display = 'none';
    printWrap.innerHTML = '';
    children.forEach(child => {
        if(child.tagName !== 'SCRIPT' && child.id !== 'printWrap') {
            child.style.display = child.dataset.originalDisplay || '';
        }
    });
}
</script>
@endpush
