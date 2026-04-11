@extends('layouts.admin')

@section('title', 'Tambah Data Laporan – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Tambah Laporan</h2>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium lowercase">
            kelola laporan/tambah data
        </div>
    </div>

    <form id="tambahLaporanForm" method="POST" action="{{ route('admin.kelola-laporan.store') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Nama Laporan --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Laporan</label>
            <input type="text" name="nama_laporan" placeholder="Nama Laporan" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Date --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all relative">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Tanggal Laporan</label>
            <input type="date" name="tanggal" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium
                          [color-scheme:light] [&::-webkit-calendar-picker-indicator]:opacity-50 [&::-webkit-calendar-picker-indicator]:cursor-pointer"/>
        </div>

        {{-- Save Button (Triggers Tambah Laporan Modal) --}}
        <div class="mt-4">
            <button type="button" onclick="showConfirmTambahLaporanModal()"
                    class="w-full py-4 bg-[#1a7a70] text-white rounded-full text-[1.1rem] font-bold shadow-[0_4px_16px_rgba(26,122,112,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
                Tambah Laporan
            </button>
        </div>
    </form>

</div>

{{-- ===== KONFIRMASI TAMBAH LAPORAN MODAL ===== --}}
<div id="confirmTambahLaporanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmTambahLaporanModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">

        {{-- Illustration --}}
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin tambah data laporan?</p>

        <div class="flex gap-5 w-full justify-center mt-2">
            {{-- Button OK (Submit Form) --}}
            <button type="button" onclick="submitTambahLaporanForm()"
                    class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                </svg>
            </button>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideConfirmTambahLaporanModal()"
                    class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showConfirmTambahLaporanModal() {
    const form = document.getElementById('tambahLaporanForm');
    if (form.checkValidity()) {
        document.getElementById('confirmTambahLaporanModal').classList.remove('hidden');
        document.getElementById('confirmTambahLaporanModal').classList.add('flex');
    } else {
        form.reportValidity();
    }
}

function hideConfirmTambahLaporanModal() {
    document.getElementById('confirmTambahLaporanModal').classList.add('hidden');
    document.getElementById('confirmTambahLaporanModal').classList.remove('flex');
}

function submitTambahLaporanForm() {
    document.getElementById('tambahLaporanForm').submit();
}
</script>
@endpush
