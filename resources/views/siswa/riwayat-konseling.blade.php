@extends('layouts.siswa')

@section('title', 'Riwayat Laporan – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[90px] md:pb-10">

    <!-- Page Header -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.2rem] md:text-[1.4rem] font-extrabold text-white tracking-wide">Riwayat Laporan</h2>
    </div>

    <!-- Tabs -->
    <div class="bg-[#2a9488] flex">
        <button id="tabOnline" onclick="switchTab('online')"
            class="flex-1 md:flex-none px-8 py-3.5 text-white font-bold text-[0.95rem] border-b-[3px] border-white transition-all">
            Online
        </button>
        <button id="tabOffline" onclick="switchTab('offline')"
            class="flex-1 md:flex-none px-8 py-3.5 text-white/70 font-bold text-[0.95rem] border-b-[3px] border-transparent transition-all hover:text-white">
            Offline
        </button>
    </div>

    <!-- Tables Area -->
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-5">

        <!-- Online Tab Content -->
        <div id="contentOnline">
            <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <table id="riwayatOnlineTable" class="w-full text-left border-collapse display">
                    <thead>
                        <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                            <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Keterangan</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2f1]">
                        @php $onlineNo = 1; @endphp
                        @foreach($riwayats as $item)
                            @if($item->jenis == 'online')
                            <tr class="hover:bg-[#fcfdfd] transition-colors cursor-pointer group" data-url="{{ route('siswa.detail-laporan', $item->id) }}">
                                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $onlineNo++ }}</td>
                                <td class="p-4 text-[0.95rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                                <td class="hidden md:table-cell p-4 text-[0.9rem] text-[#555]">Laporan Konseling Online</td>
                                <td class="p-4 text-right">
                                    <span class="text-[#1a9488] transition-transform group-hover:translate-x-1 inline-block">
                                        <svg width="20" height="20" fill="none" class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                    </span>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offline Tab Content -->
        <div id="contentOffline" class="hidden">
            <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <table id="riwayatOfflineTable" class="w-full text-left border-collapse display">
                    <thead>
                        <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                            <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Keterangan</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2f1]">
                        @php $offlineNo = 1; @endphp
                        @foreach($riwayats as $item)
                            @if($item->jenis == 'offline')
                            <tr class="hover:bg-[#fcfdfd] transition-colors cursor-pointer group" data-url="{{ route('siswa.detail-laporan', $item->id) }}">
                                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $offlineNo++ }}</td>
                                <td class="p-4 text-[0.95rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                                <td class="hidden md:table-cell p-4 text-[0.9rem] text-[#555]">Laporan Konseling Offline</td>
                                <td class="p-4 text-right">
                                    <span class="text-[#1a9488] transition-transform group-hover:translate-x-1 inline-block">
                                        <svg width="20" height="20" fill="none" class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                    </span>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var dtConfig = {
        responsive: true,
        scrollX: false,
        autoWidth: false,
        dom: '<"dt-top-wrapper"lf>rt<"dt-bottom-wrapper"ip>',
        language: {
            search: "",
            searchPlaceholder: "Cari riwayat...",
            lengthMenu: "Tampilkan _MENU_ entri",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "",
            infoFiltered: "(filter dari _MAX_)",
            zeroRecords: `<div class="flex flex-col items-center justify-center py-4 gap-3">
                <svg width="42" height="42" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span class="text-[#888] font-medium text-[0.95rem]">Belum ada riwayat konseling.</span>
            </div>`,
            paginate: {
                first: "Awal", last: "Akhir",
                next: '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>',
                previous: '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>'
            }
        },
        columnDefs: [{ orderable: false, targets: [0, 3] }, { responsivePriority: 1, targets: 1 }]
    };
    $('#riwayatOnlineTable').DataTable(dtConfig);
    $('#riwayatOfflineTable').DataTable(dtConfig);

    // Smart Row Click: Redirects to detail page UNLESS the user clicked the DataTables '+' expand button
    $('table.display tbody').on('click', 'tr', function(e) {
        if ($(e.target).closest('td.dtr-control').length) {
            return; // Do nothing, let DataTables expand/collapse the row
        }
        var url = $(this).data('url');
        if (url) {
            window.location.href = url;
        }
    });
});

function switchTab(tab) {
    const online  = document.getElementById('contentOnline');
    const offline = document.getElementById('contentOffline');
    const tabOnlineBtn  = document.getElementById('tabOnline');
    const tabOfflineBtn = document.getElementById('tabOffline');

    if (tab === 'online') {
        online.classList.remove('hidden');
        offline.classList.add('hidden');
        tabOnlineBtn.classList.add('border-white','text-white');
        tabOnlineBtn.classList.remove('text-white/70','border-transparent');
        tabOfflineBtn.classList.add('text-white/70','border-transparent');
        tabOfflineBtn.classList.remove('border-white','text-white');
    } else {
        offline.classList.remove('hidden');
        online.classList.add('hidden');
        tabOfflineBtn.classList.add('border-white','text-white');
        tabOfflineBtn.classList.remove('text-white/70','border-transparent');
        tabOnlineBtn.classList.add('text-white/70','border-transparent');
        tabOnlineBtn.classList.remove('border-white','text-white');
    }
    // Recalculate DataTables width after tab switch
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
}
</script>
@endpush
