@extends('layouts.admin')

@section('title', 'Tambah Data Guru BK – Admin')

@section('content')

<div class="w-full">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.data-bk') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Tambah Data Guru BK</h2>
    </div>

    <form id="tambahBkForm" method="POST" action="{{ route('admin.data-bk.store') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Section: Info Akun --}}
        <div class="mb-2">
            <h3 class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Info Akun Login
            </h3>

            {{-- Email --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Email</label>
                <input type="email" name="email" placeholder="Contoh: guru@email.com" value="{{ old('email') }}" required
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Password --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Password</label>
                <input type="password" name="password" placeholder="Min. 6 karakter" required
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>
        </div>

        {{-- Section: Data Diri Guru BK --}}
        <div class="mb-2">
            <h3 class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Data Diri Guru BK
            </h3>

            {{-- Nama --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Lengkap (beserta Gelar)</label>
                <input type="text" name="nama" placeholder="Contoh: Dr. Ahmad Hidayat, S.Pd." value="{{ old('nama') }}" required
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- NIP --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">NIP / NUPTK (Opsional)</label>
                <input type="text" name="nip" placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium cursor-pointer">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- Jabatan --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Jabatan / Spesialisasi</label>
                <input type="text" name="jabatan" placeholder="Contoh: Guru BK Kelas X, Koordinator BK" value="{{ old('jabatan') }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Alamat --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" placeholder="Alamat lengkap guru"
                          class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium resize-none">{{ old('alamat') }}</textarea>
            </div>

            {{-- Telepon --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">No. Telepon / WhatsApp</label>
                <input type="text" name="telepon" placeholder="Contoh: 08123456789" value="{{ old('telepon') }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end mt-2">
            <button type="button" onclick="showConfirmModal()"
                    class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95">
                Simpan
            </button>
        </div>
    </form>

</div>

{{-- Confirm Modal --}}
<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[400px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-32 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>
        <p class="text-[1.05rem] font-bold text-[#1a1a1a] text-center">Apakah anda yakin tambah data guru BK?</p>
        <div class="flex gap-4 w-full justify-center mt-2">
            <button type="button" onclick="submitForm()"
                    class="h-[46px] px-8 bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            </button>
            <button type="button" onclick="hideConfirmModal()"
                    class="h-[46px] px-8 bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showConfirmModal() {
    const form = document.getElementById('tambahBkForm');
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
    document.getElementById('tambahBkForm').submit();
}
</script>
@endpush
