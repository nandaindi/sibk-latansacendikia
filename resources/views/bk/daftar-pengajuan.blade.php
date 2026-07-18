@extends('layouts.bk')

@section('title', 'Daftar Pengajuan Konseling – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Daftar Pengajuan Konseling</h2>
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

    <!-- Tables -->
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-5">

        <!-- Online Tab -->
        <div id="contentOnline">
            <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <table id="pengajuanOnlineTable" class="w-full text-left border-collapse display">
                    <thead>
                        <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                            <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama Siswa</th>
                            <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-center w-[1%] whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2f1]">
                        @php $onlineNo = 1; @endphp
                        @foreach($pengajuans as $item)
                            @if($item->jenis == 'online')
                            <tr class="hover:bg-[#fcfdfd] transition-colors">
                                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $onlineNo++ }}</td>
                                <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $item->user->name ?? 'User Unknown' }}</td>
                                <td class="hidden md:table-cell p-4 text-[0.85rem] text-[#888]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('bk.validasi-pengajuan', ['id' => $item->id]) }}" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors inline-flex" title="Detail">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offline Tab (hidden by default) -->
        <div id="contentOffline" class="hidden">
            <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <table id="pengajuanOfflineTable" class="w-full text-left border-collapse display">
                    <thead>
                        <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                            <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama Siswa</th>
                            <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-center w-[1%] whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2f1]">
                        @php $offlineNo = 1; @endphp
                        @foreach($pengajuans as $item)
                            @if($item->jenis == 'offline')
                            <tr class="hover:bg-[#fcfdfd] transition-colors">
                                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $offlineNo++ }}</td>
                                <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $item->user->name ?? 'User Unknown' }}</td>
                                <td class="hidden md:table-cell p-4 text-[0.85rem] text-[#888]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('bk.validasi-pengajuan', ['id' => $item->id]) }}" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors inline-flex" title="Detail">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
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
        language: {
            searchPlaceholder: "Cari...",
            zeroRecords: `<div class="flex flex-col items-center justify-center py-4 gap-3">
                <svg width="42" height="42" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <span class="text-[#888] font-medium text-[0.95rem]">Belum ada pengajuan.</span>
            </div>`
        },
        columnDefs: [{ orderable: false, targets: [0, -1] }, { className: 'dt-center', targets: -1 }, { responsivePriority: 1, targets: 1 }],
    };
    $('#pengajuanOnlineTable').DataTable(dtConfig);
    $('#pengajuanOfflineTable').DataTable(dtConfig);
});

function switchTab(tab) {
    const online  = document.getElementById('contentOnline');
    const offline = document.getElementById('contentOffline');
    const btnOn   = document.getElementById('tabOnline');
    const btnOff  = document.getElementById('tabOffline');

    if (tab === 'online') {
        online.classList.remove('hidden');
        offline.classList.add('hidden');
        btnOn.classList.add('border-white','text-white');
        btnOn.classList.remove('text-white/70','border-transparent');
        btnOff.classList.add('text-white/70','border-transparent');
        btnOff.classList.remove('border-white','text-white');
    } else {
        offline.classList.remove('hidden');
        online.classList.add('hidden');
        btnOff.classList.add('border-white','text-white');
        btnOff.classList.remove('text-white/70','border-transparent');
        btnOn.classList.add('text-white/70','border-transparent');
        btnOn.classList.remove('border-white','text-white');
    }
    // Recalculate DataTables width after tab switch
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
}
</script>
@endpush
