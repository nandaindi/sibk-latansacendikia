@extends('layouts.bk')
@section('title', 'Detail Panggilan – ' . $pelanggaran->user->name)

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Detail Panggilan</h2>
    </div>

    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-4">

        {{-- Back Link --}}
        <a href="{{ route('bk.riwayat-panggilan') }}" class="flex items-center gap-2 text-[0.85rem] font-semibold text-[#1a9488] hover:translate-x-[-4px] transition-transform no-underline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Riwayat
        </a>

        {{-- Two Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 items-start">

            {{-- LEFT: All Info in One Card --}}
            <div class="lg:col-span-3">
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-5 shadow-sm flex flex-col gap-4">

                    {{-- Student --}}
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 shrink-0 border border-[#edf2f1] rounded-full overflow-hidden bg-[#e0f5f3]">
                            <img src="{{ $pelanggaran->user->avatar ? asset('storage/' . $pelanggaran->user->avatar) : asset('img/default-profile.png') }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-[1.1rem] text-[#1a1a1a] mb-2">{{ $pelanggaran->user->name }}</div>
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="#888" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line><path d="M8 14h.01"></path><path d="M12 14h.01"></path><path d="M16 14h.01"></path><path d="M8 18h.01"></path><path d="M12 18h.01"></path><path d="M16 18h.01"></path></svg>
                                    <span class="text-[0.82rem] text-[#888]">NIS: {{ $pelanggaran->user->nis ?? '-' }}</span>
                                </div>
                                <span class="text-[#ccc] text-[0.82rem]">|</span>
                                <div class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="#888" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                    <span class="text-[0.82rem] text-[#888]">Kelas {{ $pelanggaran->user->kelas }} {{ $pelanggaran->user->jurusan }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="shrink-0">
                            @if($pelanggaran->status == 'selesai')
                                <span class="px-3 py-1 bg-green-50 text-green-700 font-bold rounded-full text-[0.72rem] uppercase tracking-wider border border-green-200">Selesai</span>
                            @elseif($pelanggaran->status == 'diterima')
                                <span class="px-3 py-1 bg-green-50 text-green-600 font-bold rounded-full text-[0.72rem] uppercase tracking-wider border border-green-200">Diterima</span>
                            @elseif($pelanggaran->status == 'menunggu')
                                <span class="px-3 py-1 bg-orange-50 text-orange-600 font-bold rounded-full text-[0.72rem] uppercase tracking-wider border border-orange-200">Menunggu</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 font-bold rounded-full text-[0.72rem] uppercase tracking-wider border border-gray-200">Tidak Hadir</span>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-[#edf2f1]"></div>

                    {{-- Jadwal --}}
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-2">Jadwal Pertemuan</label>
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="flex items-center gap-1.5">
                                <svg width="16" height="16" fill="none" stroke="#1a1a1a" stroke-width="2" viewBox="0 0 24 24" class="opacity-70"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span class="text-[0.92rem] font-medium text-[#1a1a1a]">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <span class="text-[#ccc] text-[0.92rem]">|</span>
                            <div class="flex items-center gap-1.5">
                                <svg width="16" height="16" fill="none" stroke="#1a1a1a" stroke-width="2" viewBox="0 0 24 24" class="opacity-70"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span class="text-[0.92rem] font-medium text-[#1a1a1a]">Pukul {{ \Carbon\Carbon::parse($pelanggaran->waktu)->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[#edf2f1]"></div>

                    {{-- Topik --}}
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Topik Panggilan</label>
                        <div class="text-[0.92rem] font-semibold text-[#1a1a1a]">{{ $pelanggaran->topik }}</div>
                    </div>

                    <div class="border-t border-[#edf2f1]"></div>

                    {{-- Catatan --}}
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Catatan Pemanggilan</label>
                        <div class="text-[0.9rem] text-[#444] leading-relaxed">
                            {!! nl2br(e($pelanggaran->catatan_pemanggilan ?? 'Tidak ada catatan.')) !!}
                        </div>
                    </div>

                    {{-- Hasil if finished --}}
                    @if(in_array($pelanggaran->status, ['selesai', 'tidak_hadir']))
                        <div class="border-t border-[#edf2f1]"></div>
                        <div>
                            <label class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-wider block mb-1">Hasil Pertemuan</label>
                            <div class="text-[0.9rem] text-[#444] leading-relaxed">{!! nl2br(e($pelanggaran->catatan_hasil)) !!}</div>
                        </div>

                        @if($pelanggaran->catatan_tindak_lanjut)
                        <div class="border-t border-[#edf2f1]"></div>
                        <div>
                            <label class="text-[0.7rem] font-bold text-[#e17055] uppercase tracking-wider block mb-1">Tindak Lanjut</label>
                            <div class="text-[0.9rem] text-[#444] leading-relaxed italic">{!! nl2br(e($pelanggaran->catatan_tindak_lanjut)) !!}</div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- RIGHT: Form / Status --}}
            <div class="lg:col-span-2 lg:sticky lg:top-4">
                @if($pelanggaran->bk_id !== auth()->id())
                <div class="bg-white border-[2px] border-orange-400 rounded-2xl px-5 py-8 shadow-sm text-center">
                    <div class="text-orange-500 font-bold text-[0.85rem] uppercase tracking-wider">Akses Terbatas</div>
                    <p class="text-[0.85rem] text-[#888] mt-2">Pemanggilan ini ditangani oleh Guru BK: <br><strong class="text-gray-700">{{ $pelanggaran->bk->name }}</strong>.</p>
                    <p class="text-[0.75rem] text-gray-500 mt-1">Hanya beliau yang dapat memproses status panggilan ini.</p>
                </div>
                @elseif(in_array($pelanggaran->status, ['menunggu', 'diterima']))
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-5 shadow-sm">
                    <h3 class="font-bold text-[1rem] text-[#1a1a1a] mb-4">Proses Panggilan</h3>

                    <form action="{{ route('bk.panggil-siswa.update', $pelanggaran->id) }}" method="POST" class="flex flex-col gap-5">
                        @csrf

                        <div>
                            <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-2">Konfirmasi Kehadiran</label>
                            <div class="flex gap-3">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="selesai" checked class="hidden peer">
                                    <div class="peer-checked:bg-[#1a9488] peer-checked:text-white peer-checked:border-[#1a9488] text-center py-3 rounded-xl border-2 border-[#edf2f1] font-bold text-[0.85rem] text-[#888] transition-all">
                                        Hadir
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="tidak_hadir" class="hidden peer">
                                    <div class="peer-checked:bg-red-500 peer-checked:text-white peer-checked:border-red-500 text-center py-3 rounded-xl border-2 border-[#edf2f1] font-bold text-[0.85rem] text-[#888] transition-all">
                                        Tidak Hadir
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-2">Hasil Pertemuan <span class="text-red-500">*</span></label>
                            <textarea name="catatan_hasil" placeholder="Apa yang dibahas dan disepakati..." required rows="4"
                                      class="w-full border-2 border-[#edf2f1] rounded-xl px-4 py-3 bg-white outline-none font-medium text-[0.9rem] focus:border-[#1a9488] transition-all placeholder:text-[#bbb] resize-none"></textarea>
                        </div>

                        <div>
                            <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-2">Rencana Tindak Lanjut <span class="text-red-500">*</span></label>
                            <textarea name="catatan_tindak_lanjut" placeholder="Langkah selanjutnya..." required rows="3"
                                      class="w-full border-2 border-[#edf2f1] rounded-xl px-4 py-3 bg-white outline-none font-medium text-[0.9rem] focus:border-[#1a9488] transition-all placeholder:text-[#bbb] resize-none"></textarea>
                        </div>

                        {{-- Jadwal Pertemuan Selanjutnya --}}
                        <div class="border border-[#edf2f1] rounded-xl p-4 bg-[#fcfdfd]">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="has_next_meeting" id="hasNextMeeting" value="1" class="w-5 h-5 text-[#1a9488] rounded border-gray-300 focus:ring-[#1a9488]">
                                <span class="text-[0.85rem] font-bold text-[#1a1a1a]">Jadwalkan pertemuan selanjutnya</span>
                            </label>

                            <div id="nextMeetingInputs" class="hidden mt-4 pt-4 border-t border-[#edf2f1]">
                                <div class="flex gap-3">
                                    <div class="flex-1">
                                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Tanggal</label>
                                        <input type="date" name="next_tanggal" class="w-full border-2 border-[#edf2f1] rounded-xl px-3 py-2.5 bg-white outline-none font-medium text-[0.85rem] focus:border-[#1a9488]">
                                    </div>
                                    <div class="flex-1">
                                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Jam</label>
                                        <input type="time" name="next_waktu" class="w-full border-2 border-[#edf2f1] rounded-xl px-3 py-2.5 bg-white outline-none font-medium text-[0.85rem] focus:border-[#1a9488]">
                                    </div>
                                </div>
                                <p class="text-[0.75rem] text-[#888] mt-2 italic">* Sistem akan otomatis membuat panggilan siswa baru untuk jadwal ini.</p>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-[#1a9488] text-white rounded-xl font-bold text-[0.9rem] hover:bg-[#157a70] transition-colors">
                            Simpan
                        </button>
                    </form>
                </div>
                @else
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-8 shadow-sm text-center">
                    <div class="text-[#1a9488] font-bold text-[0.85rem] uppercase tracking-wider">Kasus Selesai</div>
                    <p class="text-[0.85rem] text-[#888] mt-2">Sesi ini telah diproses dan tercatat dalam riwayat.</p>
                </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('hasNextMeeting');
        const inputs = document.getElementById('nextMeetingInputs');
        const tanggalInput = document.querySelector('input[name="next_tanggal"]');
        const waktuInput = document.querySelector('input[name="next_waktu"]');

        if(checkbox) {
            checkbox.addEventListener('change', function() {
                if(this.checked) {
                    inputs.classList.remove('hidden');
                    tanggalInput.required = true;
                    waktuInput.required = true;
                } else {
                    inputs.classList.add('hidden');
                    tanggalInput.required = false;
                    waktuInput.required = false;
                }
            });
        }
    });
</script>
@endpush
