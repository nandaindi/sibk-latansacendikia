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
    <div class="flex flex-col gap-3 mb-8">
        <h3 class="text-[1rem] font-bold text-[#1a1a1a]">Daftar Laporan</h3>
        @forelse($laporans as $laporan)
        <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 shrink-0 rounded-full bg-[#e0f5f3] flex items-center justify-center">
                <svg width="20" height="20" fill="none" stroke="#1a9488" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-[0.95rem] font-semibold text-[#1a1a1a] truncate">{{ $laporan->nama_laporan }}</div>
                <div class="text-[0.82rem] text-[#888] mt-0.5">{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">Belum ada laporan yang dibuat.</div>
        @endforelse
        <div class="mt-2">{{ $laporans->links() }}</div>
    </div>

    <!-- Sesi Selesai — bisa cetak laporan -->
    <div class="flex flex-col gap-3">
        <h3 class="text-[1rem] font-bold text-[#1a1a1a]">Sesi Selesai</h3>
        @forelse($selesSesi as $sesi)
        <div class="bg-white border border-[#e5e7eb] rounded-2xl px-5 py-4 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex-1 min-w-0">
                <div class="text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $sesi->user->name ?? '-' }}</div>
                <div class="text-[0.82rem] text-[#888] mt-0.5">
                    {{ \Carbon\Carbon::parse($sesi->tanggal)->format('d F Y') }} · <span class="capitalize">{{ $sesi->jenis }}</span>
                    @if($sesi->user->kelas)
                    · {{ $sesi->user->kelas }} {{ $sesi->user->jurusan ?? '' }}
                    @endif
                </div>
                @if($sesi->catatan_bk)
                <div class="text-[0.82rem] text-[#555] mt-1 italic truncate">{{ $sesi->catatan_bk }}</div>
                @endif
            </div>
            <button
                onclick="printLaporan(
                    {{ Js::from($sesi->user->name ?? '-') }},
                    {{ Js::from(\Carbon\Carbon::parse($sesi->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY')) }},
                    {{ Js::from($sesi->catatan_bk ?? '') }},
                    {{ Js::from($sesi->jenis ?? '') }},
                    {{ Js::from($sesi->user->kelas ?? '') }},
                    {{ Js::from($sesi->user->jurusan ?? '') }},
                    {{ Js::from($sesi->waktu ? \Carbon\Carbon::parse($sesi->waktu)->format('H:i') . ' WIB' : '-') }}
                )"
                class="shrink-0 px-4 py-2 border-[2px] border-[#1a9488] text-[#1a9488] text-[0.85rem] font-bold rounded-full hover:bg-[#1a9488] hover:text-white transition-all flex items-center gap-1.5">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/>
                </svg>
                Cetak
            </button>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border border-[#edf2f1]">Belum ada sesi yang selesai.</div>
        @endforelse
        <div class="mt-2">{{ $selesSesi->links() }}</div>
    </div>

</main>

{{-- Area cetak – hanya muncul saat window.print() dipanggil --}}
<div id="printArea"></div>

@endsection

@push('styles')
<style>
/* Sembunyikan printArea saat normal */
#printArea { display: none; }

/* Saat mencetak: sembunyikan semua kecuali printArea */
@media print {
    header, nav, main, footer, .no-print { display: none !important; }
    body { background-color: white !important; }

    #printArea {
        display: block !important;
        font-family: Arial, sans-serif;
        padding: 32px;
        color: #1a1a1a;
    }
    #printArea .pr-header {
        border-bottom: 3px solid #1a9488;
        padding-bottom: 14px;
        margin-bottom: 24px;
    }
    #printArea .pr-header h1 {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1a9488;
        margin: 0 0 4px;
    }
    #printArea .pr-subtitle {
        font-size: 0.82rem;
        color: #888;
    }
    #printArea .pr-section {
        margin-bottom: 18px;
    }
    #printArea .pr-section h2 {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1a9488;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #cce8e5;
        padding-bottom: 5px;
        margin-bottom: 10px;
        margin-top: 0;
    }
    #printArea .pr-field {
        display: flex;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    #printArea .pr-field label {
        font-weight: 700;
        min-width: 140px;
        flex-shrink: 0;
        color: #333;
    }
    #printArea .pr-catatan {
        background: #f5fffe;
        border: 1px solid #cce8e5;
        border-radius: 6px;
        padding: 12px 14px;
        font-size: 0.9rem;
        line-height: 1.75;
        white-space: pre-wrap;
        word-break: break-word;
    }
    #printArea .pr-footer {
        margin-top: 40px;
        font-size: 0.78rem;
        color: #888;
        border-top: 1px solid #eee;
        padding-top: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function printLaporan(nama, tanggal, catatan, jenis, kelas, jurusan, waktu) {
    var today = new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    var kelasHtml = kelas
        ? '<div class="pr-field"><label>Kelas / Jurusan</label><span>: ' + kelas + ' ' + jurusan + '</span></div>'
        : '';

    var catatanHtml = catatan
        ? '<div class="pr-section"><h2>Catatan BK</h2><div class="pr-catatan">' + catatan.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</div></div>'
        : '';

    var jenisFormatted = jenis ? jenis.charAt(0).toUpperCase() + jenis.slice(1) : '-';

    document.getElementById('printArea').innerHTML =
        '<div class="pr-header">' +
            '<h1>Laporan Konseling</h1>' +
            '<div class="pr-subtitle">Sistem Informasi Bimbingan Konseling \u2013 Latansa Cendekia</div>' +
        '</div>' +
        '<div class="pr-section">' +
            '<h2>Data Siswa</h2>' +
            '<div class="pr-field"><label>Nama Siswa</label><span>: ' + nama + '</span></div>' +
            kelasHtml +
        '</div>' +
        '<div class="pr-section">' +
            '<h2>Informasi Sesi</h2>' +
            '<div class="pr-field"><label>Tanggal</label><span>: ' + tanggal + '</span></div>' +
            '<div class="pr-field"><label>Waktu</label><span>: ' + waktu + '</span></div>' +
            '<div class="pr-field"><label>Jenis Sesi</label><span>: ' + jenisFormatted + '</span></div>' +
        '</div>' +
        catatanHtml +
        '<div class="pr-footer">Dicetak pada: ' + today + '</div>';

    window.print();
}
</script>
@endpush
