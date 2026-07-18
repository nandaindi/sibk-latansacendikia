@extends('layouts.admin')

@section('title', 'Tambah Akun – Admin')

@section('content')

<div class="w-full">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kelola-akun') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Tambah Akun</h2>
    </div>

    <form id="tambahAkunForm" method="POST" action="{{ route('admin.tambah-akun.store') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Nama --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" placeholder="Nama Lengkap" required pattern="[a-zA-Z\s\.\,\']+" title="Hanya boleh berisi huruf, spasi, titik, dan koma" oninput="this.value = this.value.replace(/[^a-zA-Z\s.,']/g, '')"
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Email --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" placeholder="Email" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>


        {{-- Role hardcoded sebagai Admin --}}
        <input type="hidden" name="role" value="admin">

        {{-- Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" placeholder="Min 8 karakter" required minlength="8" maxlength="8"
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Save Button (Triggers Modal) --}}
        <div class="flex justify-end mt-2">
            <button type="button" onclick="showConfirmModal()"
                    class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95">
                Simpan
            </button>
        </div>
    </form>

</div>

{{-- ===== KONFIRMASI TAMBAH AKUN MODAL ===== --}}
<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[400px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">

        {{-- Illustration --}}
        <div class="h-32 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.05rem] font-bold text-[#1a1a1a] text-center">Apakah anda yakin tambah akun?</p>

        <div class="flex gap-4 w-full justify-center mt-2">
            {{-- Button OK (Submit Form) --}}
            <button type="button" onclick="submitForm()"
                    class="h-[46px] px-8 bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                </svg>
            </button>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideConfirmModal()"
                    class="h-[46px] px-8 bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showConfirmModal() {
    const form = document.getElementById('tambahAkunForm');
    if (form.checkValidity()) {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    } else {
        form.reportValidity();
    }
}

function hideConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}

function submitForm() {
    document.getElementById('tambahAkunForm').submit();
}
</script>
@endpush

