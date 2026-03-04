@extends('layouts.siswa')

@section('title', 'Artikel Edukasi – BK Nanda')

@section('content')
<style>
    /* Hero */
    .art-hero {
        background-color: #f1f8eb; /* Warna hijau sangat muda khas lazismu */
        position: relative;
        overflow: hidden;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
    }
    .art-badge {
        display: none;
    }
    .art-accent-bar {
        display: block;
        width: 80px; height: 4px;
        background-color: #1a9488;
        border-radius: 99px;
        margin: 24px auto 0;
    }

    /* Card */
    .art-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.32s cubic-bezier(0.22,1,0.36,1), box-shadow 0.32s ease;
    }
    .art-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 40px rgba(26,148,136,0.1);
    }
    .art-img-wrap { overflow: hidden; background: #e0f5f3; border-top-left-radius: 24px; border-top-right-radius: 24px;}
    .art-img-wrap img { transition: transform 0.55s cubic-bezier(0.22,1,0.36,1); width: 100%; height: 220px; object-fit: cover; }
    .art-card:hover .art-img-wrap img { transform: scale(1.06); }
    .no-img-placeholder {
        width: 100%; height: 220px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #dff3f1, #c7ece8);
    }

    /* Read Link */
    .read-link { transition: color 0.2s, gap 0.2s; display: inline-flex; align-items: center; gap: 4px; }
    .read-link:hover { gap: 7px; color: #0f6b64; }
    .read-link:hover svg { transform: translateX(2px); }
    .read-link svg { transition: transform 0.2s; }
</style>

<div class="flex flex-col flex-1 pb-[90px] md:pb-10">
    
    <section class="art-hero pb-8 px-4 text-center" style="padding-top: 50px;">
        <div class="relative z-10 max-w-2xl mx-auto">
            <h1 style="color:#157a70; font-size:clamp(1.8rem, 5vw, 2.5rem); font-weight:900; line-height:1.2; margin-bottom:16px;">
                Artikel Edukasi<br>Bimbingan Konseling
            </h1>
            <p style="color:#64748b; font-size:1rem; line-height:1.6; max-width:600px; margin:0 auto; font-weight: 500;">
                Temukan informasi terbaru seputar kesehatan mental, pengembangan diri, dan dunia remaja dari tim Guru BK Nanda.
            </p>
            <span class="art-accent-bar"></span>
        </div>
    </section>

    {{-- ── GRID ── --}}
    <section style="padding: 30px 24px 80px; width: 100%; max-width: 1100px; margin: 0 auto;">

        @if($articles->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed" style="border-color:#cbd5e1">
                <img src="{{ asset('img/cute robot using laptop.svg') }}" alt="Kosong" class="h-36 mx-auto mb-6 opacity-40">
                <p style="color:#64748b;font-weight:700;font-size:1rem;">Belum ada artikel edukasi.</p>
                <p style="color:#94a3b8;font-size:0.85rem;margin-top:4px;">Coba cek lagi nanti ya!</p>
            </div>
        @else
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 28px;">
                @foreach($articles as $artikel)
                <div class="art-card">
                    {{-- Thumbnail --}}
                    <a href="{{ route('siswa.artikel.show', $artikel->slug) }}" style="text-decoration:none; display:block;" class="art-img-wrap">
                        @if($artikel->gambar)
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}">
                        @else
                            <div class="no-img-placeholder">
                                <img src="{{ asset('img/flying delivery robot saluting.svg') }}" alt="" style="height:110px;width:auto;opacity:0.65;">
                            </div>
                        @endif
                    </a>

                    {{-- Body --}}
                    <div style="padding:20px 22px 22px; display:flex; flex-direction:column; gap:10px; flex:1;">
                        {{-- Date --}}
                        <span style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;">
                            {{ $artikel->created_at->format('d M Y') }}
                        </span>
                        {{-- Title --}}
                        <h2 style="font-size:1rem;font-weight:800;color:#1e293b;line-height:1.4;margin:0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            <a href="{{ route('siswa.artikel.show', $artikel->slug) }}" style="text-decoration:none;color:inherit;" class="hover:text-[#1a9488] transition-colors">
                                {{ $artikel->judul }}
                            </a>
                        </h2>
                        {{-- Excerpt --}}
                        <p style="font-size:0.85rem;color:#64748b;line-height:1.7;margin:0;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;flex:1;">
                            {{ strip_tags($artikel->konten) }}
                        </p>

                        {{-- Footer --}}
                        <div style="border-top:1px solid #f1f5f9;padding-top:14px;margin-top:auto;display:flex;align-items:center;justify-content:space-between;gap:8px;">
                            <div style="display:flex;align-items:center;gap:8px;min-width:0;">
                                <div style="width:28px;height:28px;border-radius:50%;background:#e0f5f3;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <span style="font-size:0.77rem;color:#64748b;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $artikel->penulis->name ?? 'Guru BK' }}
                                </span>
                            </div>
                            <a href="{{ route('siswa.artikel.show', $artikel->slug) }}"
                               style="font-size:0.78rem;font-weight:800;color:#1a9488;text-decoration:none;white-space:nowrap;flex-shrink:0;"
                               class="read-link">
                                Baca Selengkapnya
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div style="margin-top:40px;text-align:center;">
                {{ $articles->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
