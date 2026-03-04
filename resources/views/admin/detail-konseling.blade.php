@extends('layouts.admin')

@section('title', 'Detail Konseling – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Konseling</h2>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium">
            Kelola Data/Detail
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 md:gap-10 shadow-sm">
        {{-- Illustration --}}
        <div class="w-32 md:w-48 shrink-0 flex items-center justify-center">
            <img src="{{ asset('img/Stationery and physics book for education.svg') }}" alt="Brain Power" class="w-full h-auto object-contain">
        </div>
        
        {{-- Details --}}
        <div class="flex flex-col gap-2 w-full">
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Nama</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Nanda Indi Lestari</span>
            </div>
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Date</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Minggu, 7 Juli 2025</span>
            </div>
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Type</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Online</span>
            </div>
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Status</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Disetujui</span>
            </div>
        </div>
    </div>

</div>

@endsection
