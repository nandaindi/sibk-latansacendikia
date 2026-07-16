@extends('layouts.siswa')

@section('title', 'Feedback Konseling – BK')

@section('content')
<div class="px-4 md:px-6 py-8 bg-[#f9fbfb] min-h-screen">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl p-6 border border-[#1a9488]/30 shadow-lg animate-[fadeInUp_0.4s_ease-out]">
        <div class="flex items-center gap-2 mb-4 text-[#1a9488]">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <h3 class="font-bold text-[1.05rem]">Sesi Telah Selesai</h3>
        </div>
        <p class="text-[0.88rem] text-[#555] mb-5 leading-relaxed italic">"Bimbingan hari ini telah berakhir. Sebelum kembali ke dashboard, silakan isi kesimpulan dan saran kamu untuk sesi ini."</p>
        
        <form action="{{ route('siswa.konseling.feedback') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <input type="hidden" name="konseling_id" value="{{ $konseling->id }}">
            
            <div class="flex flex-col gap-3 mb-2">
                <label class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wide border-b border-[#1a9488]/20 pb-1">Penilaian Kepuasan Layanan</label>
                
                <style>
                    .emoji-radio input[type="radio"] { display: none; }
                    .emoji-radio label { cursor: pointer; opacity: 0.5; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); transform: scale(0.9); border: 2px solid transparent; border-radius: 50%; padding: 4px; }
                    .emoji-radio input[type="radio"]:hover + label { opacity: 0.8; transform: scale(1.05); }
                    .emoji-radio input[type="radio"]:checked + label { opacity: 1; transform: scale(1.15); border-color: currentColor; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
                    
                    /* Colors */
                    .emoji-radio .label-kurang { color: #ef4444; }
                    .emoji-radio input[value="Kurang Memuaskan"]:checked + label { background: #fef2f2; }
                    
                    .emoji-radio .label-cukup { color: #f59e0b; }
                    .emoji-radio input[value="Memuaskan"]:checked + label { background: #fffbeb; }
                    
                    .emoji-radio .label-sangat { color: #10b981; }
                    .emoji-radio input[value="Sangat Memuaskan"]:checked + label { background: #ecfdf5; }
                </style>

                @php
                    $kepuasanItems = [
                        'kepuasan_penerimaan' => 'Penerimaan guru bimbingan dan konseling atau konselor terhadap kehadiran Anda',
                        'kepuasan_kemudahan' => 'Kemudahan guru bimbingan dan konseling atau konselor untuk diajak curhat',
                        'kepuasan_kepercayaan' => 'Kepercayaan Anda terhadap guru bimbingan dan konseling atau konselor dalam layanan konseling',
                        'kepuasan_pelayanan' => 'Pelayanan pemecahan masalah tercapai melalui konseling individual'
                    ];
                @endphp

                @foreach($kepuasanItems as $name => $label)
                <div class="bg-[#f9fbfb] border border-[#1a9488]/20 rounded-xl p-3 flex flex-col gap-3">
                    <div class="text-[0.85rem] text-[#333] font-medium leading-tight text-center">{{ $label }}</div>
                    <div class="flex justify-center items-center gap-6 emoji-radio">
                        <!-- Kurang Memuaskan -->
                        <div class="flex flex-col items-center gap-1">
                            <input type="radio" name="{{ $name }}" id="{{ $name }}_kurang" value="Kurang Memuaskan" required>
                            <label for="{{ $name }}_kurang" class="text-3xl label-kurang" title="Kurang Memuaskan">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                            </label>
                            <span class="text-[0.6rem] text-gray-500 font-bold uppercase tracking-tighter">Kurang</span>
                        </div>
                        <!-- Memuaskan -->
                        <div class="flex flex-col items-center gap-1">
                            <input type="radio" name="{{ $name }}" id="{{ $name }}_cukup" value="Memuaskan" required>
                            <label for="{{ $name }}_cukup" class="text-3xl label-cukup" title="Memuaskan">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="15" x2="16" y2="15"></line><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                            </label>
                            <span class="text-[0.6rem] text-gray-500 font-bold uppercase tracking-tighter">Cukup</span>
                        </div>
                        <!-- Sangat Memuaskan -->
                        <div class="flex flex-col items-center gap-1">
                            <input type="radio" name="{{ $name }}" id="{{ $name }}_sangat" value="Sangat Memuaskan" required>
                            <label for="{{ $name }}_sangat" class="text-3xl label-sangat" title="Sangat Memuaskan">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                            </label>
                            <span class="text-[0.6rem] text-gray-500 font-bold uppercase tracking-tighter">Sangat</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.82rem] font-bold text-[#1a9488] uppercase tracking-wide">Kesimpulan Kamu</label>
                <textarea name="kesimpulan_siswa" rows="2" required placeholder="Apa yang kamu simpulkan dari bimbingan ini?"
                            class="w-full bg-[#f9fbfb] border-2 border-[#1a9488]/20 rounded-xl px-4 py-2.5 text-[0.93rem] outline-none focus:border-[#1a9488] transition-colors resize-none"></textarea>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.82rem] font-bold text-[#1a9488] uppercase tracking-wide">Saran Untuk Guru BK</label>
                <textarea name="saran_siswa" rows="2" required placeholder="Berikan saran jika ada..."
                            class="w-full bg-[#f9fbfb] border-2 border-[#1a9488]/20 rounded-xl px-4 py-2.5 text-[0.93rem] outline-none focus:border-[#1a9488] transition-colors resize-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-[#1a9488] text-white py-3 rounded-xl font-bold text-[0.95rem] shadow-md hover:brightness-105 active:scale-95 transition-all mt-2 border-none cursor-pointer">
                Selesaikan & Simpan
            </button>
        </form>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
