@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Profile Section --}}
<section class="mb-8">
    <h2 class="text-[1.2rem] flex flex-col font-extrabold text-[#1a1a1a] mb-4">Profile</h2>
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-6 py-5 flex items-center gap-5 shadow-sm w-full">
        {{-- Avatar --}}
        <div class="w-16 h-16 shrink-0 rounded-full bg-[#1a9488] flex items-center justify-center text-white">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>
        {{-- Info --}}
        <div class="flex flex-col gap-1">
            <p class="text-[0.97rem] font-bold text-[#1a1a1a]">Nama : {{ auth()->user()->name }}</p>
            <p class="text-[0.97rem] font-bold text-[#1a1a1a]">Email &nbsp;: {{ auth()->user()->email }}</p>
            <p class="text-[0.97rem] font-bold text-[#1a1a1a]">Status: Admin</p>
        </div>
    </div>
</section>

{{-- Information Cards --}}
<section>
    <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a] mb-4">Information</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 w-full">

        {{-- Kelola Akun Card --}}
        <a href="{{ route('admin.kelola-akun') }}"
           class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="#1a9488" class="group-hover:scale-105 transition-transform">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                <circle cx="19" cy="19" r="4" fill="#1a9488" stroke="white" stroke-width="0.5"/>
                <path d="M19 17v4M17 19h4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <p class="text-[0.95rem] font-extrabold text-[#1a9488] text-center leading-tight">Kelola Akun<br><span class="text-[1.1rem]">{{ $akunsCount }}</span></p>
        </a>

        {{-- Kelola Data Card --}}
        <a href="{{ route('admin.kelola-data') }}"
           class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" class="group-hover:scale-105 transition-transform">
                <ellipse cx="12" cy="5" rx="8" ry="3" fill="#1a9488"/>
                <path d="M4 5v4c0 1.7 3.6 3 8 3s8-1.3 8-3V5" fill="#1a9488" opacity="0.8"/>
                <path d="M4 9v4c0 1.7 3.6 3 8 3s8-1.3 8-3V9" fill="#1a9488" opacity="0.6"/>
                <path d="M4 13v4c0 1.7 3.6 3 8 3s8-1.3 8-3v-4" fill="#1a9488" opacity="0.4"/>
                <circle cx="19" cy="19" r="4" fill="#1a9488"/>
                <path d="M19 17v4M17 19h4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <p class="text-[0.95rem] font-extrabold text-[#1a9488] text-center leading-tight">Kelola Data<br><span class="text-[1.1rem]">{{ $konselingsCount }}</span></p>
        </a>

        {{-- Kelola Laporan Card --}}
        <a href="{{ route('admin.kelola-laporan') }}"
           class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 flex flex-col items-center gap-3 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all no-underline group">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" class="group-hover:scale-105 transition-transform">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="#1a9488" opacity="0.2" stroke="#1a9488" stroke-width="1.5"/>
                <polyline points="14 2 14 8 20 8" stroke="#1a9488" stroke-width="1.5" fill="none"/>
                <line x1="8" y1="13" x2="16" y2="13" stroke="#1a9488" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="8" y1="17" x2="12" y2="17" stroke="#1a9488" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="19" cy="19" r="4" fill="#1a9488"/>
                <path d="M19 17v4M17 19h4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <p class="text-[0.95rem] font-extrabold text-[#1a9488] text-center leading-tight">Kelola Laporan<br><span class="text-[1.1rem]">{{ $laporansCount }}</span></p>
        </a>

    </div>
</section>

@endsection
