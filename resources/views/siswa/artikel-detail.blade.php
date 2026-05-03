@extends('layouts.siswa')

@section('title', $artikel->judul . ' – Artikel Edukasi BK')

@push('styles')
<style>
    .artikel-body h1, .artikel-body h2, .artikel-body h3,
    .artikel-body h4, .artikel-body h5, .artikel-body h6 {
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1.3;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
    }
    .artikel-body h1 { font-size: 1.9rem; }
    .artikel-body h2 { font-size: 1.45rem; border-left: 4px solid #1a9488; padding-left: 0.85rem; }
    .artikel-body h3 { font-size: 1.2rem; color: #1a9488; }
    .artikel-body p {
        color: #3a3a3a;
        line-height: 1.9;
        margin-bottom: 1.25rem;
        font-size: 1rem;
    }
    .artikel-body ul, .artikel-body ol {
        margin: 1rem 0 1.25rem 1.5rem;
        color: #3a3a3a;
        line-height: 1.9;
    }
    .artikel-body ul { list-style: disc; }
    .artikel-body ol { list-style: decimal; }
    .artikel-body li { margin-bottom: 0.4rem; font-size: 1rem; }
    .artikel-body a { color: #1a9488; text-decoration: underline; text-underline-offset: 3px; }
    .artikel-body blockquote {
        border-left: 4px solid #1a9488;
        background: #f0fdf9;
        padding: 1rem 1.25rem;
        margin: 1.75rem 0;
        border-radius: 0 14px 14px 0;
        color: #2c6e68;
        font-style: italic;
        font-size: 1rem;
    }
    .artikel-body img {
        max-width: 100%;
        border-radius: 14px;
        margin: 1.75rem auto;
        display: block;
        box-shadow: 0 6px 24px rgba(0,0,0,0.08);
    }
    .artikel-body strong { color: #1a1a1a; }
    .artikel-body em { color: #555; }
    .artikel-body pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 1.25rem;
        border-radius: 12px;
        overflow-x: auto;
        font-size: 0.9rem;
        margin: 1.5rem 0;
    }
    .artikel-body code {
        background: #e0f5f3;
        color: #1a9488;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.9em;
    }
    .artikel-body table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; font-size: 0.95rem; }
    .artikel-body th { background: #e0f5f3; color: #0f5f59; font-weight: 700; padding: 0.75rem 1rem; border: 1px solid #c7ece8; text-align: left; }
    .artikel-body td { padding: 0.65rem 1rem; border: 1px solid #edf2f1; color: #444; }
    .artikel-body tr:nth-child(even) td { background: #fafdfb; }
    .artikel-body hr { border: none; border-top: 2px dashed #e0f5f3; margin: 2rem 0; }
</style>
@endpush

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 pb-20 pt-2">

    {{-- Back Button --}}
    <div class="mb-5">
        <a href="{{ route('siswa.artikel.index') }}"
           class="inline-flex items-center gap-2 text-[0.85rem] font-semibold text-[#555] hover:text-[#1a9488] transition-colors no-underline group">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="group-hover:-translate-x-0.5 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Artikel
        </a>
    </div>

    <article class="bg-white rounded-[24px] overflow-hidden shadow-[0_8px_40px_rgba(0,0,0,0.06)] border border-[#edf2f1]">

        {{-- Cover Image --}}
        @if($artikel->gambar)
            <div class="w-full h-[200px] md:h-[360px] overflow-hidden bg-[#e0f5f3]">
                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-full h-[140px] md:h-[200px] bg-gradient-to-br from-[#e0f5f3] via-[#c7ece8] to-[#a8ddd8] flex items-center justify-center">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="1.5" class="opacity-40"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
        @endif

        <div class="px-6 py-8 md:px-10 md:py-10">

            {{-- Category / Tag --}}
            <div class="mb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e6f7f5] text-[#1a9488] text-[0.72rem] font-bold rounded-full uppercase tracking-wide">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Artikel Edukasi BK
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-[1.4rem] md:text-[1.9rem] font-extrabold text-[#1a1a1a] leading-[1.3] mb-5 tracking-tight">
                {{ $artikel->judul }}
            </h1>

            {{-- Meta Info --}}
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 pb-5 mb-6 border-b border-[#f0f0f0]">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-[#1a9488] flex items-center justify-center text-white text-[0.65rem] font-black shrink-0">
                        {{ strtoupper(substr($artikel->penulis->name ?? 'BK', 0, 2)) }}
                    </div>
                    <span class="text-[0.82rem] font-semibold text-[#444]">{{ $artikel->penulis->name ?? 'Guru BK' }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-[0.8rem] text-[#888]">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $artikel->created_at->translatedFormat('d F Y') }}
                </div>
                @php
                    $wordCount = str_word_count(strip_tags($artikel->konten));
                    $readTime  = max(1, ceil($wordCount / 200));
                @endphp
                <div class="flex items-center gap-1.5 text-[0.8rem] text-[#888]">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $readTime }} menit baca
                </div>
            </div>

            {{-- Article Body --}}
            <div class="artikel-body">
                {!! $artikel->konten !!}
            </div>

            {{-- Footer Navigation --}}
            <div class="mt-10 pt-6 border-t border-[#f0f0f0] flex items-center justify-between flex-wrap gap-3">
                <a href="{{ route('siswa.artikel.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#f4faf9] text-[#1a9488] text-[0.85rem] font-bold rounded-xl hover:bg-[#e6f7f5] transition-colors no-underline">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Artikel Lainnya
                </a>
                <a href="{{ route('siswa.dashboard') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1a9488] text-white text-[0.85rem] font-bold rounded-xl hover:bg-[#157a70] transition-colors no-underline">
                    Kembali ke Beranda
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </a>
            </div>

        </div>
    </article>
</div>
@endsection
