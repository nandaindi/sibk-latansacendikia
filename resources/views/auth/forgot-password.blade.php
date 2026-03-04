@extends('layouts.guest')

@section('title', 'Lupa Password – Bimbingan Konseling')

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
            <p class="text-[1.2rem] leading-[1.4]">Lupa password bukan akhir dari segalanya.</p>
        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="flex-1 flex flex-col justify-center bg-white min-h-auto md:min-h-screen pt-8 px-7 pb-12 md:py-14 md:px-[12%]">
        <div class="text-center">
            <h1 class="text-[1.6rem] md:text-[2rem] font-bold text-[#1a1a1a] mb-2">Lupa Password</h1>
            <p class="text-[0.875rem] text-[#888] mb-9">Masukkan email Anda untuk menerima link reset password</p>
        </div>

        @if (session('status'))
            <div class="bg-[#e8f5e9] border border-[#a5d6a7] rounded-[10px] py-3 px-4 text-[0.84rem] text-[#2e7d32] mb-5">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-[#fff0f0] border border-[#ffc5c5] rounded-[10px] py-3 px-4 text-[0.84rem] text-[#c0392b] mb-5">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            <!-- Email Address -->
            <div class="relative mb-[22px]">
                <label class="block text-[0.82rem] font-semibold text-[#555] mb-2 tracking-[0.3px]" for="email">Alamat Email</label>
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
                        class="w-full py-[13px] pr-[14px] pl-[42px] border-[1.5px] border-[#e0e0e0] rounded-[10px] text-[0.9rem] font-sans text-[#333] bg-[#fafafa] transition-all duration-250 outline-none focus:border-[#1a9488] focus:shadow-[0_0_0_3px_rgba(26,148,136,0.12)] focus:bg-white @error('email') border-[#e74c3c] @enderror"
                        value="{{ old('email') }}"
                        placeholder="Masukkan alamat email"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <div class="text-[0.78rem] text-[#e74c3c] mt-[5px]">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full py-[14px] bg-gradient-to-br from-[#1a9488] to-[#14b8a6] text-white border-none rounded-xl text-[0.95rem] font-semibold font-sans cursor-pointer tracking-[0.3px] transition-all duration-150 ease-out shadow-[0_4px_18px_rgba(26,148,136,0.35)] hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(26,148,136,0.45)] hover:brightness-105 active:translate-y-0">
                Kirim Link Reset
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-[0.85rem] text-[#1a9488] hover:underline font-semibold">Kembali ke Login</a>
            </div>
        </form>
    </div>

</div>
@endsection
