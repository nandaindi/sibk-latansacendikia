@extends('layouts.admin')

@section('title', 'Tambah Data Siswa – Admin')

@section('content')

<div class="w-full">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.data-siswa') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Tambah Data Siswa</h2>
    </div>

    <form id="tambahSiswaForm" method="POST" action="{{ route('admin.data-siswa.store') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Section: Data Diri Siswa --}}
        <div class="mb-2">
            <h3 class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Data Diri Siswa
            </h3>

            {{-- Nama Lengkap --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Nama lengkap siswa" value="{{ old('nama') }}" required
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- NIS --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">NIS / NISN</label>
                <input type="text" name="nis" placeholder="Nomor Induk Siswa" value="{{ old('nis') }}" required
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Kelas & Jurusan (Row) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Kelas</label>
                    <select name="kelas" class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium cursor-pointer">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>
                <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Jurusan</label>
                    <select name="jurusan" class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium cursor-pointer">
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="IPA" {{ old('jurusan') == 'IPA' ? 'selected' : '' }}>IPA</option>
                        <option value="IPS" {{ old('jurusan') == 'IPS' ? 'selected' : '' }}>IPS</option>
                    </select>
                </div>
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

            {{-- Tempat & Tanggal Lahir --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Contoh: Surabaya" value="{{ old('tempat_lahir') }}"
                           class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
                </div>
                <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                    <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] bg-transparent font-medium"/>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" placeholder="Alamat lengkap siswa"
                          class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium resize-none">{{ old('alamat') }}</textarea>
            </div>

            {{-- Telepon Siswa --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">No. Telepon / WhatsApp Siswa</label>
                <input type="text" name="telepon" placeholder="Contoh: 08123456789" value="{{ old('telepon') }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>
        </div>

        {{-- Section: Data Orang Tua --}}
        <div class="mb-2">
            <h3 class="text-[0.85rem] font-bold text-[#1a9488] uppercase tracking-wider mb-3 flex items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Data Orang Tua / Wali
            </h3>

            {{-- Nama Ortu --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all mb-3">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Nama Orang Tua / Wali</label>
                <input type="text" name="nama_ortu" placeholder="Nama orang tua atau wali" value="{{ old('nama_ortu') }}"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
            </div>

            {{-- Telepon Ortu --}}
            <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">No. Telepon Orang Tua / Wali</label>
                <input type="text" name="telepon_ortu" placeholder="Contoh: 08198765432" value="{{ old('telepon_ortu') }}"
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
        <p class="text-[1.05rem] font-bold text-[#1a1a1a] text-center">Apakah anda yakin tambah data siswa?</p>
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
    const form = document.getElementById('tambahSiswaForm');
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
    document.getElementById('tambahSiswaForm').submit();
}
</script>
@endpush
