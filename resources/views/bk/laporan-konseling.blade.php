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

    <!-- Table -->
    <div class="w-full px-4 md:px-6 py-5">
        <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
            <table id="laporanTable" class="w-full text-left border-collapse display">
                <thead>
                    <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                        <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                        <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama Siswa</th>
                        <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Kelas</th>
                        <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Jenis</th>
                        <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                        <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#edf2f1]">
                    @foreach($laporans as $i => $laporan)
                    <tr class="hover:bg-[#fcfdfd] transition-colors">
                        <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $i + 1 }}</td>
                        <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $laporan->user->name ?? $laporan->nama_laporan }}</td>
                        <td class="hidden md:table-cell p-4 text-[0.9rem] text-[#555]">{{ $laporan->user->kelas ?? '-' }} {{ $laporan->user->jurusan ?? '' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 text-[0.72rem] font-bold uppercase rounded-full tracking-wider {{ ($laporan->konseling->jenis ?? '') == 'online' ? 'bg-[#e0f5f3] text-[#1a9488]' : 'bg-[#f3e0f5] text-[#941a7d]' }}">
                                {{ ($laporan->konseling->jenis ?? '') == 'online' ? 'Online' : 'Offline' }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell p-4 text-[0.85rem] text-[#888]">{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('bk.detail-laporan', ['id' => $laporan->id]) }}" title="Lihat Detail" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors inline-flex">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#laporanTable').DataTable({
        responsive: true,
        scrollX: false,
        autoWidth: false,
        dom: '<"dt-top-wrapper"lf>rt<"dt-bottom-wrapper"ip>',
        language: {
            search: "",
            searchPlaceholder: "Cari laporan...",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "",
            infoFiltered: "(filter dari _MAX_)",
            zeroRecords: `<div class="flex flex-col items-center justify-center py-4 gap-3">
                <svg width="42" height="42" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <span class="text-[#888] font-medium text-[0.95rem]">Belum ada laporan konseling.</span>
            </div>`,
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>',
                previous: '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>'
            }
        },
        columnDefs: [
            { orderable: false, targets: [0, 5] },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 5 }
        ]
    });
});
</script>
@endpush
