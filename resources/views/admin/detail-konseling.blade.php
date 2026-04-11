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
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-start gap-6 md:gap-10 shadow-sm">
        {{-- Illustration --}}
        <div class="w-32 md:w-48 shrink-0 flex items-center justify-center">
            <img src="{{ asset('img/Stationery and physics book for education.svg') }}" alt="Brain Power" class="w-full h-auto object-contain">
        </div>
        
        {{-- Details --}}
        <div class="flex flex-col gap-2 w-full">
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Nama</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ $konseling->user->name ?? 'User Tidak Ditemukan' }}</span>
            </div>
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Date</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($konseling->tanggal)->format('l, d F Y') }}</span>
            </div>
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Type</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a] capitalize">{{ $konseling->jenis }}</span>
            </div>
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">Status</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a] capitalize">{{ $konseling->status }}</span>
            </div>
            @if($konseling->bk_id)
            <div class="flex items-start text-[0.95rem] md:text-[1.1rem]">
                <span class="font-bold text-[#1a1a1a] w-[70px] shrink-0">BK</span>
                <span class="font-bold text-[#1a1a1a] px-2">:</span>
                <span class="font-bold text-[#1a1a1a]">{{ $konseling->bk->name ?? 'Guru Tidak Ditemukan' }}</span>
            </div>
            @endif

            @if($konseling->catatan_bk)
            <div class="mt-6 pt-6 border-t border-[#eee]">
                @php
                    $note = $konseling->catatan_bk;
                    $problem = '';
                    $solution = '';
                    $additional = '';

                    if (preg_match('/Problem:\s*(.*?)(?=Solution:|Note:|$)/s', $note, $matches)) {
                        $problem = trim($matches[1]);
                    }
                    if (preg_match('/Solution:\s*(.*?)(?=Note:|$)/s', $note, $matches)) {
                        $solution = trim($matches[1]);
                    }
                    if (preg_match('/Note:\s*(.*)/s', $note, $matches)) {
                        $additional = trim($matches[1]);
                    }

                    if (empty($problem) && empty($solution) && !empty($note)) {
                        $problem = $note;
                    }
                @endphp

                <div class="flex flex-col gap-6">
                    <span class="font-extrabold text-[#1a9488] text-[0.85rem] uppercase tracking-[0.2em] mb-1">Catatan Guru BK</span>
                    
                    @if($problem)
                    <div class="bg-amber-50/40 p-5 rounded-2xl border border-amber-100/40">
                        <div class="text-amber-800 font-extrabold text-[0.82rem] mb-2 uppercase tracking-widest">
                            PERMASALAHAN SISWA
                        </div>
                        <div class="text-[1rem] text-[#1a1a1a] leading-loose">{{ $problem }}</div>
                    </div>
                    @endif

                    @if($solution)
                    <div class="bg-emerald-50/40 p-5 rounded-2xl border border-emerald-100/40">
                        <div class="text-emerald-800 font-extrabold text-[0.82rem] mb-2 uppercase tracking-widest">
                            PENANGANAN / SOLUSI
                        </div>
                        <div class="text-[1rem] text-[#1a1a1a] leading-loose">{{ $solution }}</div>
                    </div>
                    @endif

                    @if($additional)
                    <div class="bg-gray-50/60 p-5 rounded-2xl border border-gray-100/60 ">
                        <div class="text-gray-700 font-extrabold text-[0.82rem] mb-2 uppercase tracking-widest">
                            CATATAN TAMBAHAN
                        </div>
                        <div class="text-[0.95rem] text-[#555] italic leading-relaxed">{{ $additional }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($konseling->kesimpulan_siswa)
            <div class="mt-4 pt-4 border-t border-[#eee]">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <span class="font-bold text-[#1a9488] text-[0.85rem] uppercase tracking-wider">Kesimpulan Siswa:</span>
                        <span class="text-[0.95rem] text-[#555] italic">"{{ $konseling->kesimpulan_siswa }}"</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="font-bold text-[#1a9488] text-[0.85rem] uppercase tracking-wider">Saran Siswa:</span>
                        <span class="text-[0.95rem] text-[#555] italic">"{{ $konseling->saran_siswa }}"</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>

@endsection
