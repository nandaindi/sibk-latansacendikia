@extends('layouts.siswa')

@section('title', 'Artikel Edukasi – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[90px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Artikel Edukasi</h2>
    </div>

    {{-- List --}}
    <div class="w-full px-4 md:px-6 py-5">

        @if($articles->isEmpty())
            <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">
                Belum ada artikel edukasi.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($articles as $artikel)
                <a href="{{ route('siswa.artikel.show', $artikel->slug) }}" class="bg-white border-[2px] border-[#1a9488] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow no-underline group flex flex-col">
                    {{-- Thumbnail --}}
                    <div class="w-full aspect-[16/9] overflow-hidden bg-[#e0f5f3] shrink-0">
                        @if($artikel->gambar)
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <img src="{{ asset('img/flying delivery robot saluting.svg') }}" alt="" class="h-20 opacity-50">
                            </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="px-4 py-4 flex flex-col gap-2 flex-1">
                        <span class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider">{{ $artikel->created_at->format('d M Y') }}</span>
                        <h3 class="text-[0.95rem] font-bold text-[#1a1a1a] leading-snug line-clamp-2 group-hover:text-[#1a9488] transition-colors">{{ $artikel->judul }}</h3>
                        <p class="text-[0.82rem] text-[#888] leading-relaxed line-clamp-2 mt-auto">{{ Str::limit(strip_tags($artikel->konten), 100) }}</p>
                        <div class="border-t border-[#edf2f1] pt-3 mt-2 flex items-center justify-between">
                            <span class="text-[0.75rem] text-[#888] font-medium">{{ $artikel->penulis->name ?? 'Guru BK' }}</span>
                            <span class="text-[#1a9488] text-[0.82rem] font-semibold no-underline hover:text-[#12635a] transition-colors">
                                Baca
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
