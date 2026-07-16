@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Profile Section --}}
<section class="mb-8">
    <h2 class="text-[1.2rem] flex flex-col font-extrabold text-[#1a1a1a] mb-4">Profile</h2>
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-6 py-5 flex flex-col sm:flex-row items-center gap-5 shadow-sm w-full">
        {{-- Avatar --}}
        <div class="w-16 h-16 shrink-0 rounded-full bg-[#1a9488] flex items-center justify-center text-white">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>
        {{-- Info --}}
        <div class="flex flex-col gap-1.5">
            <div class="flex items-baseline gap-2">
                <span class="w-14 text-[0.7rem] font-extrabold text-[#888] uppercase tracking-wider">Nama</span>
                <span class="text-[0.97rem] font-bold text-[#1a1a1a]">: {{ auth()->user()->name }}</span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="w-14 text-[0.7rem] font-extrabold text-[#888] uppercase tracking-wider">Email</span>
                <span class="text-[0.97rem] font-bold text-[#1a1a1a]">: {{ auth()->user()->email }}</span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="w-14 text-[0.7rem] font-extrabold text-[#888] uppercase tracking-wider">Status</span>
                <span class="text-[0.97rem] font-bold text-[#1a1a1a]">: {{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</span>
            </div>
        </div>
    </div>
</section>
{{-- Stats Grid --}}
<section class="mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Siswa --}}
        <div class="bg-white border border-[#1a9488]/20 rounded-xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 rounded-full bg-[#1a9488]/10 text-[#1a9488] flex items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="text-[0.85rem] font-medium text-[#666] mb-0.5">Total Siswa</p>
                <h3 class="text-[1.5rem] font-bold text-[#1a1a1a] leading-none">{{ $siswaCount }}</h3>
            </div>
        </div>

        {{-- Total Guru BK --}}
        <div class="bg-white border border-[#1a9488]/20 rounded-xl p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 rounded-full bg-[#3b82f6]/10 text-[#3b82f6] flex items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div>
                <p class="text-[0.85rem] font-medium text-[#666] mb-0.5">Total Guru BK</p>
                <h3 class="text-[1.5rem] font-bold text-[#1a1a1a] leading-none">{{ $bkCount }}</h3>
            </div>
        </div>

    </div>
</section>

{{-- Cetak Laporan Section --}}



{{-- Area print tersembunyi --}}
<div id="adminPrintArea"></div>

@endsection

@push('styles')
<style>
#adminPrintArea { display: none; }

@media print {
    body > * { display: none !important; }
    #adminPrintArea {
        display: block !important;
        font-family: 'Poppins', sans-serif;
        padding: 32px;
        color: #1a1a1a;
    }
    #adminPrintArea .ap-header {
        border-bottom: 3px solid #1a9488;
        padding-bottom: 14px;
        margin-bottom: 24px;
    }
    #adminPrintArea .ap-header h1 {
        font-size: 1.3rem; font-weight: 800; color: #1a9488; margin: 0 0 4px;
    }
    #adminPrintArea .ap-subtitle { font-size: 0.82rem; color: #888; }
    #adminPrintArea .ap-field {
        display: flex; gap: 8px; margin-bottom: 10px;
        font-size: 0.95rem; line-height: 1.6;
    }
    #adminPrintArea .ap-field label { font-weight: 700; min-width: 140px; color: #333; }
    #adminPrintArea .ap-footer {
        margin-top: 40px; font-size: 0.78rem; color: #888;
        border-top: 1px solid #eee; padding-top: 10px;
    }
    #adminPrintArea table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
    #adminPrintArea th { background: #1a9488; color: white; padding: 8px 12px; text-align: left; }
    #adminPrintArea td { padding: 8px 12px; border-bottom: 1px solid #eee; }
    #adminPrintArea tr:nth-child(even) td { background: #f5fffe; }
}
</style>
@endpush

@push('scripts')
<script>
function printSingleReport(btn) {
    // Ambil data dari elemen parent (.laporan-cetak-item)
    var row = btn.closest('.laporan-cetak-item');
    var nama    = row.dataset.nama;
    var tanggal = row.dataset.tanggal;
    var penulis = row.dataset.penulis;

    var today = new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    document.getElementById('adminPrintArea').innerHTML =
        '<div class="ap-header">' +
            '<h1>Laporan Konseling</h1>' +
            '<div class="ap-subtitle">Sistem Informasi Bimbingan Konseling &ndash; Latansa Cendekia</div>' +
        '</div>' +
        '<div class="ap-field"><label>Nama Laporan</label><span>: ' + nama + '</span></div>' +
        '<div class="ap-field"><label>Tanggal</label><span>: ' + tanggal + '</span></div>' +
        '<div class="ap-field"><label>Dibuat Oleh</label><span>: ' + penulis + '</span></div>' +
        '<div class="ap-footer">Dicetak pada: ' + today + '</div>';

    window.print();
}

function printAllReport() {
    var items = document.querySelectorAll('.laporan-cetak-item');
    var rows = '';
    items.forEach(function(el, i) {
        rows += '<tr>' +
            '<td style="text-align:center">' + (i + 1) + '</td>' +
            '<td>' + el.dataset.nama + '</td>' +
            '<td>' + el.dataset.tanggal + '</td>' +
            '<td>' + el.dataset.penulis + '</td>' +
            '</tr>';
    });

    var today = new Date().toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    document.getElementById('adminPrintArea').innerHTML =
        '<div class="ap-header">' +
            '<h1>Daftar Laporan Konseling</h1>' +
            '<div class="ap-subtitle">Sistem Informasi Bimbingan Konseling &ndash; Latansa Cendekia</div>' +
        '</div>' +
        '<table>' +
            '<thead><tr>' +
                '<th style="width:40px">No</th>' +
                '<th>Nama Laporan</th>' +
                '<th>Tanggal</th>' +
                '<th>Penulis</th>' +
            '</tr></thead>' +
            '<tbody>' +
                (rows || '<tr><td colspan="4" style="text-align:center;padding:16px">Tidak ada data.</td></tr>') +
            '</tbody>' +
        '</table>' +
        '<div class="ap-footer">Dicetak pada: ' + today + '</div>';

    window.print();
}
</script>
@endpush
