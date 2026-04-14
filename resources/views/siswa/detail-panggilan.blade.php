@extends('layouts.siswa')

@section('title', 'Detail Pelanggaran – BK')

@section('content')
<!-- Toast Notifikasi (jika ada simulasi terima panggilan) -->
<div id="toast" class="fixed top-[30px] left-1/2 -translate-x-1/2 -translate-y-[100px] bg-[#1a9488] text-white px-7 py-4 rounded-[30px] text-[1rem] font-bold shadow-[0_10px_30px_rgba(26,148,136,0.4)] z-[999] flex items-center gap-3 transition-transform duration-500 min-[0px]:duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] whitespace-nowrap [&.show]:translate-y-0">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
    </svg>
    <span>Konfirmasi Diterima</span>
</div>

<!-- Content -->
<main class="w-full px-5 py-8 md:py-12 flex-1 flex flex-col items-end">
    <!-- Main Info Box -->
    <div class="bg-white rounded-[32px] border-[2px] border-[#0F766E] p-6 md:p-10 w-full mb-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] text-left">
        <h1 class="text-[1.3rem] md:text-[1.6rem] font-extrabold text-[#1a1a1a] mb-2">Panggilan Pelanggaran</h1>
        <div class="text-[0.95rem] text-[#777] font-medium mb-4">
            Topik: <span class="text-[#0F766E]">{{ $panggilan->topik }}</span>
        </div>
        <div class="text-[0.95rem] text-[#777] font-medium mb-6">
            Jadwal: {{ \Carbon\Carbon::parse($panggilan->tanggal)->translatedFormat('l, d M Y') }} pkl {{ \Carbon\Carbon::parse($panggilan->waktu)->format('H:i') }}
        </div>
        
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-bold text-[#1a1a1a] uppercase tracking-wider mb-2">Catatan Pemanggilan:</h3>
                <p class="text-[1.05rem] md:text-[1.15rem] text-[#222] leading-[1.7] md:leading-[1.8] whitespace-pre-line">
                    {{ $panggilan->catatan_pemanggilan ?? 'Harap hadir tepat waktu sesuai jadwal yang ditentukan.' }}
                </p>
            </div>

            @if($panggilan->status == 'selesai')
            <div class="pt-6 border-t border-[#eee]">
                <h3 class="text-sm font-bold text-[#1a1a1a] uppercase tracking-wider mb-2 text-[#0F766E]">Hasil Pertemuan:</h3>
                <p class="text-[1.05rem] md:text-[1.15rem] text-[#333] leading-[1.7] md:leading-[1.8] whitespace-pre-line italic">
                    {{ $panggilan->catatan_hasil ?? 'Sesi telah selesai dilaksanakan.' }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Area -->
    <div class="flex w-full justify-end">
        @if($panggilan->status == 'menunggu')
        <form id="formTerima" method="POST" action="{{ route('siswa.terima-panggilan') }}" class="m-0">
            @csrf
            <input type="hidden" name="pelanggaran_id" value="{{ $panggilan->id }}">
            <button type="submit" onclick="this.innerHTML='Memproses...'; this.classList.add('opacity-80', 'cursor-not-allowed')" class="bg-[#0F766E] hover:bg-[#0b534d] text-white font-bold py-3.5 px-10 rounded-full text-lg transition-transform hover:-translate-y-0.5 active:scale-95 shadow-[0_6px_20px_rgba(15,118,110,0.3)]">
                SAYA MENGERTI
            </button>
        </form>
        @else
        <a href="{{ route('siswa.panggilan') }}" class="bg-[#777] hover:bg-[#555] text-white font-bold py-3.5 px-10 rounded-full text-lg transition-transform hover:-translate-y-0.5 active:scale-95 shadow-[0_6px_20px_rgba(0,0,0,0.1)] no-underline">
            KEMBALI
        </a>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
    @if(session('terima_success'))
    window.addEventListener('load', () => {
        const toast = document.getElementById('toast');
        if(toast) {
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3500);
        }
    });
    @endif
</script>
@endpush
