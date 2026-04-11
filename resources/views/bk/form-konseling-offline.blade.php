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

    </form>

    <!-- Save Button (right aligned) -->
    <div class="flex justify-end mt-6">
        <button
            onclick="document.getElementById('formKonselingOffline').submit()"
            class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95"
        >
            Save
        </button>
    </div>

</main>


@endsection
