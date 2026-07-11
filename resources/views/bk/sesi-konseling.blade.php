@extends('layouts.bk')

@section('title', 'Sesi Konseling – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Sesi Konseling</h2>
    </div>

    <!-- Tabs -->
    <div class="bg-[#2a9488] flex overflow-x-auto">
        <button id="tabOnline" onclick="switchTab('online')"
                class="flex-1 md:flex-none min-h-12 px-8 py-3.5 text-white font-bold text-[0.95rem] border-b-[3px] border-white transition-all whitespace-nowrap">
            Online
        </button>
        <button id="tabOffline" onclick="switchTab('offline')"
                class="flex-1 md:flex-none min-h-12 px-8 py-3.5 text-white/70 font-bold text-[0.95rem] border-b-[3px] border-transparent transition-all hover:text-white whitespace-nowrap">
            Offline
        </button>
    </div>

    <!-- Tables -->
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-5">

        <!-- Online Tab -->
        <div id="contentOnline">
            <div class="md:hidden space-y-3">
                @php $onlineMobileNo = 1; @endphp
                @foreach($sesis as $item)
                    @if($item->jenis == 'online')
                    <article class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.03)] p-4">
                        <div class="min-w-0">
                            <p class="text-[0.75rem] font-bold uppercase tracking-[0.12em] text-[#1a9488]">Sesi {{ $onlineMobileNo++ }}</p>
                            <h3 class="mt-1 text-[1rem] font-bold text-[#1a1a1a] leading-snug break-words">{{ $item->user->name ?? 'User Unknown' }}</h3>
                            <p class="mt-1 text-[0.85rem] text-[#64748b]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                        <a href="{{ route('bk.detail-sesi', ['id' => $item->id]) }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#e0f5f3] px-4 py-3 text-[0.9rem] font-bold text-[#1a9488] transition-colors hover:bg-[#c7ece8]">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            Detail Sesi
                        </a>
                    </article>
                    @endif
                @endforeach
            </div>

            <div class="hidden md:block bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <table id="sesiOnlineTable" class="w-full text-left border-collapse display">
                    <thead>
                        <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                            <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama Siswa</th>
                            <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2f1]">
                        @php $onlineNo = 1; @endphp
                        @foreach($sesis as $item)
                            @if($item->jenis == 'online')
                            <tr class="hover:bg-[#fcfdfd] transition-colors">
                                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $onlineNo++ }}</td>
                                <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $item->user->name ?? 'User Unknown' }}</td>
                                <td class="hidden md:table-cell p-4 text-[0.85rem] text-[#888]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('bk.detail-sesi', ['id' => $item->id]) }}" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors inline-flex" title="Detail">
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
            <div class="md:hidden space-y-3">
                @php $offlineMobileNo = 1; @endphp
                @foreach($sesis as $item)
                    @if($item->jenis == 'offline')
                    <article class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.03)] p-4">
                        <div class="min-w-0">
                            <p class="text-[0.75rem] font-bold uppercase tracking-[0.12em] text-[#1a9488]">Sesi {{ $offlineMobileNo++ }}</p>
                            <h3 class="mt-1 text-[1rem] font-bold text-[#1a1a1a] leading-snug break-words">{{ $item->user->name ?? 'User Unknown' }}</h3>
                            <p class="mt-1 text-[0.85rem] text-[#64748b]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="mt-4 grid grid-cols-1 gap-2">
                            <form action="{{ route('bk.konseling-offline.mulai', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full min-h-11 rounded-xl bg-[#1a9488] px-4 py-3 text-[0.9rem] font-bold text-white transition-all hover:brightness-110 border-none cursor-pointer">
                                    Mulai Sesi
                                </button>
                            </form>
                            <form id="form-tidak-hadir-mobile-{{ $item->id }}" action="{{ route('bk.konseling-offline.tidak-hadir', $item->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="confirmTidakHadir({{ $item->id }}, true)" class="w-full min-h-11 rounded-xl bg-red-500 px-4 py-3 text-[0.9rem] font-bold text-white transition-all hover:bg-[#ff4d4d] border-none cursor-pointer">
                                    Tidak Hadir
                                </button>
                            </form>
                        </div>
                    </article>
                    @endif
                @endforeach
            </div>

            <div class="hidden md:block bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <table id="sesiOfflineTable" class="w-full text-left border-collapse display">
                    <thead>
                        <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                            <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama Siswa</th>
                            <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf2f1]">
                        @php $offlineNo = 1; @endphp
                        @foreach($sesis as $item)
                            @if($item->jenis == 'offline')
                            <tr class="hover:bg-[#fcfdfd] transition-colors">
                                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $offlineNo++ }}</td>
                                <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $item->user->name ?? 'User Unknown' }}</td>
                                <td class="hidden md:table-cell p-4 text-[0.85rem] text-[#888]">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('bk.konseling-offline.mulai', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="min-h-11 px-4 py-2 bg-[#1a9488] text-white text-[0.8rem] font-bold rounded-xl hover:brightness-110 transition-all border-none cursor-pointer">
                                                Mulai
                                            </button>
                                        </form>
                                        <form id="form-tidak-hadir-{{ $item->id }}" action="{{ route('bk.konseling-offline.tidak-hadir', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmTidakHadir({{ $item->id }})" class="min-h-11 px-3 py-2 bg-red-500 text-white text-[0.8rem] font-bold rounded-xl hover:bg-[#ff4d4d] transition-all border-none cursor-pointer">
                                                Tidak Hadir
                                            </button>
                                        </form>
                                    </div>
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
    if (!window.matchMedia('(min-width: 768px)').matches) {
        return;
    }

    var dtConfig = {
        language: {
            searchPlaceholder: "Cari...",
            zeroRecords: `<div class="flex flex-col items-center justify-center py-4 gap-3">
                <svg width="42" height="42" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="M3 9h18"/></svg>
                <span class="text-[#888] font-medium text-[0.95rem]">Belum ada sesi konseling.</span>
            </div>`
        },
        columnDefs: [{ orderable: false, targets: [0, 3] }, { responsivePriority: 1, targets: 1 }],
    };
    $('#sesiOnlineTable').DataTable(dtConfig);
    $('#sesiOfflineTable').DataTable(dtConfig);
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
    if (window.matchMedia('(min-width: 768px)').matches && $.fn.dataTable.isDataTable('#sesiOnlineTable')) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
    }
}

function confirmTidakHadir(id, mobile = false) {
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Siswa ini benar-benar tidak hadir?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1a9488',
        cancelButtonColor: '#ff4d4d',
        confirmButtonText: 'Ya, Tidak Hadir',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const formId = mobile ? 'form-tidak-hadir-mobile-' + id : 'form-tidak-hadir-' + id;
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush
