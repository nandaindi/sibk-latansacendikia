@extends('layouts.guest')

@section('title', 'Reset Password – Bimbingan Konseling')

@section('content')
<div class="flex flex-col md:flex-row flex-1 w-full min-h-screen bg-white overflow-hidden">

    <!-- ── LEFT PANEL ── -->
    <div class="flex-1 bg-[#f0fafa] flex flex-col items-center justify-center pt-10 px-7 pb-7 md:py-12 md:px-10 gap-7 relative overflow-hidden min-h-auto md:min-h-screen before:content-[''] before:absolute before:-top-20 before:-left-20 before:w-[260px] before:h-[260px] before:rounded-full before:bg-[rgba(26,148,136,0.07)] after:content-[''] after:absolute after:-bottom-[60px] after:-right-[60px] after:w-[200px] after:h-[200px] after:rounded-full after:bg-[rgba(26,148,136,0.07)]">
        
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50%       { transform: translateY(-10px); }
            }
        </style>
        <div class="w-[200px] md:w-[280px] h-auto relative z-10 animate-[float_4s_ease-in-out_infinite] [&>svg]:w-full [&>svg]:h-auto">
            {!! file_get_contents(public_path('img/login.svg')) !!}
        </div>

        <div class="text-center relative z-10 w-full font-caveat mt-2 text-black">
            <p class="text-[1.4rem] leading-[1.4]">Bersama BK, setiap cerita adalah awal.</p>
            <p class="text-[1.2rem] leading-[1.4]">Setiap langkah kecil adalah gerbang menuju perubahan besar.</p>
        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="flex-1 flex flex-col justify-center bg-white min-h-auto md:min-h-screen pt-8 px-7 pb-12 md:py-14 md:px-[12%]">
        <div class="text-center">
            <h1 class="text-[1.6rem] md:text-[2rem] font-bold text-[#1a1a1a] mb-2">Reset Password</h1>
            <p class="text-[0.875rem] text-[#888] mb-9">Silakan masukkan password baru Anda</p>
        </div>

        @if ($errors->any())
            <div class="bg-[#fff0f0] border border-[#ffc5c5] rounded-[10px] py-3 px-4 text-[0.84rem] text-[#c0392b] mb-5">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" novalidate>
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email (Hidden or Read-only) -->
            <div class="relative mb-[22px]">
                <label class="block text-[0.82rem] font-semibold text-[#555] mb-2 tracking-[0.3px]" for="email">Email</label>
                <div class="relative">
                    <span class="absolute left-[14px] top-1/2 -translate-y-1/2 text-[#aaa] pointer-events-none">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full py-[13px] pr-[14px] pl-[42px] border-[1.5px] border-[#e0e0e0] rounded-[10px] text-[0.9rem] font-sans text-[#333] bg-[#f0f0f0] transition-all duration-250 outline-none @error('email') border-[#e74c3c] @enderror"
                        value="{{ $email ?? old('email') }}"
                        readonly
                        required
                    >
                </div>
            </div>

            <!-- Password -->
            <div class="relative mb-[22px]">
                <label class="block text-[0.82rem] font-semibold text-[#555] mb-2 tracking-[0.3px]" for="password">Password Baru</label>
                <div class="relative">
                    <span class="absolute left-[14px] top-1/2 -translate-y-1/2 text-[#aaa] pointer-events-none">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full py-[13px] pr-[44px] pl-[42px] border-[1.5px] border-[#e0e0e0] rounded-[10px] text-[0.9rem] font-sans text-[#333] bg-[#fafafa] transition-all duration-250 outline-none focus:border-[#1a9488] focus:shadow-[0_0_0_3px_rgba(26,148,136,0.12)] focus:bg-white @error('password') border-[#e74c3c] @enderror"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    <button type="button" onclick="togglePassword('password', 'icon-eye-off-1', 'icon-eye-1')" class="absolute right-[12px] top-1/2 -translate-y-1/2 bg-transparent border-none text-[#aaa] cursor-pointer p-1 hover:text-[#1a9488] transition-colors duration-200">
                        <svg id="icon-eye-off-1" class="block" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg id="icon-eye-1" class="hidden" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="relative mb-[30px]">
                <label class="block text-[0.82rem] font-semibold text-[#555] mb-2 tracking-[0.3px]" for="password_confirmation">Konfirmasi Password Baru</label>
                <div class="relative">
                    <span class="absolute left-[14px] top-1/2 -translate-y-1/2 text-[#aaa] pointer-events-none">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </span>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full py-[13px] pr-[44px] pl-[42px] border-[1.5px] border-[#e0e0e0] rounded-[10px] text-[0.9rem] font-sans text-[#333] bg-[#fafafa] transition-all duration-250 outline-none focus:border-[#1a9488] focus:shadow-[0_0_0_3px_rgba(26,148,136,0.12)] focus:bg-white"
                        placeholder="Ulangi password baru"
                        required
                    >
                    <button type="button" onclick="togglePassword('password_confirmation', 'icon-eye-off-2', 'icon-eye-2')" class="absolute right-[12px] top-1/2 -translate-y-1/2 bg-transparent border-none text-[#aaa] cursor-pointer p-1 hover:text-[#1a9488] transition-colors duration-200">
                        <svg id="icon-eye-off-2" class="block" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg id="icon-eye-2" class="hidden" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-[14px] bg-gradient-to-br from-[#1a9488] to-[#14b8a6] text-white border-none rounded-xl text-[0.95rem] font-semibold font-sans cursor-pointer tracking-[0.3px] transition-all duration-150 ease-out shadow-[0_4px_18px_rgba(26,148,136,0.35)] hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(26,148,136,0.45)] hover:brightness-105 active:translate-y-0">Reset Password</button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, eyeOffId, eyeOnId) {
        const input   = document.getElementById(inputId);
        const eyeOff  = document.getElementById(eyeOffId);
        const eyeOn   = document.getElementById(eyeOnId);

        if (input.type === 'password') {
            input.type = 'text';
            eyeOff.classList.remove('block');
            eyeOff.classList.add('hidden');
            eyeOn.classList.remove('hidden');
            eyeOn.classList.add('block');
        } else {
            input.type = 'password';
            eyeOff.classList.remove('hidden');
            eyeOff.classList.add('block');
            eyeOn.classList.remove('block');
            eyeOn.classList.add('hidden');
        }
    }
</script>
@endpush
