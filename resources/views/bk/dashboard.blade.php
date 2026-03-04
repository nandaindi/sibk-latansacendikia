@extends('layouts.bk')

@section('title', 'Dashboard BK – Bimbingan Konseling')

@section('content')
<main class="w-full px-4 md:px-6 py-8 flex-1 flex flex-col gap-8">



    {{-- Menu Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <!-- Card 1: Panggil Siswa -->
        <a href="{{ route('bk.panggil-siswa') }}" class="no-underline group">
            <div class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-[0_8px_30px_rgba(26,148,136,0.12)] hover:-translate-y-1 transition-all flex items-center p-5 gap-5">
                <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] flex items-center justify-center shrink-0">
                    <img src="{{ asset('img/Phone conversation with speech bubble.svg') }}" alt="Panggil Siswa" class="h-10 object-contain transition-transform group-hover:scale-110">
                </div>
                <div>
                    <div class="text-[1.1rem] font-bold text-[#1a1a1a] group-hover:text-[#1a9488] transition-colors mb-1">Panggil Siswa</div>
                    <div class="text-[0.85rem] text-[#777]">Jadwalkan sesi offline dengan siswa.</div>
                </div>
            </div>
        </a>

        <!-- Card 2: Daftar Pengajuan -->
        <a href="{{ route('bk.daftar-pengajuan') }}" class="no-underline group">
            <div class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-[0_8px_30px_rgba(26,148,136,0.12)] hover:-translate-y-1 transition-all flex items-center p-5 gap-5">
                <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] flex items-center justify-center shrink-0 relative">
                    <img src="{{ asset('img/High-priority tasks.svg') }}" alt="Daftar Pengajuan" class="h-10 object-contain transition-transform group-hover:scale-110">
                    @if($pendingCount > 0)
                    <div class="absolute -top-1.5 -right-1.5 w-6 h-6 bg-[#f59e0b] text-white text-[0.75rem] font-bold rounded-full flex items-center justify-center border-2 border-white shadow-sm">{{ $pendingCount }}</div>
                    @endif
                </div>
                <div>
                    <div class="text-[1.1rem] font-bold text-[#1a1a1a] group-hover:text-[#1a9488] transition-colors mb-1">Daftar Pengajuan</div>
                    <div class="text-[0.85rem] text-[#777]">Tinjau dan proses permintaan siswa.</div>
                </div>
            </div>
        </a>

        <!-- Card 3: Sesi Konseling -->
        <a href="{{ route('bk.sesi-konseling') }}" class="no-underline group">
            <div class="bg-white rounded-[20px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-[0_8px_30px_rgba(26,148,136,0.12)] hover:-translate-y-1 transition-all flex items-center p-5 gap-5">
                <div class="w-16 h-16 rounded-2xl bg-[#e0f5f3] flex items-center justify-center shrink-0">
                    <img src="{{ asset('img/Brainstorming and generating ideas online.svg') }}" alt="Sesi Konseling" class="h-10 object-contain transition-transform group-hover:scale-110">
                </div>
                <div>
                    <div class="text-[1.1rem] font-bold text-[#1a1a1a] group-hover:text-[#1a9488] transition-colors mb-1">Sesi Aktif</div>
                    <div class="text-[0.85rem] text-[#777]">Sesi konseling yang telah disetujui.</div>
                </div>
            </div>
        </a>
    </div>

    {{-- Main Content 2 Columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Jadwal Hari Ini --}}
        <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[1.1rem] font-bold text-[#1a1a1a] flex items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Jadwal Hari Ini
                </h3>
                <a href="{{ route('bk.sesi-konseling') }}" class="text-sm text-[#1a9488] font-bold hover:underline">Lihat Semua</a>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($jadwalHariIni as $jadwal)
                <div class="p-4 rounded-xl border border-[#eee] bg-[#fcfdfd] flex items-center justify-between hover:border-[#1a9488] transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-[#e0f5f3] border-2 border-[#1a9488] shrink-0">
                            @if($jadwal->user->avatar)
                                <img src="{{ asset('storage/' . $jadwal->user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-bold text-[#1a9488]">{{ strtoupper(substr($jadwal->user->name, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="font-bold text-[#1a1a1a] text-[1rem]">{{ $jadwal->user->name }}</div>
                            <div class="text-[0.85rem] text-[#777]">{{ $jadwal->user->kelas ?? '-' }} {{ $jadwal->user->jurusan ?? '' }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="inline-block px-3 py-1 mb-1 rounded-full text-[0.75rem] font-bold capitalize {{ $jadwal->jenis == 'online' ? 'bg-[#e0eff5] text-[#1a7394]' : 'bg-[#f5e0ef] text-[#941a73]' }}">
                            {{ $jadwal->jenis }}
                        </div>
                        <div class="text-[0.85rem] font-bold text-[#1a1a1a]">{{ $jadwal->waktu ? \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') . ' WIB' : 'TBA' }}</div>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-[#888] font-medium bg-[#fcfdfd] rounded-xl border border-dashed border-[#ddd]">
                    Tidak ada jadwal konseling hari ini.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Perlu Tindakan (Pending) --}}
        <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[1.1rem] font-bold text-[#1a1a1a] flex items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Menunggu Persetujuan
                </h3>
                <a href="{{ route('bk.daftar-pengajuan') }}" class="text-sm text-[#1a9488] font-bold hover:underline">Lihat Antrean</a>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($pendingRequests as $pending)
                <div class="p-4 rounded-xl border border-[#eee] bg-[#fcfdfd] flex items-center justify-between hover:border-[#f59e0b] transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#fdf3e1] flex items-center justify-center font-bold text-[#f59e0b] shrink-0">
                            {{ strtoupper(substr($pending->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-[#1a1a1a] text-[1rem] truncate max-w-[150px] md:max-w-[200px]">{{ $pending->user->name }}</div>
                            <div class="text-[0.8rem] text-[#777]">Diajukan: {{ $pending->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <a href="{{ route('bk.validasi-pengajuan', ['id' => $pending->id]) }}" class="px-3 py-1.5 md:px-4 md:py-2 bg-[#fdf3e1] text-[#f59e0b] text-[0.85rem] font-bold rounded-lg hover:bg-[#fde6c1] transition-colors whitespace-nowrap no-underline">
                        Tinjau
                    </a>
                </div>
                @empty
                <div class="py-10 text-center text-[#888] font-medium bg-[#fcfdfd] rounded-xl border border-dashed border-[#ddd]">
                    Antrean kosong. Semua pengajuan sudah diproses!
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Artikel Edukasi --}}
    <div class="mt-2">
        <div class="flex items-center justify-between mb-5 flex-wrap gap-2">
            <h3 class="text-[1.1rem] md:text-[1.2rem] font-bold text-[#1a1a1a] flex items-center gap-2">
                Artikel Edukasi Terbaru
            </h3>
        </div>
        
        <!-- Horizontal scroll on mobile, Grid on Web -->
        <div class="flex overflow-x-auto lg:grid lg:grid-cols-4 gap-4 md:gap-6 hide-scroll snap-x snap-mandatory pb-4">
            @forelse($articles as $artikel)
            <a href="{{ route('bk.artikel.index') }}" class="bg-white rounded-[20px] p-4 flex flex-col gap-3 no-underline border border-[#edf2f1] transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(0,0,0,0.06)] shadow-[0_4px_12px_rgba(0,0,0,0.02)] shrink-0 w-[240px] lg:w-auto snap-start cursor-pointer group">
                @if($artikel->gambar)
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="h-[120px] w-full object-cover rounded-xl transition-transform group-hover:scale-105">
                @else
                    <div class="h-[120px] w-full bg-[#e0f5f3] flex items-center justify-center rounded-xl transition-transform group-hover:scale-105">
                        <img src="{{ asset('img/flying delivery robot saluting.svg') }}" alt="Artikel" class="h-[80px] object-contain opacity-50">
                    </div>
                @endif
                <div>
                    <div class="text-[1rem] font-bold text-[#1a1a1a] line-clamp-2 leading-tight" title="{{ $artikel->judul }}">{{ $artikel->judul }}</div>
                    <div class="text-[0.8rem] text-[#777] mt-1">{{ $artikel->created_at->diffForHumans() }}</div>
                </div>
            </a>
            @empty
            <div class="col-span-1 lg:col-span-4 text-center py-8 text-[#888] font-medium bg-white rounded-[20px] border border-[#edf2f1]">
                Belum ada artikel edukasi terbaru.
            </div>
            @endforelse
        </div>
    </div>

</main>
@endsection
