@extends('layouts.bk')

@section('title', 'Detail Laporan – BK')

@section('content')

<div id="main-content" class="w-full px-4 md:px-6 py-6 pb-[100px] md:pb-10 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
        <div>
            <a href="{{ route('bk.laporan-konseling') }}" class="flex items-center gap-2 text-[0.85rem] font-bold text-[#1a9488] hover:translate-x-[-4px] transition-transform mb-2 no-underline">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                Kembali ke Daftar Laporan
            </a>
            <h1 class="text-[2rem] md:text-[2.6rem] font-black text-[#1a1a1a] tracking-tight leading-tight">Laporan Konseling Detail</h1>
            <p class="text-[1rem] text-[#888] font-bold mt-1">Dokumentasi lengkap hasil sesi bimbingan untuk Sesi #{{ $laporan->id }}{{ rand(10,99) }}</p>
        </div>
        
        <button onclick="cetakLaporan()"
                class="px-6 py-3 bg-[#f3f4f6] text-[#4b5563] rounded-xl flex items-center gap-2.5 hover:bg-[#e5e7eb] transition-all border-none cursor-pointer font-extrabold text-[0.9rem] shadow-sm no-print">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/>
            </svg>
            Cetak Laporan
        </button>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- Sidebar (Left) --}}
        <div class="lg:col-span-4 flex flex-col gap-8">
            @forelse($items as $item)
            {{-- Loop for cases where a report might have multiple sessions --}}
            <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] p-8 shadow-sm flex flex-col items-center text-center">
                {{-- Student Avatar --}}
                <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden bg-[#e0f5f3] border-[4px] border-white shadow-xl mb-6">
                    @if($item->user->avatar)
                        <img src="{{ asset('storage/' . $item->user->avatar) }}" alt="Student Avatar" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl font-black text-[#1a9488]">{{ substr($item->user->name, 0, 1) }}</div>
                    @endif
                </div>
                
                <h3 class="text-[1.3rem] font-black text-[#1a1a1a] leading-tight">{{ $item->user->name }}</h3>
                <p class="text-[0.9rem] text-[#888] font-bold mt-1 uppercase tracking-widest">Student ID: {{ $item->user->nis ?? $item->user->nomor_induk ?? '2023-001-' . $item->user->id }}</p>

                <div class="w-full h-[2px] bg-[#f8fafc] my-6"></div>

                <div class="w-full flex flex-col gap-4">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-10 h-10 rounded-xl bg-[#e0f5f3] flex items-center justify-center text-[#1a9488] shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="text-[0.65rem] font-black text-[#aaa] uppercase tracking-wider">Tanggal Sesi</div>
                            <div class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($item->tanggal)->format('d F, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <div class="text-[0.65rem] font-black text-[#aaa] uppercase tracking-wider">Durasi</div>
                            <div class="text-[0.95rem] font-bold text-[#1a1a1a]">{{ $item->durasi ?? 45 }} Menit</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Counselor Section --}}
            <div class="bg-[#f9fafb] border-[1px] border-[#f0f0f0] rounded-[24px] p-6">
                <label class="text-[0.7rem] font-black text-[#aaa] uppercase tracking-[0.15em] mb-4 block">Konselor yang Bertugas</label>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-[#1a9488] border-[3px] border-white shadow-sm shrink-0">
                        @if($item->bk->avatar)
                            <img src="{{ asset('storage/' . $item->bk->avatar) }}" alt="Konselor" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center font-bold text-white">{{ substr($item->bk->name ?? 'BK', 0, 1) }}</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-[1rem] font-black text-[#1a1a1a] leading-tight">{{ $item->bk->name ?? 'Guru BK' }}</div>
                        <div class="text-[0.75rem] text-[#777] font-bold">Guru Pembimbing & Konseling</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content (Right) --}}
        <div class="lg:col-span-8 flex flex-col gap-8">
            @php
                // Parsing logic
                $note = $item->catatan_bk;
                $problem = ''; $solution = ''; $additional = '';
                if (preg_match('/Problem:\s*(.*?)(?=Solution:|Note:|$)/s', $note, $matches)) { $problem = trim($matches[1]); }
                if (preg_match('/Solution:\s*(.*?)(?=Note:|$)/s', $note, $matches)) { $solution = trim($matches[1]); }
                if (preg_match('/Note:\s*(.*)/s', $note, $matches)) { $additional = trim($matches[1]); }
                if (empty($problem) && empty($solution) && !empty($note)) { $problem = $note; }
            @endphp
            <div class="flex flex-col gap-10">
                {{-- 1. Problem Description --}}
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-[#111] px-1">
                        <h3 class="text-[0.9rem] font-black uppercase tracking-[0.2em]">Deskripsi Permasalahan</h3>
                    </div>
                    <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] shadow-sm overflow-hidden flex flex-col p-8 md:p-10 group animate-[fadeInUp_0.4s_ease-out]">
                        <div class="flex flex-col gap-6">
                            <div class="text-[1.05rem] text-[#333] leading-[1.8] font-medium max-w-3xl">
                                {!! nl2br(e($problem)) !!}
                            </div>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @php
                                    $pType = $item->problem_type ?? 'umum';
                                    $typeMap = [
                                        'akademik' => ['label' => 'Masalah Akademik', 'color' => 'bg-gray-50 text-gray-600 border-gray-200'],
                                        'sosial'   => ['label' => 'Masalah Sosial', 'color' => 'bg-gray-50 text-gray-600 border-gray-200'],
                                        'keluarga' => ['label' => 'Masalah Keluarga', 'color' => 'bg-gray-50 text-gray-600 border-gray-200'],
                                        'karir'    => ['label' => 'Perencanaan Karir', 'color' => 'bg-gray-50 text-gray-600 border-gray-200'],
                                        'lainnya'  => ['label' => 'Masalah Lainnya', 'color' => 'bg-gray-50 text-gray-600 border-gray-200'],
                                        'umum'     => ['label' => 'Konseling Umum', 'color' => 'bg-gray-50 text-gray-400 border-gray-200'],
                                    ];
                                    $currentType = $typeMap[$pType] ?? $typeMap['umum'];
                                @endphp
                                <span class="px-4 py-1.5 {{ $currentType['color'] }} border-[1px] text-[0.7rem] font-black rounded-full uppercase tracking-widest transition-all">
                                    {{ $currentType['label'] }}
                                </span>
                                
                                @if($item->jenis == 'online')
                                    <span class="px-4 py-1.5 bg-gray-50 text-gray-500 border-[1px] border-gray-200 text-[0.7rem] font-black rounded-full uppercase tracking-widest">Pertemuan Virtual</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Solution & Action --}}
                @if($solution)
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-[#111] px-1">
                        <h3 class="text-[0.9rem] font-black uppercase tracking-[0.2em]">Solusi & Tindakan</h3>
                    </div>
                    <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] shadow-sm overflow-hidden flex flex-col p-8 md:p-10 group animate-[fadeInUp_0.5s_ease-out]">
                        <div class="flex flex-col gap-5">
                            <div class="flex flex-col gap-2">
                                <div class="text-[1rem] text-[#333] leading-relaxed font-bold">
                                    {!! nl2br(e($solution)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- 3. Additional Notes --}}
                @if($additional)
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-[#111] px-1">
                        <h3 class="text-[0.9rem] font-black uppercase tracking-[0.2em]">Catatan Tambahan</h3>
                    </div>
                    <div class="bg-white border-[2px] border-[#edf2f1] rounded-[32px] shadow-sm overflow-hidden flex flex-col p-8 md:p-10 group animate-[fadeInUp_0.6s_ease-out]">
                        <div class="bg-[#fcfdfd] rounded-2xl p-6 border border-[#edf2ff] border-dashed">
                            <p class="text-[1.05rem] text-[#555] font-medium leading-[1.8] italic">
                                "{!! nl2br(e($additional)) !!}"
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- 4. Student Feedback (Refleksi) --}}
                @if($item->kesimpulan_siswa)
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2 text-[#111] px-1">
                        <div class="w-2 h-6 bg-[#1a9488] rounded-full"></div>
                        <h3 class="text-[0.9rem] font-black uppercase tracking-[0.2em]">Refleksi & Feedback Siswa</h3>
                    </div>
                    <div class="bg-white border-[2px] border-[#1a9488]/30 rounded-[32px] shadow-sm overflow-hidden flex flex-col p-8 md:p-10 group animate-[fadeInUp_0.7s_ease-out]">
                        <div class="flex flex-col gap-6">
                            <div>
                                <label class="text-[0.7rem] font-black text-[#1a9488] uppercase tracking-widest block mb-2">Kesimpulan Siswa</label>
                                <div class="text-[1.05rem] text-[#333] leading-[1.8] font-medium italic">
                                    "{!! nl2br(e($item->kesimpulan_siswa)) !!}"
                                </div>
                            </div>
                            
                            @if($item->saran_siswa)
                            <div class="pt-6 border-t border-[#edf2f1]">
                                <label class="text-[0.7rem] font-black text-[#1a9488] uppercase tracking-widest block mb-2">Saran Untuk Layanan BK</label>
                                <div class="text-[0.95rem] text-[#555] leading-relaxed">
                                    {!! nl2br(e($item->saran_siswa)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif



                @if(!$solution && !$additional)
                    <div class="bg-white border-[1px] border-[#eee] rounded-[32px] p-10 text-center animate-[fadeInUp_0.5s_ease-out]">
                        <p class="text-[#bbb] font-bold italic">Tidak ada catatan solusi atau tambahan yang direkam untuk sesi ini.</p>
                    </div>
                @endif
            </div>
        </div>
            @empty
            <div class="text-center py-12 text-[#888] font-medium bg-white rounded-[24px] border border-[#eee] shadow-sm">
                <svg class="mx-auto mb-3 opacity-20" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                Belum ada data sesi pada laporan ini.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Area cetak – disiapkan statis dan hanya muncul saat window.print() --}}
<div id="printArea">
    <div class="pr-header">
        <h1>Detailed Counseling Report</h1>
        <div class="pr-subtitle">Layanan Bimbingan Konseling &ndash; SMK Latansa Cendekia</div>
    </div>
    
    <div class="pr-section">
        <h2 class="pr-section-title">Informasi Laporan</h2>
        <div class="pr-field"><label>Nama Laporan</label><span>: {{ $laporan->nama_laporan }}</span></div>
        <div class="pr-field"><label>Penulis (BK)</label><span>: {{ $laporan->author->name ?? 'BK' }}</span></div>
        <div class="pr-field"><label>Tanggal Terbit</label><span>: {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span></div>
    </div>

    <div class="pr-section">
        <h2 class="pr-section-title">Detail Sesi</h2>
        <div class="pr-log-container">
            @forelse($items as $item)
            <div class="pr-log-item" style="border-bottom: 2px solid #f0f0f0; padding-bottom: 20px; margin-bottom: 20px;">
                <div class="pr-log-title" style="font-size: 1.1rem; font-weight: 800; color: #1a9488; margin-bottom: 10px;">
                    Siswa: {{ $item->user->name }} ({{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }})
                </div>
                <div class="pr-log-content" style="line-height: 1.6; color: #444;">
                    {!! nl2br(e($item->catatan_bk)) !!}
                </div>

            </div>
            @empty
            <div class="pr-field" style="font-style: italic;">Belum ada sesi pada laporan ini.</div>
            @endforelse
        </div>
    </div>

    <div class="pr-footer" style="margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; font-size: 0.8rem; color: #999;">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</div>

@endsection

@push('styles')
<style>
/* Sembunyikan printArea saat normal */
#printArea { display: none; }

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

@media print {
    /* Hide layout elements explicitly */
    aside, header, nav, .no-print, #app-wrapper, #main-content { display: none !important; }
    
    body { background: white !important; margin: 0; padding: 0; }

    #printWrap {
        display: block !important;
        font-family: 'Inter', sans-serif, Arial;
        padding: 40px;
        color: #1a1a1a;
        width: 100%;
        background: white;
    }
    #printWrap .pr-header {
        border-bottom: 5px solid #1a9488;
        padding-bottom: 20px;
        margin-bottom: 40px;
    }
    #printWrap .pr-header h1 {
        font-size: 2rem;
        font-weight: 900;
        color: #1a1a1a;
        margin: 0;
    }
    #printWrap .pr-section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1a9488;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 20px;
    }
    #printWrap .pr-field { margin-bottom: 10px; display: flex; gap: 20px; font-size: 0.95rem; }
    #printWrap .pr-field label { font-weight: 800; min-width: 150px; }
}
</style>
@endpush

@push('scripts')
<script>
function cetakLaporan() {
    // Hide original body children
    const children = Array.from(document.body.children);
    children.forEach(child => {
        if(child.tagName !== 'SCRIPT' && child.id !== 'printWrap') {
            child.dataset.originalDisplay = child.style.display;
            child.style.display = 'none';
        }
    });

    // Create or get print container
    let printWrap = document.getElementById('printWrap');
    if(!printWrap) {
        printWrap = document.createElement('div');
        printWrap.id = 'printWrap';
        document.body.appendChild(printWrap);
    }

    // Assign content
    printWrap.innerHTML = document.getElementById('printArea').innerHTML;
    printWrap.style.display = 'block';

    // Print
    window.print();

    // Restore
    printWrap.style.display = 'none';
    printWrap.innerHTML = '';
    children.forEach(child => {
        if(child.tagName !== 'SCRIPT' && child.id !== 'printWrap') {
            child.style.display = child.dataset.originalDisplay || '';
        }
    });
}
</script>
@endpush
