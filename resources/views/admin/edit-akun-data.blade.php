@extends('layouts.admin')

@section('title', 'Edit Konseling – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Edit Konseling</h2>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium">
            Kelola Data/Detail/Edit Akun
        </div>
    </div>

    <form id="editKonselingForm" method="POST" action="{{ route('admin.kelola-data.edit-akun.update', ['id' => $user->id]) }}" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Lengkap Siswa</label>
            <input type="text" name="nama" placeholder="Nama" value="{{ old('nama', $user->name) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- NIS --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">NIS (Nomor Induk Siswa)</label>
            <input type="text" name="nis" placeholder="NIS" value="{{ old('nis', $user->nis) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Email --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Alamat Email</label>
            <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" placeholder="Password Baru"
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Save Button (Triggers Edit Modal) --}}
        <div class="mt-4">
            <button type="button" onclick="showConfirmEditDataModal()"
                    class="w-full py-4 bg-[#1a7a70] text-white rounded-full text-[1.1rem] font-bold shadow-[0_4px_16px_rgba(26,122,112,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

{{-- ===== KONFIRMASI EDIT DATA MODAL ===== --}}
<div id="confirmEditDataModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmEditDataModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">

        {{-- Illustration --}}
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin edit data?</p>

        <div class="flex gap-5 w-full justify-center mt-2">
            {{-- Button OK (Submit Edit Form) --}}
            <button type="button" onclick="submitEditDataForm()"
                    class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                </svg>
            </button>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideConfirmEditDataModal()"
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
function showConfirmEditDataModal() {
    const form = document.getElementById('editKonselingForm');
    if (form.checkValidity()) {
        document.getElementById('confirmEditDataModal').classList.remove('hidden');
        document.getElementById('confirmEditDataModal').classList.add('flex');
    } else {
        form.reportValidity();
    }
}

function hideConfirmEditDataModal() {
    document.getElementById('confirmEditDataModal').classList.add('hidden');
    document.getElementById('confirmEditDataModal').classList.remove('flex');
}

function submitEditDataForm() {
    document.getElementById('editKonselingForm').submit();
}
</script>
@endpush
