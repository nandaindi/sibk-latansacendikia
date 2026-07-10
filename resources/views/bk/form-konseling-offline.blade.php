@extends('layouts.bk')

@section('title', 'Form Konseling Offline – BK')

@section('content')
<main class="max-w-7xl mx-auto w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10">

    <!-- Title with teal underline -->
    <div class="mb-6 border-b-2 border-[#1a9488] pb-3">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a9488]">Konseling Offline</h2>
    </div>

    <!-- Sub-title -->
    <p class="text-[1.05rem] font-extrabold text-[#1a9488] mb-5">Form Pencatatan</p>

    <!-- Form -->
    <form id="formKonselingOffline" method="POST" action="{{ route('bk.store-form-konseling-offline') }}" class="flex flex-col gap-5">
        @csrf
        <!-- ID Sesi -->
        <input type="hidden" name="konseling_id" value="{{ $konseling->id }}">

        <!-- Info Siswa (Readonly) -->
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 border-[2px] border-[#1a9488] rounded-full px-5 py-3 cursor-not-allowed bg-[#f4f6f9] opacity-80">
                <label class="text-[0.7rem] font-bold text-[#1a9488] block uppercase tracking-wide">Nama Siswa</label>
                <div class="text-[0.95rem] text-[#1a1a1a] font-medium mt-0.5">{{ $konseling->user->name }}</div>
            </div>
            <div class="flex-1 border-[2px] border-[#1a9488] rounded-full px-5 py-3 cursor-not-allowed bg-[#f4f6f9] opacity-80">
                <label class="text-[0.7rem] font-bold text-[#1a9488] block uppercase tracking-wide">Jadwal Sesi</label>
                <div class="text-[0.95rem] text-[#1a1a1a] font-medium mt-0.5">
                    {{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('d M Y') }} · {{ \Carbon\Carbon::parse($konseling->waktu)->format('H:i') }}
                </div>
            </div>
        </div>

        <div class="h-px w-full bg-[#1a9488] opacity-20 my-1"></div>

        <!-- Durasi Sesi (Menit) removed from UI, will be calculated on backend -->


        <!-- Problem -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.8rem] font-bold text-[#1a9488] block mb-1">Permasalahan Utama (Problem)</label>
            <input type="text" name="problem" placeholder="Deskripsikan masalah secara singkat..." required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium" />
        </div>

        <!-- Solution -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.8rem] font-bold text-[#1a9488] block mb-1">Solusi / Tindakan (Solution)</label>
            <input type="text" name="solution" placeholder="Tindakan yang disarankan..." required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium" />
        </div>

        <!-- Rencana Tindak Lanjut (RTL) removed from UI -->


        <!-- Note -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.8rem] font-bold text-[#1a9488] block mb-1">Catatan Tambahan (Note)</label>
            <textarea name="note" placeholder="Tulis catatan jika ada..." rows="3"
                      class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium resize-none"></textarea>
        </div>

        <!-- Checkbox: Jadwal Pertemuan Selanjutnya -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white transition-all mt-2">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="has_next_meeting" id="hasNextMeetingOffline" value="1" class="w-5 h-5 accent-[#1a9488]" onchange="toggleNextMeetingOffline()">
                <span class="text-[0.95rem] font-bold text-[#1a9488]">Jadwalkan Pertemuan Selanjutnya?</span>
            </label>
            
            <div id="nextMeetingFieldsOffline" class="hidden mt-4 pt-4 border-t border-[#eaeaea]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1">Tanggal Pertemuan</label>
                        <input type="date" name="next_tanggal" class="w-full border-b-2 border-[#eee] outline-none py-2 text-[1rem] text-[#1a1a1a] focus:border-[#1a9488] transition-colors" />
                    </div>
                    <div>
                        <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1">Waktu Pertemuan</label>
                        <input type="time" name="next_waktu" class="w-full border-b-2 border-[#eee] outline-none py-2 text-[1rem] text-[#1a1a1a] focus:border-[#1a9488] transition-colors" />
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script>
        function toggleNextMeetingOffline() {
            const isChecked = document.getElementById('hasNextMeetingOffline').checked;
            const fields = document.getElementById('nextMeetingFieldsOffline');
            const tgl = document.querySelector('input[name="next_tanggal"]');
            const wkt = document.querySelector('input[name="next_waktu"]');
            
            if (isChecked) {
                fields.classList.remove('hidden');
                tgl.required = true;
                wkt.required = true;
            } else {
                fields.classList.add('hidden');
                tgl.required = false;
                wkt.required = false;
            }
        }
    </script>

    <!-- Save Button (full-width on mobile, right-aligned on desktop) -->
    <div class="flex justify-end mt-6">
        <button
            onclick="document.getElementById('formKonselingOffline').submit()"
            class="w-full md:w-auto px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95"
        >
            Simpan &amp; Buat Laporan
        </button>
    </div>

</main>


@endsection
