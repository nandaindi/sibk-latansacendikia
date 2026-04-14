@extends('layouts.bk')

@section('title', 'Detail Pelanggaran – BK')

@section('content')
<main class="w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10">
    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('bk.panggil-siswa.index') }}" class="w-10 h-10 rounded-full bg-white border border-[#eaeaea] flex items-center justify-center text-[#1a9488] shadow-sm hover:shadow-md transition-all">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Panggilan Pelanggaran</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT: Detail Info -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <div class="bg-white rounded-[24px] p-6 md:p-8 border border-[#edf2f1] shadow-[0_4px_20px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-[#f5f5f5]">
                    <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] border-2 border-[#1a9488] flex items-center justify-center text-[1.5rem] font-black text-[#1a9488]">
                        {{ substr($pelanggaran->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xl font-bold text-[#1a1a1a]">{{ $pelanggaran->user->name }}</div>
                        <div class="text-sm text-[#777] font-medium">{{ $pelanggaran->user->kelas }} {{ $pelanggaran->user->jurusan }}</div>
                    </div>
                    <div class="ml-auto">
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                            @if($pelanggaran->status == 'menunggu') bg-[#fff3cd] text-[#856404]
                            @elseif($pelanggaran->status == 'selesai') bg-[#d4edda] text-[#155724]
                            @else bg-[#f8d7da] text-[#721c24]
                            @endif">
                            {{ str_replace('_', ' ', $pelanggaran->status) }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <div class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-widest mb-1">Topik Panggilan</div>
                        <div class="text-[1.05rem] font-semibold text-[#1a1a1a]">{{ $pelanggaran->topik }}</div>
                    </div>
                    <div>
                        <div class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-widest mb-1">Jadwal Pertemuan</div>
                        <div class="text-[1.05rem] font-semibold text-[#1a1a1a]">
                            {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('l, d M Y') }} pkl {{ \Carbon\Carbon::parse($pelanggaran->waktu)->format('H:i') }}
                        </div>
                    </div>
                </div>

                <div>
                    <div class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-widest mb-1">Catatan Pemanggilan</div>
                    <div class="bg-[#f9fafb] rounded-[16px] p-4 text-[0.95rem] text-[#444] leading-relaxed whitespace-pre-line border border-[#f0f0f0]">
                        {{ $pelanggaran->catatan_pemanggilan ?? '-' }}
                    </div>
                </div>
                
                @if($pelanggaran->status == 'selesai')
                <div class="mt-6">
                    <div class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-widest mb-1">Hasil & Tindak Lanjut</div>
                    <div class="bg-[#f0fdf9] rounded-[16px] p-4 text-[0.95rem] text-[#155724] leading-relaxed whitespace-pre-line border border-[#c3e6cb]">
                        {{ $pelanggaran->catatan_hasil ?? '-' }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: Form Update (If waiting) -->
        <div class="lg:col-span-1">
            @if($pelanggaran->status == 'menunggu')
            <div class="bg-white rounded-[24px] p-6 md:p-8 border border-[#edf2f1] shadow-[0_10px_30px_rgba(26,148,136,0.1)] sticky top-24">
                <h3 class="text-lg font-bold text-[#1a1a1a] mb-5">Proses Pelanggaran</h3>
                
                <form id="formUpdate" action="{{ route('bk.panggil-siswa.update', $pelanggaran->id) }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-wide ml-1 mb-1 block">Status Akhir</label>
                        <select name="status" class="w-full border-[2px] border-[#1a9488] rounded-full px-5 py-3 bg-white outline-none font-semibold text-sm">
                            <option value="selesai">Hadir & Selesai</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-wide ml-1 mb-1 block">Catatan Hasil</label>
                        <textarea name="catatan_hasil" placeholder="Tuliskan hasil pertemuan dan arahan yang diberikan..." required rows="6"
                                  class="w-full border-[2px] border-[#1a9488] rounded-[20px] px-5 py-4 bg-white outline-none font-medium text-sm resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-[#1a9488] text-white rounded-full font-bold shadow-[0_4px_16px_rgba(26,148,136,0.3)] hover:bg-[#157a70] transition-all active:scale-95 mt-2">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection
