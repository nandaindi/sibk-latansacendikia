@extends('layouts.admin')

@section('title', 'Edit Akun – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Edit Akun</h2>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium">
            Kelola Akun/Detail/Edit Akun
        </div>
    </div>

    <form id="editAkunForm" method="POST" action="{{ route('admin.edit-akun.update', ['id' => $user->id]) }}" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        {{-- Info pengguna (read-only) --}}
        <div class="bg-[#f8fffe] border-[2px] border-[#e0f5f3] rounded-2xl px-5 py-3.5">
            <label class="text-[0.75rem] font-bold text-[#888] block mb-1 uppercase tracking-wide">Nama Pengguna</label>
            <p class="text-[1rem] font-semibold text-[#1a1a1a]">{{ $user->name }}</p>
        </div>

        {{-- Email --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Alamat Email</label>
            <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Role --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Role Akses</label>
            <select name="role" required class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium cursor-pointer">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="bk" {{ $user->role == 'bk' ? 'selected' : '' }}>BK / Konselor</option>
                <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
        </div>

        {{-- Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" placeholder="Password Baru"
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Save Button (Triggers Edit Modal) --}}
        <div class="mt-4">
            <button type="button" onclick="showConfirmEditModal()"
                    class="w-full py-4 bg-[#1a7a70] text-white rounded-full text-[1.1rem] font-bold shadow-[0_4px_16px_rgba(26,122,112,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

{{-- ===== KONFIRMASI EDIT AKUN MODAL ===== --}}
<div id="confirmEditModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmEditModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">

        {{-- Illustration --}}
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin edit akun?</p>

        <div class="flex gap-5 w-full justify-center mt-2">
            {{-- Button OK (Submit Edit Form) --}}
            <button type="button" onclick="submitEditForm()"
                    class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                </svg>
            </button>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideConfirmEditModal()"
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
function showConfirmEditModal() {
    const form = document.getElementById('editAkunForm');
    if (form.checkValidity()) {
        document.getElementById('confirmEditModal').classList.remove('hidden');
        document.getElementById('confirmEditModal').classList.add('flex');
    } else {
        form.reportValidity();
    }
}

function hideConfirmEditModal() {
    document.getElementById('confirmEditModal').classList.add('hidden');
    document.getElementById('confirmEditModal').classList.remove('flex');
}

function submitEditForm() {
    document.getElementById('editAkunForm').submit();
}
</script>
@endpush
