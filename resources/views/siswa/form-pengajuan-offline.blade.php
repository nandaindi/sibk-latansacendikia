@extends('layouts.siswa')

@section('title', isset($type) && $type === 'online' ? 'Pengajuan Online – BK' : 'Pengajuan Offline – BK')


@section('content')
<!-- Modal Sukses -->
<div id="modalSukses" class="fixed inset-0 bg-black/50 z-[200] items-center justify-center p-6 hidden [&.show]:flex">
    <div class="bg-white rounded-[24px] px-8 py-10 w-full max-w-[400px] flex flex-col items-center gap-4 text-center shadow-[0_20px_40px_rgba(0,0,0,0.15)] animate-[popIn_0.35s_cubic-bezier(0.34,1.56,0.64,1)]">
        <style>
            @keyframes popIn {
                from { transform: scale(0.7); opacity: 0; }
                to   { transform: scale(1);   opacity: 1; }
            }
        </style>
        <svg class="w-[110px] h-[110px]" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="60" cy="112" rx="28" ry="6" fill="#e0ede0" opacity="0.5"/>
            <!-- Bubble body -->
            <path d="M10 15 Q10 5 20 5 H100 Q110 5 110 15 V75 Q110 85 100 85 H68 L55 105 L42 85 H20 Q10 85 10 75 Z"
                  fill="#d4f0d4" stroke="#a0d8a0" stroke-width="2"/>
            <!-- Checkmark -->
            <polyline points="35,50 52,67 85,35" stroke="#1a9488" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        </svg>
        <div class="text-[1.1rem] font-bold text-[#1a9488]">Pengajuan Konseling Berhasil</div>
    </div>
</div>

<!-- Content -->
<main class="w-full px-0 md:px-6 mt-0 md:mt-10 flex-1">
    <div class="bg-white md:rounded-[24px] p-6 md:p-12 flex flex-col relative overflow-hidden shadow-none md:shadow-[0_10px_40px_rgba(0,0,0,0.05)] w-full">
        
        <h2 class="text-[1.4rem] md:text-[1.8rem] font-extrabold text-[#1a9488] mb-1">Pengajuan Offline</h2>
        <p class="text-[0.95rem] md:text-[1.05rem] text-[#1a1a1a] mb-8 md:mb-10">Silahkan masukkan data yang diperlukan</p>

        <!-- Robot illustration -->
        <img src="{{ asset('img/gpt robot with speech bubble.svg') }}" alt="Robot" class="static transform-none w-[220px] mx-auto block mb-8 md:absolute md:right-[120px] lg:right-[200px] md:top-1/2 md:-translate-y-1/2 md:w-[380px] md:mb-0 md:opacity-95 z-10 drop-shadow-sm pointer-events-none">

        <!-- Ensure form uses left side space in desktop view -->
        <div class="w-full md:w-[55%] lg:w-[45%] z-20 flex flex-col space-y-6 md:pt-4">
            <form id="formPengajuan" class="flex flex-col gap-5" method="POST"
                  action="{{ route('siswa.pengajuan-offline.store') }}">
                @csrf

                <!-- Date Time -->
                <div class="border-[2.5px] border-[#1a9488] rounded-sm p-4 cursor-pointer transition-all duration-150 bg-white hover:bg-[#f8fdfc] focus-within:bg-[#f8fdfc]">
                    <div class="text-[#888] font-bold text-[1.1rem] mb-1">Date Time</div>
                    <input type="datetime-local" name="jadwal"
                           value="{{ old('jadwal') }}"
                           required
                           class="w-full border-none outline-none font-sans text-[1rem] font-bold text-[#1a1a1a] bg-transparent cursor-pointer">
                </div>

                <!-- Problem Type -->
                <div class="border-[2.5px] border-[#1a9488] rounded-sm p-4 cursor-pointer transition-all duration-150 bg-white hover:bg-[#f8fdfc] focus-within:bg-[#f8fdfc]">
                    <div class="text-[#888] font-bold text-[1.1rem] mb-1">Problem Type</div>
                    <select name="problem_type" required class="w-full border-none outline-none font-sans text-[1rem] font-bold text-[#1a1a1a] bg-transparent cursor-pointer appearance-none">
                        <option value="" disabled selected hidden>Pilih masalah...</option>
                        <option value="akademik">Masalah Akademik</option>
                        <option value="sosial">Masalah Sosial</option>
                        <option value="keluarga">Masalah Keluarga</option>
                        <option value="karir">Perencanaan Karir</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Note -->
                <div class="border-[2.5px] border-[#1a9488] rounded-sm p-4 cursor-pointer transition-all duration-150 bg-white hover:bg-[#f8fdfc] focus-within:bg-[#f8fdfc]">
                    <div class="text-[#888] font-bold text-[1.1rem] mb-1">Note</div>
                    <textarea name="note" required class="w-full border-none outline-none font-sans text-[1rem] font-bold text-[#1a1a1a] bg-transparent resize-none min-h-[90px] placeholder-[#ccc]">{{ old('note') }}</textarea>
                </div>
            </form>
            
            <div class="mt-4 flex justify-end">
                <button class="px-8 py-3.5 bg-[#1a9488] text-white border-none rounded-full text-[1.05rem] font-bold font-sans cursor-pointer transition-all duration-150 hover:bg-[#157a70] active:scale-95 shadow-md flex-shrink-0" onclick="submitForm()">
                    Pengajuan Offline
                </button>
            </div>
        </div>
        
    </div>
</main>
@endsection

@push('scripts')
<script>
    function submitForm() {
        const jadwal = document.querySelector('[name="jadwal"]').value;
        const problem = document.querySelector('[name="problem_type"]').value;
        const note = document.querySelector('[name="note"]').value;

        if (!jadwal || !problem || !note.trim()) {
            alert('Mohon isi semua data terlebih dahulu.');
            return;
        }

        const modal = document.getElementById('modalSukses');
        if(modal) modal.classList.add('show');

        setTimeout(() => {
            document.getElementById('formPengajuan').submit();
        }, 2000);
    }

    @if(session('pengajuan_sukses'))
    window.addEventListener('load', () => {
        const modal = document.getElementById('modalSukses');
        if(modal) {
            modal.classList.add('show');
            setTimeout(() => {
                modal.classList.remove('show');
            }, 2500);
        }
    });
    @endif
</script>
@endpush
