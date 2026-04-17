@extends('layouts.siswa')

@section('title', 'Profil Saya – Siswa')

@section('content')

<div class="w-full max-w-2xl mx-auto py-4 mb-20 md:mb-0">

    {{-- Title --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-[1.5rem] md:text-[2rem] font-extrabold text-[#1a1a1a] tracking-tight">Profil<span class="text-[#1a9488]"> Saya</span></h2>
    </div>

    @if(session('success'))
        <div class="mb-4 px-5 py-3 bg-[#e0f5f3] text-[#1a7a70] rounded-xl font-semibold border-[2px] border-[#1a9488]">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('siswa.profile.update') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        {{-- Avatar Upload Ui --}}
        <div class="flex flex-col items-center justify-center mb-4 gap-3 relative w-max mx-auto group">
            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-[#1a9488] shadow-lg relative bg-[#e0f5f3] flex items-center justify-center">
                @if($user->avatar)
                    <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span id="avatarInitials" class="text-3xl font-bold text-[#1a9488]">{{ substr($user->name, 0, 1) }}</span>
                    <img id="avatarPreview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                @endif
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onclick="document.getElementById('avatarInput').click()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </div>
            </div>
            <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" onchange="previewImage(event)">
            <label for="avatarInput" class="text-sm font-semibold text-[#1a9488] cursor-pointer hover:underline">Ubah Foto Profil</label>
            @error('avatar')<span class="text-red-500 text-xs text-center">{{ $message }}</span>@enderror
        </div>

        {{-- Nama --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="block text-[0.8rem] text-[#888] font-bold mb-1 uppercase tracking-wider">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>
        @error('name')<span class="text-red-500 text-sm px-2">{{ $message }}</span>@enderror

        {{-- NIS (Read Only) --}}
        <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
            <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">NIS</label>
            <div class="text-[1rem] text-[#555] font-semibold">{{ $user->nis ?? '-' }}</div>
        </div>

        {{-- Kelas & Jurusan (Read Only) --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
                <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">Kelas</label>
                <div class="text-[1rem] text-[#555] font-semibold">{{ $user->kelas ?? '-' }}</div>
            </div>
            <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
                <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">Jurusan</label>
                <div class="text-[1rem] text-[#555] font-semibold">{{ $user->jurusan ?? '-' }}</div>
            </div>
        </div>

        {{-- Jenis Kelamin & TTL (Read Only) --}}
        <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
            <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">Jenis Kelamin</label>
            <div class="text-[1rem] text-[#555] font-semibold">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
        </div>

        <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
            <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">Tempat, Tanggal Lahir</label>
            <div class="text-[1rem] text-[#555] font-semibold">
                {{ $user->tempat_lahir ?? '-' }}, {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
            </div>
        </div>

        {{-- Alamat (Read Only) --}}
        <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
            <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">Alamat Lengkap</label>
            <div class="text-[1rem] text-[#555] font-semibold leading-relaxed">{{ $user->alamat ?? '-' }}</div>
        </div>

        {{-- Data Orang Tua (Read Only) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
                <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">Nama Orang Tua / Wali</label>
                <div class="text-[1rem] text-[#555] font-semibold">{{ $user->nama_ortu ?? '-' }}</div>
            </div>
            <div class="border-[2px] border-[#eee] rounded-2xl px-5 py-3.5 bg-[#f9f9f9] transition-all">
                <label class="block text-[0.8rem] text-[#aaa] font-bold mb-1 uppercase tracking-wider">No. HP Orang Tua</label>
                <div class="text-[1rem] text-[#555] font-semibold">{{ $user->telepon_ortu ?? '-' }}</div>
            </div>
        </div>

        <div class="my-3">
            <h3 class="text-[1.1rem] font-bold text-[#1a1a1a] border-b-[2px] border-[#eee] pb-2">Pengaturan Akun</h3>
        </div>

        {{-- Email & Telepon (Editable) --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="block text-[0.8rem] text-[#888] font-bold mb-1 uppercase tracking-wider">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>
        @error('email')<span class="text-red-500 text-sm px-2">{{ $message }}</span>@enderror

        {{-- New Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="block text-[0.8rem] text-[#888] font-bold mb-1 uppercase tracking-wider">Ganti Password <span class="text-[0.7rem] font-normal lowercase">(Kosongkan jika tidak ingin mengubah)</span></label>
            <input type="password" name="password" placeholder="Min. 8 Karakter"
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>
        @error('password')<span class="text-red-500 text-sm px-2">{{ $message }}</span>@enderror

        {{-- Confirm Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="block text-[0.8rem] text-[#888] font-bold mb-1 uppercase tracking-wider">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi Password"
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Save Button --}}
        <div class="mt-4 flex justify-end">
            <button type="submit"
                    class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1.05rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const initials = document.getElementById('avatarInitials');
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (initials) initials.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
