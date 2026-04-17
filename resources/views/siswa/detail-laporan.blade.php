@extends('layouts.siswa')

@section('title', 'Detail Laporan Konseling')

@section('content')
<main class="w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10 max-w-4xl mx-auto">

    <!-- Header Section -->
    <div class="mb-6 flex flex-col gap-2">
        <a href="{{ route('siswa.riwayat-konseling') }}" class="text-[#1a9488] text-sm font-semibold hover:underline w-fit">&larr; Kembali ke Riwayat Laporan</a>
        <h2 class="text-[1.3rem] md:text-[1.8rem] font-extrabold text-[#1a1a1a]">Laporan Konseling</h2>
        <div class="text-[#555] text-sm mt-1">Sesi {{ ucfirst($laporan->jenis) }} &middot; {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('l, d F Y') }}</div>
    </div>

    <!-- Laporan Card -->
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="bg-[#e0f5f3] px-5 py-4 border-b border-[#1a9488]/30 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#1a9488] text-white flex items-center justify-center shrink-0">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-[#1a1a1a]">Hasil Konseling</h3>
                <div class="text-xs font-medium text-[#1a9488]">Bersama Guru BK</div>
            </div>
        </div>

        <div class="p-6">
            @if($laporan->catatan_bk)
                <div class="prose prose-sm md:prose-base max-w-none text-[#333] whitespace-pre-line leading-relaxed">
                    {{ $laporan->catatan_bk }}
                </div>
            @else
                <div class="text-center py-8 text-[#888] font-medium border-2 border-dashed border-[#edf2f1] rounded-xl flex flex-col items-center gap-2">
                    <svg width="32" height="32" fill="none" stroke="#ccc" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Belum ada catatan dari Guru BK untuk sesi ini.
                </div>
            @endif
        </div>
    </div>

    <!-- Feedback Section -->
    @if($laporan->kesimpulan_siswa)
        <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl shadow-sm overflow-hidden mb-6 animate-[fadeIn_0.5s_ease-out]">
            <div class="bg-[#f0f9f8] px-5 py-4 border-b border-[#1a9488]/20 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white border-2 border-[#1a9488] text-[#1a9488] flex items-center justify-center shrink-0">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#1a1a1a]">Kesimpulan & Umpan Balik</h3>
                    <div class="text-xs font-medium text-[#1a9488]">Dari Kamu untuk Sesi Ini</div>
                </div>
            </div>
            <div class="p-6 flex flex-col gap-5">
                <div>
                    <h4 class="text-[0.8rem] font-bold text-[#1a9488] uppercase tracking-wider mb-2">Kesimpulan Saya:</h4>
                    <p class="text-[#333] leading-relaxed italic">"{{ $laporan->kesimpulan_siswa }}"</p>
                </div>
                <div>
                    <h4 class="text-[0.8rem] font-bold text-[#1a9488] uppercase tracking-wider mb-2">Saran Saya:</h4>
                    <p class="text-[#333] leading-relaxed">"{{ $laporan->saran_siswa }}"</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white border-[2px] border-dashed border-[#1a9488]/40 rounded-2xl p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-[#1a9488]/10 text-[#1a9488] flex items-center justify-center">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <h3 class="text-[1.1rem] font-bold text-[#1a1a1a]">Sesi Feedback</h3>
            </div>
            <p class="text-[0.9rem] text-[#555] mb-5 italic">"Bimbingan hari ini telah berakhir. Silakan isi kesimpulan dan saran kamu untuk sesi ini sebagai bahan evaluasi bersama."</p>
            
            <form action="{{ route('siswa.konseling.feedback') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <input type="hidden" name="konseling_id" value="{{ $laporan->id }}">
                
                <div class="flex flex-col gap-1.5">
                    <label class="text-[0.75rem] font-extrabold text-[#1a9488] uppercase tracking-wide">Kesimpulan Kamu</label>
                    <textarea name="kesimpulan_siswa" rows="3" required placeholder="Apa yang kamu simpulkan dari bimbingan ini?"
                        class="w-full bg-[#f9fbfb] border-2 border-[#1a9488]/20 rounded-xl px-4 py-3 text-[0.95rem] outline-none focus:border-[#1a9488] transition-all resize-none"></textarea>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-[0.75rem] font-extrabold text-[#1a9488] uppercase tracking-wide">Saran Untuk Guru BK</label>
                    <textarea name="saran_siswa" rows="2" required placeholder="Berikan saran jika ada..."
                        class="w-full bg-[#f9fbfb] border-2 border-[#1a9488]/20 rounded-xl px-4 py-3 text-[0.95rem] outline-none focus:border-[#1a9488] transition-all resize-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-[#1a9488] text-white py-3.5 rounded-xl font-bold text-sm shadow-md hover:brightness-110 active:scale-[0.98] transition-all mt-2 cursor-pointer border-none">
                    Kirim Feedback & Selesaikan
                </button>
            </form>
        </div>
    @endif

</main>
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
