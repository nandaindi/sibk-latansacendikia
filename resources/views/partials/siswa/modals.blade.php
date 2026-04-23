<!-- Panggilan Aktif Modal Logic -->

@php
    $panggilanAktifModal = \App\Models\Konseling::where('user_id', auth()->id())
        ->where('status', 'dipanggil')
        ->latest()
        ->first();

    $activePelanggaranModal = \App\Models\Pelanggaran::where('user_id', auth()->id())
        ->where('status', 'menunggu')
        ->latest()
        ->first();
@endphp


<!-- Modal Terima Panggilan (Server-side Session) -->
@if(session('ada_panggilan'))
<div id="modalTerima" class="fixed inset-0 bg-black/45 z-[100] flex items-center justify-center p-4">
    <div class="relative w-full max-w-[420px] transform">
        <!-- Header Floating above -->
        <div class="flex items-center gap-3 mb-2 pl-2">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="#fcd34d" class="drop-shadow-md">
                <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
            </svg>
            <h3 class="text-xl font-extrabold text-white tracking-wide uppercase drop-shadow-md">PANGGILAN KONSELING</h3>
        </div>

        <!-- White Box -->
        <div class="bg-white rounded-[10px] border-[2px] border-[#0F766E] w-full p-5 md:p-6 relative shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
            <!-- Close Button (Red X) -->
            <button onclick="document.getElementById('modalTerima').remove()" class="absolute -top-4 -right-4 w-9 h-9 bg-white rounded-full border-[3px] border-red-600 flex items-center justify-center text-red-600 hover:bg-red-50 transition-colors focus:outline-none z-10">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="stroke-current stroke-[3]" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Content Details -->
            <div class="flex flex-col gap-1.5 text-[15px] md:text-base text-black mb-6 mt-1">
                <div class="flex items-start">
                    <span class="w-[85px] font-bold shrink-0">Jadwal</span>
                    <span class="font-bold">: {{ \Carbon\Carbon::parse($panggilanAktifModal->tanggal)->translatedFormat('l, d F Y') }} pkl {{ \Carbon\Carbon::parse($panggilanAktifModal->waktu)->format('H:i') }}</span>
                </div>
                <div class="flex items-start">
                    <span class="w-[85px] font-bold shrink-0">Tempat</span>
                    <span class="font-bold">: Ruang BK</span>
                </div>
                <div class="flex items-start mt-2">
                    <span class="w-[85px] font-bold shrink-0">Catatan</span>
                    <span class="font-bold text-[#555] line-clamp-2">: {{ $panggilanAktifModal->catatan_bk ?? 'Evaluasi rutin bersama Guru BK.' }}</span>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-end justify-between mt-4">
                <a href="{{ route('siswa.detail-panggilan', $panggilanAktifModal->id) }}" class="text-[13px] text-[#0F766E] hover:text-[#0b534d] font-medium transition-colors mb-1">Lihat Detail</a>
                
                <form method="POST" action="{{ route('siswa.terima-panggilan') }}" class="m-0">
                    @csrf
                    <input type="hidden" name="konseling_id" value="{{ $panggilanAktifModal->id }}">
                    <button type="submit" onclick="this.innerHTML='Memproses...'; this.classList.add('opacity-80', 'cursor-not-allowed')" class="bg-[#0F766E] hover:bg-[#0b534d] text-white font-bold py-2.5 px-6 rounded-full text-sm transition-colors shadow-md transform hover:-translate-y-0.5 active:scale-95 transition-all">
                        TERIMA
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

<!-- Modal Terima Panggilan Pelanggaran (Server-side Session) -->
@if(session('ada_panggilan_pelanggaran'))
<div id="modalTerimaPelanggaran" class="fixed inset-0 bg-black/45 z-[100] flex items-center justify-center p-4">
    <div class="relative w-full max-w-[420px] transform">
        <!-- Header Floating above -->
        <div class="flex items-center gap-3 mb-2 pl-2">
            <div class="p-1 px-3 bg-red-600 rounded-full shadow-lg">
                <h3 class="text-sm font-black text-white tracking-widest uppercase">URGENT CALL</h3>
            </div>
        </div>

        <!-- White Box -->
        <div class="bg-white rounded-[20px] border-[3px] border-red-600 w-full p-5 md:p-7 relative shadow-[0_20px_50px_rgba(0,0,0,0.4)]">
            <!-- Close Button (Red X) -->
            <button onclick="document.getElementById('modalTerimaPelanggaran').remove()" class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full border-[3px] border-red-600 flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all focus:outline-none z-10 shadow-md">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="stroke-current stroke-[4]" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <!-- Title -->
            <div class="text-center mb-6">
                <div class="text-[1.2rem] font-black text-red-700 uppercase tracking-tight">Panggilan Pelanggaran</div>
                <div class="w-12 h-1 bg-red-600 mx-auto mt-2 rounded-full"></div>
            </div>

            <!-- Content Details -->
            <div class="space-y-4 text-black mb-8">
                <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                    <div class="text-[0.7rem] font-black text-red-500 uppercase tracking-widest mb-1">Topik Pemanggilan:</div>
                    <div class="text-[1.1rem] font-black text-red-800 uppercase leading-snug">{{ $activePelanggaranModal->topik ?? 'PELANGGARAN TATA TERTIB' }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <div class="text-[0.65rem] font-bold text-gray-500 uppercase tracking-wider mb-0.5">Hari/Tanggal</div>
                        <div class="text-[0.85rem] font-extrabold text-gray-800">{{ \Carbon\Carbon::parse($activePelanggaranModal->tanggal)->translatedFormat('l, d M') }}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <div class="text-[0.65rem] font-bold text-gray-500 uppercase tracking-wider mb-0.5">Waktu</div>
                        <div class="text-[0.85rem] font-extrabold text-gray-800">PKL {{ \Carbon\Carbon::parse($activePelanggaranModal->waktu)->format('H:i') }} WIB</div>
                    </div>
                </div>

                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <div class="text-[0.65rem] font-bold text-gray-500 uppercase tracking-wider mb-0.5">Tempat</div>
                    <div class="text-[0.85rem] font-extrabold text-gray-800">Ruang Bimbingan Konseling</div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex flex-col gap-3">
                <form method="POST" action="{{ route('siswa.notifications.mark-as-read') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl text-[1rem] transition-all shadow-lg transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                        SAYA MENGERTI
                    </button>
                </form>
                <div class="text-center">
                    <a href="{{ route('siswa.panggilan') }}" class="text-[0.8rem] text-gray-400 hover:text-red-600 font-bold transition-colors">Lihat Detail Pelanggaran</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
