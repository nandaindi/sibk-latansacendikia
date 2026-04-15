@extends('layouts.admin')

@section('title', 'Edit Data Guru BK – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.data-bk') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Edit Data Guru BK</h2>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium">
            Kelola Data / Data BK / Edit
        </div>
    </div>

    <form id="editBkForm" method="POST" action="{{ route('admin.data-bk.update', ['id' => $user->id]) }}" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        {{-- Section: Data Diri Guru BK --}}
        <div class="mb-2">
            <h3 class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Data Diri Guru BK
            </h3>

            {{-- Nama --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Lengkap (beserta Gelar)</label>
                <input type="text" name="nama" value="{{ old('nama', $user->name) }}" required
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- NIP --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">NIP / NUPTK (Opsional)</label>
                <input type="text" name="nip" value="{{ old('nip', $user->nip) }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium cursor-pointer">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Jabatan --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Jabatan / Spesialisasi</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Alamat --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Alamat Lengkap</label>
                <textarea name="alamat" rows="2"
                          class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium resize-none">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            {{-- Telepon --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">No. Telepon / WhatsApp</label>
                <input type="text" name="telepon" value="{{ old('telepon', $user->telepon) }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="mt-4">
            <button type="button" onclick="showConfirmEditModal()"
                    class="w-full py-4 bg-[#1a7a70] text-white rounded-full text-[1.1rem] font-bold shadow-[0_4px_16px_rgba(26,122,112,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

{{-- Confirm Edit Modal --}}
<div id="confirmEditModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmEditModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>
        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin edit data guru BK?</p>
        <div class="flex gap-5 w-full justify-center mt-2">
            <button type="button" onclick="submitEditForm()" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            </button>
            <button type="button" onclick="hideConfirmEditModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showConfirmEditModal() {
    const form = document.getElementById('editBkForm');
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
    document.getElementById('editBkForm').submit();
}
</script>
@endpush
