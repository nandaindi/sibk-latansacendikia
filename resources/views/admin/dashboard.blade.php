@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Profile Section --}}
<section class="mb-8">
    <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a] mb-4">Profil Saya</h2>
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-6 py-6 flex flex-col sm:flex-row items-center gap-6 shadow-sm w-full">
        <div class="w-20 h-20 shrink-0 rounded-full bg-[#e0f5f3] border-4 border-[#1a9488] flex items-center justify-center text-[#1a9488] shadow-sm">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2 w-full">
            <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                <span class="text-[0.85rem] font-bold text-gray-400 uppercase tracking-wider">Nama</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ auth()->user()->name }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                <span class="text-[0.85rem] font-bold text-gray-400 uppercase tracking-wider">Email</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ auth()->user()->email }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                <span class="text-[0.85rem] font-bold text-gray-400 uppercase tracking-wider">Status</span>
                <span class="text-[0.95rem] font-bold text-[#1a9488] uppercase tracking-tighter">{{ auth()->user()->role }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-gray-50 pb-2 md:border-none">
                <span class="text-[0.85rem] font-bold text-gray-400 uppercase tracking-wider">Login Sejak</span>
                <span class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ auth()->user()->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</section>

{{-- Information Cards --}}
<section class="mb-10">
    <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a] mb-4">Statistik Sistem</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 w-full">
        <!-- Kelola Akun -->
        <a href="{{ route('admin.kelola-akun') }}" class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <div class="w-14 h-14 rounded-xl bg-[#e0f5f3] flex items-center justify-center text-[#1a9488] group-hover:scale-110 transition-transform">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-3-3.87"/><path d="M9 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="text-center">
                <p class="text-[0.85rem] font-bold text-gray-500 uppercase tracking-wide">Total Akun</p>
                <p class="text-[1.5rem] font-black text-[#1a9488]">{{ $akunsCount }}</p>
            </div>
        </a>

        <!-- Data Siswa -->
        <a href="{{ route('admin.data-siswa') }}" class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <div class="w-14 h-14 rounded-xl bg-[#e0f5f3] flex items-center justify-center text-[#1a9488] group-hover:scale-110 transition-transform">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div class="text-center">
                <p class="text-[0.85rem] font-bold text-gray-500 uppercase tracking-wide">Siswa</p>
                <p class="text-[1.5rem] font-black text-[#1a9488]">{{ $siswaCount }}</p>
            </div>
        </a>

        <!-- Data BK -->
        <a href="{{ route('admin.data-bk') }}" class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <div class="w-14 h-14 rounded-xl bg-[#e0f5f3] flex items-center justify-center text-[#1a9488] group-hover:scale-110 transition-transform">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
            </div>
            <div class="text-center">
                <p class="text-[0.85rem] font-bold text-gray-500 uppercase tracking-wide">Guru BK</p>
                <p class="text-[1.5rem] font-black text-[#1a9488]">{{ $bkCount }}</p>
            </div>
        </a>

        <!-- Kelola Laporan -->
        <a href="{{ route('admin.kelola-laporan') }}" class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <div class="w-14 h-14 rounded-xl bg-[#e0f5f3] flex items-center justify-center text-[#1a9488] group-hover:scale-110 transition-transform">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div class="text-center">
                <p class="text-[0.85rem] font-bold text-gray-500 uppercase tracking-wide">Laporan</p>
                <p class="text-[1.5rem] font-black text-[#1a9488]">{{ $laporansCount }}</p>
            </div>
        </a>
    </div>
</section>

{{-- Daftar Laporan Section --}}
<section>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Laporan Konseling Terbaru</h2>
        <button onclick="printAllReport()" class="flex items-center gap-2 px-4 py-2 bg-[#1a9488] text-white rounded-xl font-bold text-sm shadow-sm hover:brightness-110 transition-all border-none cursor-pointer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak Semua
        </button>
    </div>

    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto min-w-full">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8fdfc] border-b border-[#e0f5f3]">
                        <th class="px-6 py-4 text-left text-[0.8rem] font-black text-[#1a9488] uppercase tracking-wider">Nama Laporan</th>
                        <th class="px-6 py-4 text-left text-[0.8rem] font-black text-[#1a9488] uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-[0.8rem] font-black text-[#1a9488] uppercase tracking-wider">Ditulis Oleh</th>
                        <th class="px-6 py-4 text-center text-[0.8rem] font-black text-[#1a9488] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($laporans as $laporan)
                    <tr class="laporan-cetak-item hover:bg-gray-50/50 transition-colors" 
                        data-nama="{{ $laporan->nama_laporan }}" 
                        data-tanggal="{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}" 
                        data-penulis="{{ $laporan->author->name ?? '-' }}">
                        <td class="px-6 py-4">
                            <span class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ $laporan->nama_laporan }}</span>
                        </td>
                        <td class="px-6 py-4 text-[0.9rem] text-gray-500 font-medium">
                            {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-[#e0f5f3] flex items-center justify-center text-[0.7rem] font-bold text-[#1a9488]">
                                    {{ substr($laporan->author->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-[0.9rem] font-semibold text-gray-700">{{ $laporan->author->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="printSingleReport(this)" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors border-none bg-transparent cursor-pointer" title="Cetak Laporan">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                            Belum ada laporan yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($laporans->hasPages())
        <div class="px-6 py-4 bg-[#f8fdfc] border-t border-[#e0f5f3]">
            {{ $laporans->links() }}
        </div>
        @endif
    </div>
</section>

<div id="adminPrintArea"></div>


@endsection

@push('styles')
<style>
#adminPrintArea { display: none; }

@media print {
    body > * { display: none !important; }
    #adminPrintArea {
        display: block !important;
        font-family: Arial, sans-serif;
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
