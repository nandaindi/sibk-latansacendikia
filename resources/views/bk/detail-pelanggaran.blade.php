@extends('layouts.bk')
@section('title', 'Detail Panggilan – ' . $pelanggaran->user->name)

@section('content')
<main class="w-full px-4 md:px-6 py-6 pb-[100px] md:pb-10 max-w-7xl mx-auto">
    
    {{-- Top Navigation --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('bk.panggil-siswa.index') }}" class="group flex items-center justify-center w-11 h-11 bg-white border border-[#edf2f1] rounded-full shadow-sm hover:shadow-md hover:border-[#1a9488]/30 transition-all">
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="text-[#1a9488] group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-[1.8rem] md:text-[2.2rem] font-black text-[#1a1a1a] tracking-tight leading-snug">Detail Panggilan</h1>
            <p class="text-[0.9rem] text-[#888] font-medium uppercase tracking-[0.2em] mt-3">Status: 
                <span class="
                    @if($pelanggaran->status == 'menunggu') text-amber-500
                    @elseif($pelanggaran->status == 'selesai') text-[#1a9488]
                    @else text-red-500
                    @endif">
                    {{ str_replace('_', ' ', $pelanggaran->status) }}
                </span>
            </p>
        </div>
    </div>

    {{-- Unified Hero Bar --}}
    <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] p-8 md:p-10 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 mb-10 overflow-hidden relative group">
        
        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8 overflow-hidden">
            {{-- Big Avatar --}}
            <div class="w-24 h-24 md:w-28 md:h-28 rounded-full overflow-hidden bg-[#e0f5f3] border-[4px] border-white shrink-0 flex items-center justify-center">
                @if($pelanggaran->user->avatar)
                    <img src="{{ asset('storage/' . $pelanggaran->user->avatar) }}" alt="{{ $pelanggaran->user->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-4xl font-black text-[#1a9488]">{{ strtoupper(substr($pelanggaran->user->name, 0, 1)) }}</span>
                @endif
            </div>

            {{-- Meta Info --}}
            <div class="text-center md:text-left">
                <h2 class="text-[2rem] md:text-[2.4rem] font-black text-[#1a1a1a] leading-tight mb-2 uppercase tracking-tight">{{ $pelanggaran->user->name }}</h2>
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-2">
                    <span class="px-3 py-1 bg-gray-50 text-gray-500 border border-gray-200 text-[0.65rem] font-bold rounded-lg uppercase tracking-widest">
                        NIS: {{ $pelanggaran->user->nis ?? '000000' }}
                    </span>
                    <span class="px-3 py-1 bg-[#e0f5f3] text-[#1a9488] border border-[#1a9488]/20 text-[0.65rem] font-bold rounded-lg uppercase tracking-widest">
                        Kelas: {{ $pelanggaran->user->kelas }} {{ $pelanggaran->user->jurusan }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Balanced Grid Workspace --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        {{-- LEFT: Case Context Details --}}
        <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] p-8 md:p-10 shadow-sm flex flex-col gap-10">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-6 bg-[#1a9488] rounded-full"></div>
                    <h3 class="text-[0.9rem] font-bold uppercase tracking-[0.2em] text-[#111]">Jadwal Pertemuan</h3>
                </div>
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-[1.2rem] bg-gray-50 flex flex-col items-center justify-center border border-gray-100 shrink-0">
                        <span class="text-[0.65rem] font-bold text-[#aaa] uppercase">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('M') }}</span>
                        <span class="text-[1.4rem] font-black text-[#1a9488] leading-none">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d') }}</span>
                    </div>
                    <div>
                        <div class="text-[1.1rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('l, d F Y') }}</div>
                        <div class="text-[0.9rem] text-[#777] font-medium mt-0.5">Pukul {{ \Carbon\Carbon::parse($pelanggaran->waktu)->format('H:i') }} WIB</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-1.5 h-6 bg-[#1a9488] rounded-full"></div>
                    <h3 class="text-[0.9rem] font-bold uppercase tracking-[0.2em] text-[#111]">Topik Panggilan</h3>
                </div>
                <div class="text-[1.15rem] font-medium text-[#444] tracking-tight uppercase" style="padding-left: 1.0rem !important;">
                    {{ $pelanggaran->topik }}
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-1.5 h-6 bg-[#1a9488] rounded-full"></div>
                    <h3 class="text-[0.9rem] font-bold uppercase tracking-[0.2em] text-[#111]">Catatan Pemanggilan</h3>
                </div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 border-dashed min-h-[120px]">
                    <p class="text-[1.05rem] text-[#555] font-normal leading-[1.8] italic">
                        "{!! nl2br(e($pelanggaran->catatan_pemanggilan ?? 'Tidak ada catatan khusus.')) !!}"
                    </p>
                </div>
            </div>

            {{-- Show result if status is already finished --}}
            @if($pelanggaran->status != 'menunggu')
            <div class="pt-8 border-t border-[#edf2f1] flex flex-col gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1.5 h-6 bg-[#1a9488] rounded-full"></div>
                        <h3 class="text-[0.9rem] font-bold uppercase tracking-[0.2em] text-[#111]">Hasil Pertemuan</h3>
                    </div>
                    <div class="text-[1.05rem] text-[#333] leading-relaxed font-normal bg-gray-50/50 p-6 rounded-[24px] border border-gray-100/50">
                        {!! nl2br(e($pelanggaran->catatan_hasil)) !!}
                    </div>
                </div>
                
                @if($pelanggaran->catatan_tindak_lanjut)
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1.5 h-6 bg-amber-500 rounded-full"></div>
                        <h3 class="text-[0.9rem] font-bold uppercase tracking-[0.2em] text-[#111]">Tindak Lanjut</h3>
                    </div>
                    <div class="text-[1.05rem] text-[#333] leading-relaxed font-normal bg-amber-50/30 p-6 rounded-[24px] border border-amber-100/50 italic">
                        "{!! nl2br(e($pelanggaran->catatan_tindak_lanjut)) !!}"
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- RIGHT: Action Sidebar / Process Form --}}
        <div class="lg:sticky lg:top-24">
            @if($pelanggaran->status == 'menunggu')
                <div class="bg-white border-[2px] border-[#1a9488]/20 rounded-[32px] p-8 md:p-10 shadow-sm overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#1a9488]/5 rounded-bl-[60px] -z-10"></div>
                    
                    <h3 class="text-[1.3rem] font-bold text-[#1a1a1a] mb-2">Proses Pelanggaran</h3>
                    <p class="text-[0.85rem] text-[#888] font-medium mb-8">Ubah status kehadiran dan berikan catatan hasil pertemuan.</p>
                    
                    <form action="{{ route('bk.panggil-siswa.update', $pelanggaran->id) }}" method="POST" class="flex flex-col gap-6">
                        @csrf
                        <div>
                            <label class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-widest block mb-4 ml-1 pl-1">Konfirmasi Kehadiran Siswa</label>
                            <div class="flex flex-row gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="selesai" checked class="status-radio-input">
                                    <div class="status-btn-box btn-hadir">
                                        Hadir
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="tidak_hadir" class="status-radio-input">
                                    <div class="status-btn-box btn-tidak-hadir">
                                        Tidak Hadir
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-widest block mb-3 ml-1">Hasil Pertemuan</label>
                            <textarea name="catatan_hasil" placeholder="Jelaskan poin-poin hasil pertemuan dengan siswa..." required rows="5"
                                      class="w-full border-[2px] border-[#edf2f1] rounded-[24px] px-6 py-5 bg-[#fcfdfd] outline-none font-normal text-[0.95rem] resize-none focus:border-[#1a9488]/40 transition-colors placeholder:text-[#ccc]"></textarea>
                        </div>

                        <div>
                            <label class="text-[0.7rem] font-bold text-amber-600 uppercase tracking-widest block mb-3 ml-1">Rencana Tindak Lanjut</label>
                            <textarea name="catatan_tindak_lanjut" placeholder="Apa langkah selanjutnya? (Cth: Pemantauan nilai, surat perjanjian...)" required rows="4"
                                      class="w-full border-[2px] border-amber-100 rounded-[24px] px-6 py-5 bg-amber-50/10 outline-none font-normal text-[0.95rem] resize-none focus:border-amber-400/40 transition-colors placeholder:text-[#ccc]"></textarea>
                        </div>

                        <button type="submit" class="w-full py-5 bg-[#1a9488] text-white rounded-full font-black text-[0.95rem] tracking-wider uppercase shadow-[0_10px_25px_rgba(26,148,136,0.3)] hover:-translate-y-1 hover:shadow-[0_15px_30px_rgba(26,148,136,0.4)] active:scale-95 transition-all mt-2">
                            Simpan Hasil Perubahan
                        </button>
                    </form>
                </div>
            @else
                {{-- Finished State Branding --}}
                <div class="mt-10 bg-gray-50 border-[2px] border-dashed border-gray-300 rounded-[32px] py-20 px-12 text-center flex flex-col items-center gap-4">
                    <div class="text-[1.1rem] font-bold text-gray-400 uppercase tracking-[0.2em]">Kasus Ditutup</div>
                    <p class="text-[0.95rem] text-gray-400 font-medium">Sesi ini sudah diproses dan tidak dapat diubah lagi.</p>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeInUp { animation: fadeInUp 0.5s ease-out forwards; }

    /* Custom Status Buttons Logic */
    .status-radio-input {
        display: none !important;
    }
    .status-btn-box {
        padding: 1rem;
        border-radius: 20px;
        border: 2px solid #f3f4f6;
        text-align: center;
        font-weight: 900;
        font-size: 0.9rem;
        color: #9ca3af;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        background-color: white;
    }
    .status-btn-box:hover {
        background-color: #f9fafb;
    }
    .status-radio-input:checked + .btn-hadir {
        background-color: #22c55e !important;
        color: white !important;
        border-color: #22c55e !important;
        box-shadow: 0 10px 15px -3px rgba(34, 197, 94, 0.3);
    }
    .status-radio-input:checked + .btn-tidak-hadir {
        background-color: #ef4444 !important;
        color: white !important;
        border-color: #ef4444 !important;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
    }
</style>
@endpush
