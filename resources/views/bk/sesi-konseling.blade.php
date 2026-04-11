@extends('layouts.bk')

@section('title', 'Sesi Konseling – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Sesi Konseling</h2>
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

    <!-- List -->
    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-3">

        <!-- Online Tab -->
        <div id="contentOnline" class="flex flex-col gap-3">
            @php $onlineCount = 0; @endphp
            @foreach($sesis as $item)
                @if($item->jenis == 'online')
                @php $onlineCount++; @endphp
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-4 py-3.5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <!-- Robot avatar -->
                    <div class="w-12 h-12 shrink-0 border border-[#edf2f1] rounded-full overflow-hidden bg-[#e0f5f3]">
                        @if($item->user->avatar)
                            <img src="{{ Storage::url($item->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            @include('partials.bk.robot-avatar')
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-[0.95rem] text-[#1a1a1a]">{{ $item->user->name ?? 'User Unknown' }}</div>
                        <div class="text-[0.82rem] text-[#888] mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d F Y') }} <span class="text-[#1a9488] font-medium ml-2 uppercase text-xs px-2 py-0.5 bg-[#e0f5f3] rounded-full">{{ $item->jenis }}</span></div>
                    </div>
                    <a href="{{ route('bk.detail-sesi', ['id' => $item->id]) }}" class="text-[#1a9488] text-[0.9rem] font-semibold shrink-0 no-underline hover:text-[#12635a] transition-colors">
                        Detail
                    </a>
                </div>
                @endif
            @endforeach
            @if($onlineCount == 0)
                <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">Belum ada sesi konseling online.</div>
            @endif
        </div>

        <!-- Offline Tab (hidden by default) -->
        <div id="contentOffline" class="flex-col gap-3 hidden">
            @php $offlineCount = 0; @endphp
            @foreach($sesis as $item)
                @if($item->jenis == 'offline')
                @php $offlineCount++; @endphp
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-4 py-3.5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 shrink-0 border border-[#edf2f1] rounded-full overflow-hidden bg-[#e0f5f3]">
                        @if($item->user->avatar)
                            <img src="{{ Storage::url($item->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            @include('partials.bk.robot-avatar')
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-[0.95rem] text-[#1a1a1a]">{{ $item->user->name ?? 'User Unknown' }}</div>
                        <div class="text-[0.82rem] text-[#888] mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d F Y') }} <span class="text-[#1a9488] font-medium ml-2 uppercase text-xs px-2 py-0.5 bg-[#e0f5f3] rounded-full">{{ $item->jenis }}</span></div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <form action="{{ route('bk.konseling-offline.mulai', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[#1a9488] text-white text-[0.8rem] font-bold px-4 py-2 rounded-xl hover:brightness-110 transition-all">
                                Mulai
                            </button>
                        </form>
                        <form id="form-tidak-hadir-{{ $item->id }}" action="{{ route('bk.konseling-offline.tidak-hadir', $item->id) }}" method="POST">
                            @csrf
                            <button type="button" onclick="confirmTidakHadir({{ $item->id }})" class="bg-white border-2 border-[#ff4d4d] text-[#ff4d4d] text-[0.8rem] font-bold px-3 py-2 rounded-xl hover:bg-[#ff4d4d] hover:text-white transition-all">
                                Tidak Hadir
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            @endforeach
            @if($offlineCount == 0)
                <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">Belum ada sesi konseling offline.</div>
            @endif
        </div>

    </div>

    {{-- Pagination Links --}}
    <div class="mt-4 px-4 md:px-6">
        {{ $sesis->appends(request()->query())->links() }}
    </div>

</div>
@endsection

@push('scripts')
<script>
function switchTab(tab) {
    const online  = document.getElementById('contentOnline');
    const offline = document.getElementById('contentOffline');
    const btnOn   = document.getElementById('tabOnline');
    const btnOff  = document.getElementById('tabOffline');

    if (tab === 'online') {
        online.classList.remove('hidden'); online.classList.add('flex');
        offline.classList.add('hidden');   offline.classList.remove('flex');
        btnOn.classList.add('border-white','text-white');
        btnOn.classList.remove('text-white/70','border-transparent');
        btnOff.classList.add('text-white/70','border-transparent');
        btnOff.classList.remove('border-white','text-white');
    } else {
        offline.classList.remove('hidden'); offline.classList.add('flex');
        online.classList.add('hidden');     online.classList.remove('flex');
        btnOff.classList.add('border-white','text-white');
        btnOff.classList.remove('text-white/70','border-transparent');
        btnOn.classList.add('text-white/70','border-transparent');
        btnOn.classList.remove('border-white','text-white');
    }
}

function confirmTidakHadir(id) {
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Siswa ini benar-benar tidak hadir?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1a9488',
        cancelButtonColor: '#ff4d4d',
        confirmButtonText: 'Ya, Tidak Hadir',
        cancelButtonText: 'Batal',
        borderRadius: '24px'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-tidak-hadir-' + id).submit();
        }
    })
}

</script>
@endpush
