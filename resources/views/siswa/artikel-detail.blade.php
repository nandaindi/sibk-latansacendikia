@extends('layouts.siswa')

@section('title', $artikel->judul . ' – Artikel Edukasi BK')

@push('styles')
<style>
    .artikel-body {
    }
    .artikel-body h1, .artikel-body h2, .artikel-body h3,
    .artikel-body h4, .artikel-body h5, .artikel-body h6 {
        font-weight: 800; color: #1a1a1a; line-height: 1.4;
        margin-top: 2.5rem; margin-bottom: 1rem; text-align: left;
    }
    .artikel-body h1 { font-size: 1.7rem; }
    .artikel-body h2 { font-size: 1.35rem; border-left: 4px solid #1a9488; padding-left: 1rem; }
    .artikel-body h3 { font-size: 1.15rem; color: #1a9488; }
    .artikel-body p {
        color: #2a2a2a; line-height: 1.85; margin-bottom: 1.4rem;
        font-size: 1.05rem;
    }
    .artikel-body .ql-align-center { text-align: center; }
    .artikel-body .ql-align-justify { text-align: justify; }
    .artikel-body .ql-align-right { text-align: right; }
    .artikel-body .ql-align-left { text-align: left; }
    .artikel-body ul, .artikel-body ol {
        margin: 1.25rem 0 1.5rem 1.5rem; color: #2a2a2a; line-height: 1.85;
    }
    .artikel-body ul { list-style: disc; }
    .artikel-body ol { list-style: decimal; }
    .artikel-body li { margin-bottom: 0.5rem; font-size: 1.05rem; }
    .artikel-body a { color: #1a9488; text-decoration: underline; text-underline-offset: 3px; font-weight: 600; }
    .artikel-body blockquote {
        border-left: 4px solid #1a9488; background: #f0fdf9;
        padding: 1.25rem 1.5rem; margin: 2rem 0; border-radius: 0 14px 14px 0;
        color: #2c6e68; font-style: italic; font-size: 1.05rem; line-height: 1.8;
    }
    .artikel-body img {
        max-width: 100%; border-radius: 14px; margin: 2rem auto; display: block;
    }
    .artikel-body strong { color: #1a1a1a; }
    .artikel-body code { background: #e0f5f3; color: #1a9488; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
    .artikel-body table { width: 100%; border-collapse: collapse; margin: 2rem 0; font-size: 0.95rem; }
    .artikel-body th { background: #e0f5f3; color: #0f5f59; font-weight: 700; padding: 0.75rem 1rem; border: 1px solid #c7ece8; }
    .artikel-body td { padding: 0.65rem 1rem; border: 1px solid #edf2f1; color: #444; }
    .artikel-body hr { border: none; border-top: 1px solid #e5e7eb; margin: 2.5rem 0; }
</style>
@endpush

@section('content')
<div class="flex flex-col flex-1 pb-[90px] md:pb-10">

    {{-- All content in one centered column --}}
    <div class="w-full max-w-[720px] mx-auto px-5 md:px-8 py-6 md:py-10">

        {{-- Cover Image (inside container, rounded) --}}
        @if($artikel->gambar)
        <div class="w-full aspect-[16/9] rounded-2xl overflow-hidden bg-[#e0f5f3] mb-8">
            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
        </div>
        @endif

        {{-- Title --}}
        <h1 class="text-[1.5rem] md:text-[2rem] font-black text-[#111] leading-[1.2] mb-4 tracking-[-0.02em]">
            {{ $artikel->judul }}
        </h1>

        {{-- Meta --}}
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[0.82rem] text-[#999] font-medium mb-8 pb-6 border-b border-[#edf2f1]">
            <span class="text-[#555] font-semibold">{{ $artikel->penulis->name ?? 'Guru BK' }}</span>
            <span class="text-[#ddd]">·</span>
            <span>{{ $artikel->created_at->translatedFormat('d F Y') }}</span>
            @php
                $readTime = max(1, ceil(str_word_count(strip_tags($artikel->konten)) / 200));
            @endphp
            <span class="text-[#ddd]">·</span>
            <span>{{ $readTime }} menit baca</span>
        </div>

        {{-- Article Body --}}
        <div class="artikel-body">
            {!! $artikel->konten !!}
        </div>

        {{-- Footer --}}
        <div class="mt-14 pt-6 border-t border-[#edf2f1] flex items-center justify-between">
            <a href="{{ route('siswa.artikel.index') }}" class="inline-flex items-center gap-1.5 text-[#1a9488] text-[0.88rem] font-bold hover:text-[#12635a] transition-colors no-underline">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Artikel Lainnya
            </a>
            <a href="{{ route('siswa.dashboard') }}" class="text-[#aaa] text-[0.82rem] font-medium hover:text-[#1a9488] transition-colors no-underline">
                Beranda
            </a>
        </div>

    </div>

</div>
@endsection
