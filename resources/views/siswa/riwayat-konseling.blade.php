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

    <!-- List Area -->
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-3">

        <!-- Online Tab Content -->
        <div id="contentOnline" class="flex flex-col gap-3">
            @php $onlineCount = 0; @endphp
            @foreach($riwayats as $item)
                @if($item->jenis == 'online')
                @php $onlineCount++; @endphp
                <a href="{{ route('siswa.detail-laporan', $item->id) }}" class="bg-white border border-[#e5e7eb] rounded-2xl px-5 py-4 flex items-center gap-4 shadow-[0_2px_8px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_14px_rgba(26,148,136,0.1)] transition-all no-underline cursor-pointer group">
                    <div class="shrink-0 bg-[#e0f5f3] w-12 h-12 rounded-full flex items-center justify-center transition-colors group-hover:bg-[#1a9488]">
                        <svg width="24" height="24" fill="none" stroke="#1a9488" stroke-width="2" class="group-hover:stroke-white transition-colors" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[0.97rem] font-bold text-[#1a1a1a] truncate">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</div>
                        <div class="text-[0.82rem] text-[#888] mt-0.5 flex items-center gap-2">
                            Laporan Konseling Online
                        </div>
                    </div>
                    <div class="shrink-0 text-[#1a9488]">
                        <svg width="20" height="20" fill="none" class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </a>
                @endif
            @endforeach
            @if($onlineCount == 0)
            <div class="text-center py-8 text-gray-500 font-medium bg-white rounded-2xl border border-[#edf2f1]">Belum ada riwayat laporan konseling online.</div>
            @endif
        </div>

        <!-- Offline Tab Content -->
        <div id="contentOffline" class="flex-col gap-3 hidden">
            @php $offlineCount = 0; @endphp
            @foreach($riwayats as $item)
                @if($item->jenis == 'offline')
                @php $offlineCount++; @endphp
                <a href="{{ route('siswa.detail-laporan', $item->id) }}" class="bg-white border border-[#e5e7eb] rounded-2xl px-5 py-4 flex items-center gap-4 shadow-[0_2px_8px_rgba(0,0,0,0.04)] hover:shadow-[0_4px_14px_rgba(26,148,136,0.1)] transition-all no-underline cursor-pointer group">
                    <div class="shrink-0 bg-[#e0f5f3] w-12 h-12 rounded-full flex items-center justify-center transition-colors group-hover:bg-[#1a9488]">
                        <svg width="24" height="24" fill="none" stroke="#1a9488" stroke-width="2" class="group-hover:stroke-white transition-colors" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[0.97rem] font-bold text-[#1a1a1a] truncate">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</div>
                        <div class="text-[0.82rem] text-[#888] mt-0.5 flex items-center gap-2">
                            Laporan Konseling Offline
                        </div>
                    </div>
                    <div class="shrink-0 text-[#1a9488]">
                        <svg width="20" height="20" fill="none" class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </div>
                </a>
                @endif
            @endforeach
            @if($offlineCount == 0)
            <div class="text-center py-8 text-gray-500 font-medium bg-white rounded-2xl border border-[#edf2f1]">Belum ada riwayat laporan konseling offline.</div>
            @endif
        </div>

        <div class="mt-2">{{ $riwayats->links() }}</div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(tab) {
    const online  = document.getElementById('contentOnline');
    const offline = document.getElementById('contentOffline');
    const tabOnlineBtn  = document.getElementById('tabOnline');
    const tabOfflineBtn = document.getElementById('tabOffline');

    if (tab === 'online') {
        online.classList.remove('hidden'); online.classList.add('flex');
        offline.classList.add('hidden');   offline.classList.remove('flex');
        tabOnlineBtn.classList.add('border-white','text-white');
        tabOnlineBtn.classList.remove('text-white/70','border-transparent');
        tabOfflineBtn.classList.add('text-white/70','border-transparent');
        tabOfflineBtn.classList.remove('border-white','text-white');
    } else {
        offline.classList.remove('hidden'); offline.classList.add('flex');
        online.classList.add('hidden');     online.classList.remove('flex');
        tabOfflineBtn.classList.add('border-white','text-white');
        tabOfflineBtn.classList.remove('text-white/70','border-transparent');
        tabOnlineBtn.classList.add('text-white/70','border-transparent');
        tabOnlineBtn.classList.remove('border-white','text-white');
    }
}
</script>
@endpush
