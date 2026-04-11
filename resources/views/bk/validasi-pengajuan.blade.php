@extends('layouts.bk')

@section('title', 'Validasi Pengajuan – BK')

@section('content')
<main class="w-full px-4 md:px-6 flex-1 pb-[100px] md:pb-10 flex items-center">

    <div class="w-full flex flex-col lg:flex-row gap-10 items-center justify-center py-8">

        <!-- LEFT: Info Card -->
        <div class="flex-1 w-full">
            <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col gap-4">
                    <div class="flex items-start gap-2">
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[80px] shrink-0">Nama</span>
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                        <span class="text-[0.95rem] text-[#333]">{{ $konseling->user->name ?? '-' }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[80px] shrink-0">Kelas</span>
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                        <span class="text-[0.95rem] text-[#333]">{{ $konseling->user->kelas ?? '-' }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[80px] shrink-0">Jenis</span>
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                        <span class="text-[0.95rem] text-[#333] capitalize">{{ $konseling->jenis }}</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a] w-[80px] shrink-0">Tanggal</span>
                        <span class="text-[0.95rem] font-bold text-[#1a1a1a]">:</span>
                        <span class="text-[0.95rem] text-[#333]">{{ \Carbon\Carbon::parse($konseling->tanggal)->format('l, d F Y') }}</span>
                    </div>

                    {{-- Form Tolak --}}
                    <div class="mt-2 border-t border-[#edf2f1] pt-4">
                        <label class="text-[0.9rem] font-bold text-[#b94040] mb-2 block">Alasan Penolakan <span class="font-normal text-[#888]">(isi jika ingin menolak)</span></label>
                        <textarea id="alasanTolak" rows="3"
                            class="w-full border border-[#e5e7eb] rounded-xl px-4 py-3 text-[0.9rem] text-[#333] resize-none focus:outline-none focus:border-[#1a9488] transition-colors"
                            placeholder="Contoh: Jadwal bentrok, harap mengajukan ulang pada..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Illustration + Buttons -->
        <div class="flex flex-col items-center gap-5 lg:mt-4">
            <div class="w-40 h-40 md:w-52 md:h-52">
                <img src="{{ asset('img/Robot hand showing heart gesture.svg') }}" alt="Robot heart gesture" class="w-full h-full object-contain">
            </div>

            <!-- Setuju Button -->
            <a href="{{ route('bk.setujui-pengajuan', ['id' => $konseling->id]) }}"
               class="w-44 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold text-center shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all no-underline inline-block">
                Setuju
            </a>

            <!-- Tolak Button (submit form) -->
            <form id="formTolak" method="POST" action="{{ route('bk.tolak-pengajuan') }}" class="w-full flex justify-center">
                @csrf
                <input type="hidden" name="konseling_id" value="{{ $konseling->id }}">
                <input type="hidden" name="alasan_tolak" id="hiddenAlasan">
                <button type="button" onclick="submitTolak()"
                    class="w-44 py-3.5 bg-[#b94040] text-white rounded-full text-[1rem] font-bold text-center shadow-[0_4px_12px_rgba(185,64,64,0.3)] hover:brightness-110 hover:-translate-y-0.5 transition-all">
                    Tolak
                </button>
            </form>
        </div>

    </div>

</main>
@endsection

@push('scripts')
<script>
function submitTolak() {
    const alasan = document.getElementById('alasanTolak').value.trim();
    if (!alasan) {
        Swal.fire({
            icon: 'error',
            title: 'Alasan Kosong',
            text: 'Harap isi alasan penolakan terlebih dahulu.',
            confirmButtonColor: '#1a9488'
        });
        return;
    }
    document.getElementById('hiddenAlasan').value = alasan;
    document.getElementById('formTolak').submit();
}
</script>
@endpush
