@extends('layouts.bk')

@section('title', $artikel->judul . ' – Preview Artikel')

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
    .artikel-body a { color: #1a9488; text-decoration: underline; text-underline-offset: 3px; }
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
<main class="w-full px-4 md:px-6 py-6 flex-1 flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-3">

        {{-- Row 1: Back + Actions --}}
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('bk.artikel.index') }}"
               class="inline-flex items-center gap-2 text-[0.85rem] font-semibold text-[#555] hover:text-[#1a9488] transition-colors no-underline group">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="group-hover:-translate-x-0.5 transition-transform"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Artikel
            </a>
        </div>
    </div>

    {{-- Article Content --}}
    <div class="max-w-3xl mx-auto w-full">
        <article class="bg-white rounded-[24px] overflow-hidden shadow-[0_8px_40px_rgba(0,0,0,0.06)] border border-[#edf2f1]">

            {{-- Cover Image --}}
            @if($artikel->gambar)
                <div class="w-full h-[220px] md:h-[380px] overflow-hidden bg-[#e0f5f3]">
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-full h-[160px] md:h-[220px] bg-gradient-to-br from-[#e0f5f3] via-[#c7ece8] to-[#a8ddd8] flex items-center justify-center">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="1.5" class="opacity-40"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            @endif

            <div class="px-6 py-8 md:px-10 md:py-10">

                {{-- Meta: Author & Date --}}
                <div class="flex items-center gap-3 pb-5 mb-5 border-b border-[#f0f0f0]">
                    <div class="w-8 h-8 rounded-full bg-[#1a9488] flex items-center justify-center text-white text-[0.72rem] font-black shrink-0">
                        {{ strtoupper(substr($artikel->penulis->name ?? 'BK', 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[0.82rem] font-bold text-[#1a1a1a]">{{ $artikel->penulis->name ?? 'Guru BK' }}</div>
                        <div class="text-[0.72rem] text-[#999]">{{ $artikel->created_at->format('d M Y') }} · Dibuat oleh Anda</div>
                    </div>
                </div>

                <h1 class="text-[1.5rem] md:text-[2rem] font-extrabold text-[#1a1a1a] leading-[1.25] mb-4 tracking-tight">
                    {{ $artikel->judul }}
                </h1>

                <div class="w-16 h-1 bg-gradient-to-r from-[#1a9488] to-[#c7ece8] rounded-full mb-8"></div>

                <div class="artikel-body">
                    {!! $artikel->konten !!}
                </div>

                {{-- Footer Actions --}}
                <div class="mt-10 pt-6 border-t border-[#f0f0f0] flex items-center justify-between flex-wrap gap-3">
                    <a href="{{ route('bk.artikel.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#f4faf9] text-[#1a9488] text-[0.85rem] font-bold rounded-xl hover:bg-[#e6f7f5] transition-colors no-underline">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Daftar Artikel
                    </a>
                    <a href="{{ route('bk.artikel.edit', $artikel->id) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white text-[0.85rem] font-bold rounded-xl hover:bg-amber-600 transition-colors no-underline">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Artikel Ini
                    </a>
                </div>

            </div>
        </article>
    </div>

</main>
@endsection
