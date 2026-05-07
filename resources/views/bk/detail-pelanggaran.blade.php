@extends('layouts.bk')
@section('title', 'Detail Panggilan – ' . $pelanggaran->user->name)

@section('content')
<main class="w-full px-4 md:px-6 py-8 pb-[100px] md:pb-12 max-w-7xl mx-auto">
    
    {{-- Top Navigation & Title --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <a href="{{ route('bk.panggil-siswa.index') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-100 rounded-2xl shadow-sm hover:shadow-md border border-gray-200 transition-all">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="text-gray-600 group-hover:-translate-x-1 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Detail Panggilan</h1>
            </div>
        </div>
    </div>

    {{-- Student Hero Section --}}
    <div class="bg-gray-50 rounded-3xl p-6 md:p-8 border border-gray-200 flex flex-col md:flex-row items-center gap-6 md:gap-10 mb-10 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 md:gap-8 w-full">
            {{-- Avatar --}}
            <div class="w-24 h-24 md:w-28 md:h-28 rounded-full overflow-hidden bg-white border-4 border-white shadow-sm shrink-0 flex items-center justify-center">
                @if($pelanggaran->user->avatar)
                    <img src="{{ asset('storage/' . $pelanggaran->user->avatar) }}" alt="{{ $pelanggaran->user->name }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('img/default-profile.png') }}" alt="{{ $pelanggaran->user->name }}" class="w-full h-full object-cover">
                @endif
            </div>

            {{-- Meta Info --}}
            <div class="text-center md:text-left flex-1">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight mb-3 tracking-tight uppercase">{{ $pelanggaran->user->name }}</h2>
                <div class="flex items-center justify-center md:justify-start gap-2 mt-1">
                    <p class="text-sm md:text-base font-bold text-gray-500 uppercase">NIS : {{ $pelanggaran->user->nis ?? '000000' }} 
                        <span class="mx-1 text-gray-300 font-light">| </span> 
                     <p class="text-sm md:text-base font-bold text-gray-500 uppercase">KELAS : {{ $pelanggaran->user->kelas }} {{ $pelanggaran->user->jurusan }}</p>
                    
                   
                </div>
            </div>
        </div>
    </div>

    {{-- Balanced Grid Workspace --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- LEFT: Case Context Details --}}
        <div class="lg:col-span-7 flex flex-col gap-8">
            
            {{-- Info Cards Container --}}
            <div class="bg-gray-50 rounded-3xl p-8 md:p-10 border border-gray-200 flex flex-col gap-10">
                
                {{-- Jadwal Section --}}
                <section>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Jadwal Pertemuan</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex flex-col">
                            <div class="text-xl font-bold text-gray-900 tracking-tight">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('l, d F Y') }}</div>
                            <div class="text-base text-gray-500 font-medium mt-1">Pukul {{ \Carbon\Carbon::parse($pelanggaran->waktu)->format('H:i') }} WIB</div>
                        </div>
                    </div>
                </section>

                {{-- Topik Section --}}
                <section>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Topik Panggilan</h3>
                    <div class="text-xl font-bold text-gray-800 tracking-tight pl-1 uppercase">
                        {{ $pelanggaran->topik }}
                    </div>
                </section>

                {{-- Catatan Section --}}
                <section>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Catatan Pemanggilan</h3>
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 min-h-[100px]">
                        <p class="text-base text-gray-600 leading-relaxed font-medium italic">
                            "{!! nl2br(e($pelanggaran->catatan_pemanggilan ?? 'Tidak ada catatan khusus.')) !!}"
                        </p>
                    </div>
                </section>

                {{-- Show result if status is already finished --}}
                @if($pelanggaran->status != 'menunggu')
                <div class="pt-10 border-t border-gray-200 flex flex-col gap-8">
                    <section>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-4">Hasil Pertemuan</h3>
                        <div class="text-base text-gray-700 leading-relaxed font-medium bg-white p-6 rounded-2xl border border-gray-100">
                            {!! nl2br(e($pelanggaran->catatan_hasil)) !!}
                        </div>
                    </section>
                    
                    @if($pelanggaran->catatan_tindak_lanjut)
                    <section>
                        <h3 class="text-xs font-bold uppercase tracking-widest text-amber-600 mb-4">Tindak Lanjut</h3>
                        <div class="text-base text-gray-700 leading-relaxed font-medium bg-white p-6 rounded-2xl border border-gray-100 italic">
                            "{!! nl2br(e($pelanggaran->catatan_tindak_lanjut)) !!}"
                        </div>
                    </section>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: Action Sidebar / Process Form --}}
        <div class="lg:col-span-5 lg:sticky lg:top-10">
            @if($pelanggaran->status == 'menunggu')
                <div class="bg-gray-50 rounded-3xl p-8 border border-gray-200 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-xl font-extrabold text-gray-900 mb-2">Proses Panggilan</h3>
                        <p class="text-sm text-gray-500 font-medium mb-8">Berikan konfirmasi kehadiran dan hasil pertemuan dengan siswa.</p>
                        
                        <form action="{{ route('bk.panggil-siswa.update', $pelanggaran->id) }}" method="POST" class="flex flex-col gap-6">
                            @csrf
                            <div>
                                <label class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest block mb-4">Konfirmasi Kehadiran</label>
                                <div class="flex flex-row gap-4">
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" name="status" value="selesai" checked class="status-radio-input">
                                        <div class="status-btn-box btn-hadir py-4 rounded-xl border-2 border-gray-200 font-bold text-sm text-gray-400 group-hover:bg-white transition-all text-center bg-white/50">
                                            Hadir
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" name="status" value="tidak_hadir" class="status-radio-input">
                                        <div class="status-btn-box btn-tidak-hadir py-4 rounded-xl border-2 border-gray-200 font-bold text-sm text-gray-400 group-hover:bg-white transition-all text-center bg-white/50">
                                            Mangkir
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest block mb-3">Hasil Pertemuan</label>
                                <textarea name="catatan_hasil" placeholder="Apa saja yang dibahas dan disepakati?" required rows="5"
                                          class="w-full border border-gray-200 rounded-2xl px-6 py-4 bg-white outline-none font-medium text-sm focus:ring-4 focus:ring-gray-200 focus:border-gray-300 transition-all placeholder:text-gray-300 resize-none"></textarea>
                            </div>

                            <div>
                                <label class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest block mb-3">Rencana Tindak Lanjut</label>
                                <textarea name="catatan_tindak_lanjut" placeholder="Langkah pemantauan selanjutnya..." required rows="4"
                                          class="w-full border border-gray-200 rounded-2xl px-6 py-4 bg-white outline-none font-medium text-sm focus:ring-4 focus:ring-gray-200 focus:border-gray-300 transition-all placeholder:text-gray-300 resize-none"></textarea>
                            </div>

                            <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-bold text-sm tracking-wider uppercase shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 hover:-translate-y-0.5 active:scale-95 transition-all mt-2">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- Finished State Branding --}}
                <div class="bg-gray-100 rounded-3xl py-16 px-8 text-center flex flex-col items-center gap-6 border border-gray-200 shadow-inner">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-200">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Kasus Selesai</div>
                        <p class="text-gray-500 text-sm font-medium leading-relaxed">Sesi ini telah diproses secara permanen dalam sistem riwayat konseling.</p>
                    </div>
                    <a href="{{ route('bk.panggil-siswa.index') }}" class="mt-4 text-emerald-600 font-bold text-sm hover:underline flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                        Kembali ke Daftar
                    </a>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
    .status-radio-input {
        display: none !important;
    }
    .status-radio-input:checked + .btn-hadir {
        background-color: #10b981 !important;
        color: white !important;
        border-color: #10b981 !important;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }
    .status-radio-input:checked + .btn-tidak-hadir {
        background-color: #ef4444 !important;
        color: white !important;
        border-color: #ef4444 !important;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2);
    }
</style>
@endpush
