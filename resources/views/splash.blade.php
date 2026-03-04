@extends('layouts.guest')

@section('title', 'Selamat Datang – Bimbingan Konseling')

@section('content')
<div class="flex flex-col flex-1 w-full min-h-screen bg-white items-center justify-center relative overflow-hidden">
    
    <!-- Background styling if any -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- subtle decorations -->
    </div>

    <!-- Main Splash Content -->
    <div class="flex flex-col items-center justify-center h-full w-full z-10 transition-opacity duration-1000 animate-[fadeIn_0.8s_ease-out]">
        <style>
            @keyframes fadeIn {
                0% { opacity: 0; transform: scale(0.95); }
                100% { opacity: 1; transform: scale(1); }
            }
            @keyframes pulseShadow {
                0% { box-shadow: 0 0 0 0 rgba(250, 204, 21, 0.4); }
                70% { box-shadow: 0 0 0 20px rgba(250, 204, 21, 0); }
                100% { box-shadow: 0 0 0 0 rgba(250, 204, 21, 0); }
            }
        </style>

        <!-- Logo Container -->
        <div class="mb-8 p-3 rounded-full bg-white shadow-[0_8px_30px_rgba(0,0,0,0.08)] border-[6px] border-[#facc15] animate-[pulseShadow_2s_infinite]">
            <img src="{{ asset('img/logo latansa 1.png') }}" alt="Logo Latansa" class="w-[180px] md:w-[220px] h-auto object-contain">
        </div>

    </div>

    <!-- Footer Footer -->
    <div class="absolute bottom-8 text-center w-full z-10 animate-[fadeIn_1s_ease-out_0.5s_both]">
        <p class="text-[0.9rem] text-[#1a1a1a] font-bold tracking-wide">Create by Nandaindi</p>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Redirect after a few seconds
    setTimeout(() => {
        // Optional: Add a fade-out effect to the body before redirecting
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '0';
        
        setTimeout(() => {
            @auth
                window.location.href = "{{ session()->get('url.intended', route('siswa.dashboard')) }}";
            @else
                window.location.href = "{{ route('login') }}";
            @endauth
        }, 500); // Wait for fade out to complete
    }, 2500); // 2.5 seconds before starting fade out
</script>
@endpush
