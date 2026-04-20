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
        
        <h2 class="text-[1.4rem] md:text-[1.8rem] font-extrabold text-[#1a9488] mb-1">Pengajuan Online</h2>
        <p class="text-[0.95rem] md:text-[1.05rem] text-[#1a1a1a] mb-8 md:mb-10">Silahkan masukkan data yang diperlukan</p>

        <!-- Robot illustration -->
        <img src="{{ asset('img/gpt robot with speech bubble.svg') }}" alt="Robot" class="static transform-none w-[220px] mx-auto block mb-8 md:absolute md:right-[120px] lg:right-[200px] md:top-1/2 md:-translate-y-1/2 md:w-[380px] md:mb-0 md:opacity-95 z-10 drop-shadow-sm pointer-events-none animate-robot-float animate-robot-wave">

        <!-- Ensure form uses left side space in desktop view -->
        <div class="w-full md:w-[55%] lg:w-[48%] z-20 flex flex-col space-y-6 md:pt-4">
            <form id="formPengajuan" class="flex flex-col gap-6" method="POST"
                  action="{{ route('siswa.pengajuan-online.store') }}">
                @csrf

                <!-- Date Time -->
                <div class="group">
                    <div class="border-[2px] border-[#1a9488]/40 rounded-2xl p-5 md:p-6 transition-all duration-300 bg-white hover:border-[#1a9488] focus-within:border-[#1a9488] focus-within:shadow-[0_8px_30px_rgba(26,148,136,0.1)]">
                        <label class="text-[#888] font-extrabold text-[0.85rem] uppercase tracking-widest mb-2 block">Jadwal Konseling</label>
                        <div class="relative flex items-center">
                            <input type="datetime-local" name="jadwal" id="jadwalInput"
                                   value="{{ old('jadwal') }}"
                                   required
                                   class="w-full border-none outline-none font-sans text-[1.1rem] font-bold text-[#1a1a1a] bg-transparent cursor-pointer appearance-none">
                            <div class="absolute right-0 pointer-events-none text-[#1a9488]">
                                <!-- <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Problem Type Select -->
                <div class="relative group">
                    <div class="border-[2px] border-[#1a9488]/40 rounded-2xl p-5 md:p-6 transition-all duration-300 bg-white hover:border-[#1a9488] focus-within:border-[#1a9488] focus-within:shadow-[0_8px_30px_rgba(26,148,136,0.1)] cursor-pointer" onclick="toggleCustomSelect()">
                        <label class="text-[#888] font-extrabold text-[0.85rem] uppercase tracking-widest mb-2 block pointer-events-none">Tipe Masalah</label>
                        <div class="flex items-center justify-between">
                            <div id="selectedLabel" class="text-[1.1rem] font-bold text-[#aaa]">Pilih masalah...</div>
                            <div class="text-[#1a9488] transition-transform duration-300" id="selectArrow">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                        <input type="hidden" name="problem_type" id="problemTypeInput" required>
                    </div>

                    <!-- Dropdown Options -->
                    <div id="customOptions" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-[0_15px_45px_rgba(0,0,0,0.12)] border-[1px] border-[#eee] overflow-hidden opacity-0 invisible translate-y-4 transition-all duration-300 z-[100]">
                        <div class="py-2">
                            <div class="px-5 py-3.5 hover:bg-[#f0f9f8] cursor-pointer transition-colors flex items-center gap-3" onclick="selectOption('akademik', 'Masalah Akademik')">
                                <div class="w-2 h-2 rounded-full bg-[#1a9488]"></div>
                                <span class="font-bold text-[#1a1a1a]">Masalah Akademik</span>
                            </div>
                            <div class="px-5 py-3.5 hover:bg-[#f0f9f8] cursor-pointer transition-colors flex items-center gap-3" onclick="selectOption('sosial', 'Masalah Sosial')">
                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                <span class="font-bold text-[#1a1a1a]">Masalah Sosial</span>
                            </div>
                            <div class="px-5 py-3.5 hover:bg-[#f0f9f8] cursor-pointer transition-colors flex items-center gap-3" onclick="selectOption('keluarga', 'Masalah Keluarga')">
                                <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                <span class="font-bold text-[#1a1a1a]">Masalah Keluarga</span>
                            </div>
                            <div class="px-5 py-3.5 hover:bg-[#f0f9f8] cursor-pointer transition-colors flex items-center gap-3" onclick="selectOption('karir', 'Perencanaan Karir')">
                                <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                                <span class="font-bold text-[#1a1a1a]">Perencanaan Karir</span>
                            </div>
                            <div class="px-5 py-3.5 hover:bg-[#f0f9f8] cursor-pointer transition-colors flex items-center gap-3" onclick="selectOption('lainnya', 'Lainnya')">
                                <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                <span class="font-bold text-[#1a1a1a]">Lainnya</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Note -->
                <div class="border-[2px] border-[#1a9488]/40 rounded-2xl p-5 md:p-6 transition-all duration-300 bg-white hover:border-[#1a9488] focus-within:border-[#1a9488] focus-within:shadow-[0_8px_30_rgba(26,148,136,0.1)]">
                    <label class="text-[#888] font-extrabold text-[0.85rem] uppercase tracking-widest mb-2 block">Catatan Pendukung</label>
                    <textarea name="note" required placeholder="Tuliskan sedikit gambaran masalah Anda..."
                              class="w-full border-none outline-none font-sans text-[1.1rem] font-bold text-[#1a1a1a] bg-transparent resize-none min-h-[110px] placeholder-[#ccc] transition-all">{{ old('note') }}</textarea>
                </div>
            </form>
            
            <div class="mt-4 flex justify-end">
                <button class="px-10 py-4 bg-[#1a9488] text-white border-none rounded-full text-[1.1rem] font-extrabold shadow-[0_10px_25px_rgba(26,148,136,0.35)] cursor-pointer transition-all duration-300 hover:brightness-105 hover:-translate-y-1 active:scale-95 flex-shrink-0" onclick="submitForm()">
                    Kirim Pengajuan
                </button>
            </div>
        </div>
        
    </div>
</main>
@endsection

@push('scripts')
<script>
    function toggleCustomSelect() {
        const options = document.getElementById('customOptions');
        const arrow = document.getElementById('selectArrow');
        const isHidden = options.classList.contains('invisible');
        
        if (isHidden) {
            options.classList.remove('invisible', 'opacity-0', 'translate-y-4');
            options.classList.add('visible', 'opacity-100', 'translate-y-0');
            arrow.classList.add('rotate-180');
        } else {
            options.classList.add('invisible', 'opacity-0', 'translate-y-4');
            options.classList.remove('visible', 'opacity-100', 'translate-y-0');
            arrow.classList.remove('rotate-180');
        }
    }

    function selectOption(val, label) {
        document.getElementById('problemTypeInput').value = val;
        const labelEl = document.getElementById('selectedLabel');
        labelEl.innerText = label;
        labelEl.classList.remove('text-[#aaa]');
        labelEl.classList.add('text-[#1a1a1a]');
        toggleCustomSelect();
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.group')) {
            const options = document.getElementById('customOptions');
            const arrow = document.getElementById('selectArrow');
            options.classList.add('invisible', 'opacity-0', 'translate-y-4');
            arrow.classList.remove('rotate-180');
        }
    });

    function submitForm() {
        const jadwal = document.querySelector('[name="jadwal"]').value;
        const problem = document.getElementById('problemTypeInput').value;
        const note = document.querySelector('[name="note"]').value;

        if (!jadwal || !problem || !note.trim()) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Mohon isi semua data dengan lengkap.',
                confirmButtonColor: '#1a9488'
            });
            return;
        }

        const modal = document.getElementById('modalSukses');
        if(modal) modal.classList.add('show');

        setTimeout(() => {
            document.getElementById('formPengajuan').submit();
        }, 1800);
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
