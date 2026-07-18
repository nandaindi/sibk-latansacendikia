@extends('layouts.bk')

@section('title', 'Profil Saya – BK')

@section('content')

<div class="w-full max-w-2xl mx-auto px-5 md:px-0 py-4 mb-24 md:mb-8">

    <div class="flex items-center gap-3 mb-6">
        <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Profil Saya</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 px-5 py-3 bg-[#e0f5f3] text-[#1a7a70] rounded-xl font-semibold border-[2px] border-[#1a9488]">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('bk.profile.update') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        {{-- Profile Avatar Section --}}
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

        <div class="my-3">
            <h3 class="text-[1.1rem] font-bold text-[#1a1a1a] border-b-[2px] border-[#eee] pb-2">Pengaturan Akun</h3>
        </div>

        {{-- Email (Editable) --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all group">
            <label class="flex items-center gap-1.5 text-[0.8rem] text-[#1a9488] font-bold mb-1 uppercase tracking-wider transition-colors"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg> Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>
        @error('email')<span class="text-red-500 text-sm px-2">{{ $message }}</span>@enderror



        {{-- Change Password Section --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all group relative">
            <label class="flex items-center gap-1.5 text-[0.8rem] text-[#1a9488] font-bold mb-1 uppercase tracking-wider transition-colors"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Ganti Password <span class="text-[0.7rem] font-normal lowercase text-[#1a9488]/70">(Kosongkan jika tidak ingin mengubah)</span></label>
            <div class="flex items-center">
                <input type="password" name="password" id="passInput" placeholder="Min. Min 8 karakter" minlength="8" maxlength="8"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium pr-10"/>
                <button type="button" onclick="togglePassword('passInput', 'eyeIcon1')" class="absolute right-5 bottom-3.5 text-[#aaa] hover:text-[#1a9488] transition-colors focus:outline-none border-none bg-transparent cursor-pointer">
                    <svg id="eyeIcon1" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>
        @error('password')<span class="text-red-500 text-sm px-2">{{ $message }}</span>@enderror

        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all group relative">
            <label class="flex items-center gap-1.5 text-[0.8rem] text-[#1a9488] font-bold mb-1 uppercase tracking-wider transition-colors"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Konfirmasi Password Baru</label>
            <div class="flex items-center">
                <input type="password" name="password_confirmation" id="passConfirmInput" placeholder="Ulangi Password" minlength="8" maxlength="8"
                       class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium pr-10"/>
                <button type="button" onclick="togglePassword('passConfirmInput', 'eyeIcon2')" class="absolute right-5 bottom-3.5 text-[#aaa] hover:text-[#1a9488] transition-colors focus:outline-none border-none bg-transparent cursor-pointer">
                    <svg id="eyeIcon2" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="mt-6 flex justify-end pb-8">
            <button type="submit"
                    class="w-full sm:w-auto px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1.05rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95 border-none cursor-pointer">
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

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>
@endpush
