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
                </div>
                @if($sesi->catatan_bk)
                <div class="text-[0.82rem] text-[#555] mt-1 italic truncate">{{ $sesi->catatan_bk }}</div>
                @endif
            </div>
            <button onclick="printLaporan(@json($sesi->user->name ?? '-'), @json(\Carbon\Carbon::parse($sesi->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY')), @json($sesi->catatan_bk ?? ''))"
                class="shrink-0 px-4 py-2 border-[2px] border-[#1a9488] text-[#1a9488] text-[0.85rem] font-bold rounded-full hover:bg-[#1a9488] hover:text-white transition-all">
                Cetak
            </button>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border border-[#edf2f1]">Belum ada sesi yang selesai.</div>
        @endforelse
        <div class="mt-2">{{ $selesSesi->links() }}</div>
    </div>

</main>
@endsection

@push('scripts')
<script>
function printLaporan(nama, tanggal, catatan) {
    const win = window.open('', '_blank', 'width=800,height=600');
    win.document.write(`
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Laporan Konseling – ${nama}</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 40px; color: #1a1a1a; }
                h1 { font-size: 1.3rem; font-weight: 800; margin-bottom: 24px; border-bottom: 2px solid #1a9488; padding-bottom: 10px; }
                p { line-height: 1.7; margin-bottom: 14px; font-size: 1rem; }
                strong { font-weight: 700; }
                @media print { body { padding: 20px; } }
            </style>
        </head>
        <body>
            <h1>Laporan Konseling</h1>
            <p><strong>Nama Siswa :</strong> ${nama}</p>
            <p><strong>Tanggal    :</strong> ${tanggal}</p>
            <p><strong>Catatan BK :</strong> ${catatan || '-'}</p>
        </body>
        </html>
    `);
    win.document.close();
    win.focus();
    win.print();
    win.close();
}
</script>
@endpush
