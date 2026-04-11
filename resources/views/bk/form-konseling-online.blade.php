@extends('layouts.bk')

@section('title', 'Form Konseling Online – BK')

@section('content')
<main class="max-w-7xl mx-auto w-full px-4 md:px-6 py-6 flex-1 pb-[100px] md:pb-10">

    <!-- Title with teal underline -->
    <div class="mb-6 border-b-2 border-[#1a9488] pb-3">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a9488]">Konseling Online Selesai</h2>
    </div>

    <!-- Sub-title -->
    <p class="text-[1.05rem] font-extrabold text-[#1a9488] mb-5">Form Pencatatan Hasil Sesi</p>

    <!-- Form -->
    <form id="formKonselingOnline" method="POST" action="{{ route('bk.store-form-konseling-online') }}" class="flex flex-col gap-5 animate-[fadeIn_0.5s_ease-out]">
        @csrf
        <!-- ID Sesi -->
        <input type="hidden" name="konseling_id" value="{{ $konseling->id }}">

        <!-- Info Siswa (Readonly) -->
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 border-[2px] border-[#1a9488] rounded-2xl px-5 py-3 cursor-not-allowed bg-[#f4f6f9] opacity-80 shadow-sm">
                <label class="text-[0.7rem] font-bold text-[#1a9488] block uppercase tracking-wide">Nama Siswa</label>
                <div class="text-[0.95rem] text-[#1a1a1a] font-medium mt-0.5">{{ $konseling->user->name }}</div>
            </div>
            <div class="flex-1 border-[2px] border-[#1a9488] rounded-2xl px-5 py-3 cursor-not-allowed bg-[#f4f6f9] opacity-80 shadow-sm">
                <label class="text-[0.7rem] font-bold text-[#1a9488] block uppercase tracking-wide">Jadwal Sesi</label>
                <div class="text-[0.95rem] text-[#1a1a1a] font-medium mt-0.5">
                    {{ \Carbon\Carbon::parse($konseling->tanggal)->translatedFormat('d M Y') }} · Online Chat
                </div>
            </div>
        </div>

        <div class="h-px w-full bg-[#1a9488] opacity-20 my-1"></div>

        <!-- Problem -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all shadow-sm">
            <label class="text-[0.8rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wider">Permasalahan Utama (Problem)</label>
            <input type="text" name="problem" placeholder="Apa inti permasalahan yang dibahas?" required
                   class="w-full border-none outline-none text-[1.05rem] text-[#1a1a1a] placeholder-[#bbb] bg-transparent font-medium" />
        </div>

        <!-- Solution -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all shadow-sm">
            <label class="text-[0.8rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wider">Solusi / Tindakan (Solution)</label>
            <input type="text" name="solution" placeholder="Langkah atau solusi yang disepakati..." required
                   class="w-full border-none outline-none text-[1.05rem] text-[#1a1a1a] placeholder-[#bbb] bg-transparent font-medium" />
        </div>

        <!-- Note -->
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all shadow-sm">
            <label class="text-[0.8rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wider">Catatan Tambahan (Note)</label>
            <textarea name="note" placeholder="Ringkasan poin penting lainnya..." rows="4"
                      class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#bbb] bg-transparent font-medium resize-none"></textarea>
        </div>

    </form>

    <!-- Save Button (right aligned) -->
    <div class="flex justify-end mt-8">
        <button
            onclick="document.getElementById('formKonselingOnline').submit()"
            class="px-12 py-4 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.3)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer"
        >
            Simpan & Buat Laporan
        </button>
    </div>

</main>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
