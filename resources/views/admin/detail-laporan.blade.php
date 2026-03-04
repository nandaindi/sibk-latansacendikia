@extends('layouts.admin')

@section('title', 'Detail Laporan – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-2">
        <div>
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Laporan</h2>
            
            {{-- Action Buttons --}}
            <div class="flex gap-4 mt-3">
                <button class="w-10 h-10 md:w-11 md:h-11 bg-[#1eb808] text-white rounded-[10px] flex items-center justify-center hover:brightness-105 transition-all shadow-sm">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-bold lowercase">
            kelola laporan/detail
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white border-[2px] border-[#1a9488] bg-opacity-70 backdrop-blur-md rounded-[20px] p-6 lg:p-8 flex flex-col sm:flex-row items-center gap-6 md:gap-8 shadow-sm mb-6">
        {{-- Avatar Area --}}
        <div class="w-24 h-24 md:w-32 md:h-32 shrink-0 rounded-full bg-[#1a7a70] flex items-center justify-center text-white p-2">
            <svg viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>
        
        {{-- Details --}}
        <div class="flex flex-col gap-1.5 md:gap-2 text-[1.1rem] md:text-[1.2rem]">
            <div class="flex items-start">
                <span class="font-bold text-[#1a1a1a] w-[85px] shrink-0">Nama</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Laporan 1</span>
            </div>
            <div class="flex items-start">
                <span class="font-bold text-[#1a1a1a] w-[85px] shrink-0">Autor</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Ibu Eni Kustiyorini S.Psi</span>
            </div>
            <div class="flex items-start">
                <span class="font-bold text-[#1a1a1a] w-[85px] shrink-0">Date</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">Minggu, 2 Juli 2025</span>
            </div>
        </div>
    </div>

    {{-- Data List inside Detail --}}
    <div class="flex flex-col gap-3">
        @php
        $items = [
            ['nama' => 'Nanda Indi Lestari', 'tanggal' => 'Minggu, 2 Juli 2025', 'type' => 'Online'],
            ['nama' => 'Nanda Indi Lestari', 'tanggal' => 'Minggu, 2 Juli 2025', 'type' => 'offline'],
            ['nama' => 'Nanda Indi Lestari', 'tanggal' => 'Minggu, 2 Juli 2025', 'type' => 'Online'],
            ['nama' => 'Nanda Indi Lestari', 'tanggal' => 'Minggu, 2 Juli 2025', 'type' => 'offline'],
        ];
        @endphp

        @foreach($items as $item)
        <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 flex items-center justify-between gap-4 shadow-sm hover:shadow-md transition-shadow">
            <span class="text-[0.95rem] text-[#555] flex-1 min-w-[150px]">{{ $item['nama'] }}</span>
            <span class="text-[0.9rem] text-[#555] flex-1 text-center hidden md:block">{{ $item['tanggal'] }}</span>
            <span class="text-[0.9rem] text-[#555] flex-1 text-center capitalize">{{ $item['type'] }}</span>
            <a href="#" class="text-[#1a9488] text-[0.95rem] font-bold shrink-0 text-right no-underline hover:text-[#12635a] transition-colors">
                Detail
            </a>
        </div>
        @endforeach
    </div>

</div>

@endsection
