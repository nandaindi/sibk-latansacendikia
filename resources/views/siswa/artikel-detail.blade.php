@extends('layouts.siswa')

@section('title', $artikel->judul . ' – Artikel Edukasi')

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
    .artikel-body h1 { font-size: 2rem; }
    .artikel-body h2 { font-size: 1.5rem; border-left: 4px solid #1a9488; padding-left: 0.75rem; }
    .artikel-body h3 { font-size: 1.25rem; color: #1a9488; }
    .artikel-body p {
        color: #444;
        line-height: 1.85;
        margin-bottom: 1.2rem;
        font-size: 1.05rem;
    }
    .artikel-body ul, .artikel-body ol {
        margin: 1rem 0 1.2rem 1.5rem;
        color: #444;
        line-height: 1.85;
    }
    .artikel-body ul { list-style: disc; }
    .artikel-body ol { list-style: decimal; }
    .artikel-body li { margin-bottom: 0.35rem; font-size: 1.05rem; }
    .artikel-body a {
        color: #1a9488;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .artikel-body blockquote {
        border-left: 4px solid #1a9488;
        background: #f0fdf9;
        padding: 1rem 1.25rem;
        margin: 1.5rem 0;
        border-radius: 0 12px 12px 0;
        color: #2c6e68;
        font-style: italic;
    }
    .artikel-body img {
        max-width: 100%;
        border-radius: 12px;
        margin: 1.5rem auto;
        display: block;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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
    .artikel-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        font-size: 0.95rem;
    }
    .artikel-body th {
        background: #e0f5f3;
        color: #0f5f59;
        font-weight: 700;
        padding: 0.75rem 1rem;
        border: 1px solid #c7ece8;
        text-align: left;
    }
    .artikel-body td {
        padding: 0.65rem 1rem;
        border: 1px solid #edf2f1;
        color: #444;
    }
    .artikel-body tr:nth-child(even) td { background: #fafdfb; }
    .artikel-body hr {
        border: none;
        border-top: 2px dashed #e0f5f3;
        margin: 2rem 0;
    }
</style>
@endpush

@section('content')
<div class="w-full max-w-7xl mx-auto px-4 pb-16 pt-2">

    <article class="bg-white rounded-[24px] overflow-hidden shadow-[0_8px_40px_rgba(0,0,0,0.06)] border border-[#edf2f1]">

        @if($artikel->gambar)
            <div class="w-full h-[220px] md:h-[420px] overflow-hidden bg-[#e0f5f3]">
                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-full h-[180px] md:h-[280px] bg-gradient-to-br from-[#e0f5f3] via-[#c7ece8] to-[#a8ddd8] flex items-center justify-center">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="1.5" class="opacity-40"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
        @endif

        <div class="px-6 py-8 md:px-12 md:py-10">

            <h1 class="text-[1.65rem] md:text-[2.25rem] font-extrabold text-[#1a1a1a] leading-[1.25] mb-8 tracking-tight">
                {{ $artikel->judul }}
            </h1>

            <div class="w-16 h-1 bg-gradient-to-r from-[#1a9488] to-[#c7ece8] rounded-full mb-8"></div>

            <div class="artikel-body">
                {!! $artikel->konten !!}
            </div>

        </div>

    </article>
</div>
@endsection
