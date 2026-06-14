@extends('layouts.bk')
@section('title', 'Detail Laporan – BK')

@section('content')
<div class="flex flex-col flex-1 pb-[80px] md:pb-10">

    <!-- Page Header (dark teal) -->
    <div class="bg-[#1a7a70] px-5 md:px-8 py-5 flex items-center justify-between gap-3">
        <h2 class="text-[1.1rem] md:text-[1.3rem] font-bold text-white">Detail Laporan Konseling</h2>
        <div class="flex gap-2 no-print">
            @php $firstItemWithFeedback = $items->firstWhere('kepuasan_penerimaan', '!=', null); @endphp
            @if($firstItemWithFeedback)
            <button onclick="cetakFeedback()" class="px-4 py-2 bg-white/20 text-white rounded-lg text-[0.8rem] font-bold hover:bg-white/30 transition-colors border-none cursor-pointer">
                Cetak Feedback
            </button>
            @endif
            <button onclick="cetakLaporan()" class="px-4 py-2 bg-white/20 text-white rounded-lg text-[0.8rem] font-bold hover:bg-white/30 transition-colors border-none cursor-pointer">
                Cetak Laporan
            </button>
        </div>
    </div>

    <div class="w-full px-4 md:px-6 py-5 flex flex-col gap-4">

        {{-- Back Link --}}
        <a href="{{ route('bk.laporan-konseling') }}" class="flex items-center gap-2 text-[0.85rem] font-semibold text-[#1a9488] hover:translate-x-[-4px] transition-transform no-underline no-print">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Daftar Laporan
        </a>

        @forelse($items as $item)
        @php
            $note = $item->catatan_bk;
            $problem = ''; $solution = ''; $additional = '';
            if (preg_match('/Problem:\s*(.*?)(?=Solution:|Note:|$)/s', $note, $matches)) { $problem = trim($matches[1]); }
            if (preg_match('/Solution:\s*(.*?)(?=Note:|$)/s', $note, $matches)) { $solution = trim($matches[1]); }
            if (preg_match('/Note:\s*(.*)/s', $note, $matches)) { $additional = trim($matches[1]); }
            if (empty($problem) && empty($solution) && !empty($note)) { $problem = $note; }
        @endphp

        {{-- Two Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 items-start">

            {{-- LEFT: Student & Konselor in One Card --}}
            <div class="lg:col-span-2 lg:sticky lg:top-4">
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 shadow-sm flex flex-col gap-4">

                    {{-- Student --}}
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 shrink-0 border border-[#edf2f1] rounded-full overflow-hidden bg-[#e0f5f3]">
                            <img src="{{ $item->user->avatar ? asset('storage/' . $item->user->avatar) : asset('img/default-profile.png') }}" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-[1rem] text-[#1a1a1a]">{{ $item->user->name }}</div>
                            <div class="text-[0.82rem] text-[#888]">{{ $item->user->kelas ?? '-' }} {{ $item->user->jurusan ?? '' }}</div>
                        </div>
                    </div>

                    <div class="border-t border-[#edf2f1]"></div>

                    {{-- Meta --}}
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[0.75rem] font-bold text-[#888] uppercase tracking-wider">Tanggal</span>
                            <span class="text-[0.85rem] font-semibold text-[#1a1a1a]">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                        @if($item->waktu)
                        <div class="flex items-center justify-between">
                            <span class="text-[0.75rem] font-bold text-[#888] uppercase tracking-wider">Waktu</span>
                            <span class="text-[0.85rem] font-semibold text-[#1a9488]">{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-[0.75rem] font-bold text-[#888] uppercase tracking-wider">Jenis</span>
                            <span class="px-2.5 py-0.5 bg-[#e0f5f3] text-[#1a9488] font-medium rounded-full text-[0.72rem] uppercase tracking-wider">{{ $item->jenis == 'online' ? 'Online' : 'Offline' }}</span>
                        </div>
                    </div>

                    <div class="border-t border-[#edf2f1]"></div>

                    {{-- Konselor --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-[#1a9488] shrink-0">
                            @if($item->bk->avatar ?? null)
                                <img src="{{ asset('storage/' . $item->bk->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-bold text-white text-sm">{{ substr($item->bk->name ?? 'BK', 0, 1) }}</div>
                            @endif
                        </div>
                        <div>
                            <div class="text-[0.9rem] font-bold text-[#1a1a1a]">{{ $item->bk->name ?? 'Guru BK' }}</div>
                            <div class="text-[0.75rem] text-[#888]">Konselor</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Content --}}
            <div class="lg:col-span-3 flex flex-col gap-4">

                {{-- Main Notes (Problem + Solution + Notes in One Card) --}}
                @if($problem || $solution || $additional)
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-5 shadow-sm flex flex-col gap-4">

                    @if($problem)
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Deskripsi Permasalahan</label>
                        <div class="text-[0.9rem] text-[#444] leading-relaxed">{!! nl2br(e($problem)) !!}</div>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @php
                                $pType = $item->problem_type ?? 'umum';
                                $typeLabels = ['akademik' => 'Akademik', 'sosial' => 'Sosial', 'keluarga' => 'Keluarga', 'karir' => 'Karir', 'lainnya' => 'Lainnya', 'umum' => 'Umum'];
                            @endphp
                            <span class="px-3 py-1 bg-[#e0f5f3] text-[#1a9488] font-medium rounded-full text-[0.72rem] uppercase tracking-wider">
                                {{ $typeLabels[$pType] ?? 'Umum' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($problem && ($solution || $additional))
                    <div class="border-t border-[#edf2f1]"></div>
                    @endif

                    @if($solution)
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Solusi & Tindakan</label>
                        <div class="text-[0.9rem] text-[#444] leading-relaxed">{!! nl2br(e($solution)) !!}</div>
                    </div>
                    @endif

                    @if($solution && $additional)
                    <div class="border-t border-[#edf2f1]"></div>
                    @endif

                    @if($additional)
                    <div>
                        <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block mb-1">Catatan Tambahan</label>
                        <div class="text-[0.9rem] text-[#555] leading-relaxed italic">"{!! nl2br(e($additional)) !!}"</div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Student Feedback --}}
                @if($item->kesimpulan_siswa || $item->kepuasan_penerimaan)
                <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-5 shadow-sm">
                    <label class="text-[0.7rem] font-bold text-[#1a9488] uppercase tracking-wider block mb-3">Refleksi & Feedback Siswa</label>

                    @if($item->kesimpulan_siswa)
                    <div class="mb-4">
                        <div class="text-[0.75rem] font-bold text-[#888] uppercase tracking-wider mb-1">Kesimpulan Siswa</div>
                        <div class="text-[0.9rem] text-[#444] italic">"{!! nl2br(e($item->kesimpulan_siswa)) !!}"</div>
                    </div>
                    @endif

                    @if($item->saran_siswa)
                    <div class="border-t border-[#edf2f1] my-3"></div>
                    <div class="mb-4">
                        <div class="text-[0.75rem] font-bold text-[#888] uppercase tracking-wider mb-1">Saran Untuk BK</div>
                        <div class="text-[0.9rem] text-[#555]">{!! nl2br(e($item->saran_siswa)) !!}</div>
                    </div>
                    @endif

                    @php
                        $kepuasanItems = [
                            'Penerimaan guru bimbingan dan konseling atau konselor terhadap kehadiran Anda' => $item->kepuasan_penerimaan,
                            'Kemudahan guru bimbingan dan konseling atau konselor untuk diajak curhat' => $item->kepuasan_kemudahan,
                            'Kepercayaan Anda terhadap guru bimbingan dan konseling atau konselor dalam layanan konseling' => $item->kepuasan_kepercayaan,
                            'Pelayanan pemecahan masalah tercapai melalui konseling individual' => $item->kepuasan_pelayanan
                        ];
                    @endphp

                    @if(array_filter($kepuasanItems))
                    <div class="border-t border-[#edf2f1] my-3"></div>
                    <div>
                        <div class="text-[0.75rem] font-bold text-[#888] uppercase tracking-wider mb-3">Kepuasan Siswa</div>
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse text-left">
                                <thead>
                                    <tr class="border-b-2 border-[#edf2f1]">
                                        <th class="py-2 px-2 text-[0.7rem] font-bold text-[#888] uppercase tracking-wider w-8">No</th>
                                        <th class="py-2 px-2 text-[0.7rem] font-bold text-[#888] uppercase tracking-wider">Aspek yang Dinilai</th>
                                        <th class="py-2 px-2 text-[0.7rem] font-bold text-[#888] uppercase tracking-wider text-center whitespace-nowrap">Sangat</th>
                                        <th class="py-2 px-2 text-[0.7rem] font-bold text-[#888] uppercase tracking-wider text-center whitespace-nowrap">Memuaskan</th>
                                        <th class="py-2 px-2 text-[0.7rem] font-bold text-[#888] uppercase tracking-wider text-center whitespace-nowrap">Kurang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($kepuasanItems as $label => $value)
                                        @if($value)
                                        <tr class="border-b border-[#f0f0f0]">
                                            <td class="py-3 px-2 text-[0.85rem] text-[#888] font-semibold align-top">{{ $no }}</td>
                                            <td class="py-3 px-2 text-[0.82rem] text-[#444] leading-snug align-top">{{ $label }}</td>
                                            <td class="py-3 px-2 text-center align-top">
                                                @if($value == 'Sangat Memuaskan')
                                                    <span class="text-green-600 font-bold text-lg">✓</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-2 text-center align-top">
                                                @if($value == 'Memuaskan')
                                                    <span class="text-yellow-600 font-bold text-lg">✓</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-2 text-center align-top">
                                                @if($value == 'Kurang Memuaskan')
                                                    <span class="text-red-500 font-bold text-lg">✓</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $no++; @endphp
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                @if(!$problem && !$solution && !$additional && !($item->kesimpulan_siswa || $item->kepuasan_penerimaan))
                <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">
                    Tidak ada catatan untuk sesi ini.
                </div>
                @endif
            </div>

        </div>

        @empty
        <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">
            Belum ada data sesi pada laporan ini.
        </div>
        @endforelse

    </div>

</div>

{{-- Area cetak – disiapkan statis dan hanya muncul saat window.print() --}}
<div id="printArea">
    <div class="pr-header-kop" style="text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px;">
        <div style="font-size: 14pt; font-weight: bold; font-family: 'Times New Roman', Times, serif;">SMAIT LATANSA CENDEKIA</div>
        <div style="font-size: 10pt; font-family: 'Times New Roman', Times, serif;">Telp: 021-59319100, Email: humas.smaitlc@gmail.com</div>
        <div style="font-size: 10pt; font-family: 'Times New Roman', Times, serif;">Website: sma.latansacendekia.sch.id</div>
    </div>

    <div class="pr-report-title" style="text-align: center; margin-bottom: 30px; font-family: 'Times New Roman', Times, serif;">
        <div style="font-size: 12pt; font-weight: bold; text-transform: uppercase;">{{ strtoupper($laporan->nama_laporan ?? 'LAPORAN PELAKSANAAN LAYANAN KONSELING') }}</div>
        @php
            $tanggalLap = \Carbon\Carbon::parse($laporan->tanggal ?? now());
            $bulan = $tanggalLap->month;
            $tahun = $tanggalLap->year;
            $semester = ($bulan >= 7 && $bulan <= 12) ? 'GANJIL' : 'GENAP';
            $tahunAjaran = ($bulan >= 7) ? $tahun . '/' . ($tahun + 1) : ($tahun - 1) . '/' . $tahun;
        @endphp
        <div style="font-size: 12pt; font-weight: bold; text-transform: uppercase;">SEMESTER {{ $semester }} TAHUN AJARAN {{ $tahunAjaran }}</div>
    </div>

    <table style="width: 100%; font-size: 11pt; margin-bottom: 20px; border-collapse: collapse; font-family: 'Times New Roman', Times, serif;">
        <tr>
            <td style="width: 4%; vertical-align: top; padding-bottom: 5px;">1.</td>
            <td style="width: 26%; vertical-align: top; padding-bottom: 5px;">Nama Konseli</td>
            <td style="width: 3%; vertical-align: top; padding-bottom: 5px;">:</td>
            <td style="vertical-align: top; padding-bottom: 5px;">
                @php $konseliNames = $items->map(fn($item) => $item->user->name)->unique()->implode(', '); @endphp
                {{ $konseliNames ?: '-' }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding-bottom: 5px;">2.</td>
            <td style="vertical-align: top; padding-bottom: 5px;">Kelas</td>
            <td style="vertical-align: top; padding-bottom: 5px;">:</td>
            <td style="vertical-align: top; padding-bottom: 5px;">
                @php 
                    $kelasNames = $items->map(function($item) {
                        return $item->user->kelas->nama_kelas ?? '-';
                    })->filter(fn($val) => $val !== '-')->unique()->implode(', ');
                @endphp
                {{ $kelasNames ?: '-' }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding-bottom: 5px;">3.</td>
            <td style="vertical-align: top; padding-bottom: 5px;">Hari, Tanggal</td>
            <td style="vertical-align: top; padding-bottom: 5px;">:</td>
            <td style="vertical-align: top; padding-bottom: 5px;">
                @php 
                    $firstItem = $items->first();
                    $dateStr = $firstItem ? \Carbon\Carbon::parse($firstItem->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') : '-';
                @endphp
                {{ $dateStr }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding-bottom: 5px;">4.</td>
            <td style="vertical-align: top; padding-bottom: 5px;">Pertemuan Ke</td>
            <td style="vertical-align: top; padding-bottom: 5px;">:</td>
            <td style="vertical-align: top; padding-bottom: 5px;">
                @php 
                    $pertemuanKe = '-';
                    if($firstItem) {
                        $pertemuanKe = \App\Models\Konseling::where('user_id', $firstItem->user_id)
                            ->where('status', 'selesai')
                            ->where('id', '<=', $firstItem->id)
                            ->count();
                    }
                @endphp
                {{ $pertemuanKe }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding-bottom: 5px;">5.</td>
            <td style="vertical-align: top; padding-bottom: 5px;">Waktu</td>
            <td style="vertical-align: top; padding-bottom: 5px;">:</td>
            <td style="vertical-align: top; padding-bottom: 5px;">
                 {{ $firstItem && $firstItem->waktu ? \Carbon\Carbon::parse($firstItem->waktu)->format('H:i') : '-' }} WIB
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding-bottom: 5px;">6.</td>
            <td style="vertical-align: top; padding-bottom: 5px;">Tempat</td>
            <td style="vertical-align: top; padding-bottom: 5px;">:</td>
            <td style="vertical-align: top; padding-bottom: 5px;">
                @if($firstItem)
                    {{ $firstItem->jenis === 'online' ? ($firstItem->link_meet ?? 'Online') : 'Ruang BK' }}
                @else
                    -
                @endif
            </td>
        </tr>

        @php $counter = 7; @endphp
        @forelse($items as $item)
            @php
                $note = $item->catatan_bk;
                $problem = ''; $solution = ''; $additional = '';
                if (preg_match('/Problem:\s*(.*?)(?=Solution:|Note:|$)/s', $note, $matches)) { $problem = trim($matches[1]); }
                if (preg_match('/Solution:\s*(.*?)(?=Note:|$)/s', $note, $matches)) { $solution = trim($matches[1]); }
                if (preg_match('/Note:\s*(.*)/s', $note, $matches)) { $additional = trim($matches[1]); }
                if (empty($problem) && empty($solution) && !empty($note)) { $problem = $note; }
            @endphp
            
            @if($problem)
            <tr>
                <td style="vertical-align: top; padding-bottom: 5px; padding-top: 10px;">{{ $counter++ }}.</td>
                <td style="vertical-align: top; padding-bottom: 5px; padding-top: 10px;" colspan="3">
                    Deskripsi Permasalahan :<br>
                    <div style="margin-top: 5px;">{!! nl2br(e($problem)) !!}</div>
                </td>
            </tr>
            @endif

            @if($solution)
            <tr>
                <td style="vertical-align: top; padding-bottom: 5px; padding-top: 10px;">{{ $counter++ }}.</td>
                <td style="vertical-align: top; padding-bottom: 5px; padding-top: 10px;" colspan="3">
                    Solusi dan Tindakan :<br>
                    <div style="margin-top: 5px;">{!! nl2br(e($solution)) !!}</div>
                </td>
            </tr>
            @endif

            @if($additional)
            <tr>
                <td style="vertical-align: top; padding-bottom: 5px; padding-top: 10px;">{{ $counter++ }}.</td>
                <td style="vertical-align: top; padding-bottom: 5px; padding-top: 10px;" colspan="3">
                    Catatan Tambahan :<br>
                    <div style="margin-top: 5px;">{!! nl2br(e($additional)) !!}</div>
                </td>
            </tr>
            @endif
        @empty
            <tr>
                <td colspan="4" style="font-style: italic; padding-top: 10px;">Belum ada sesi pada laporan ini.</td>
            </tr>
        @endforelse
    </table>

    <table style="width: 100%; margin-top: 50px; font-size: 11pt; font-family: 'Times New Roman', Times, serif; text-align: left; margin-bottom: 40px;">
        <tr>
            <td style="width: 50%; padding-left: 10px;">
                Mengetahui,<br>
                Kepala Sekolah<br><br><br><br><br>
                <strong>Louly Risdianty, S.P., S.Pd</strong>
            </td>
            <td style="width: 50%; padding-left: 10px;">
                Tangerang, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}<br>
                Guru Bimbingan Konseling<br><br><br><br><br>
                <strong>{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</strong>
            </td>
        </tr>
    </table>

    <div style="border-top: 1px solid black; padding-top: 5px; font-size: 10pt; font-family: 'Times New Roman', Times, serif; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="font-style: italic; margin-bottom: 2px;">Keterangan: Dokumen Ini Bersifat Rahasia</div>
            <div>SMAIT LATANSA CENDEKIA</div>
            <div>{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</div>
        </div>
        <div>
            https://gurubkkonselor.com
        </div>
    </div>
</div>

<div id="printFeedbackArea">
    <div style="text-align: center; font-family: 'Times New Roman', Times, serif; line-height: 1.3;">
        <div style="font-size: 14pt;">SMAIT LATANSA CENDEKIA BANTEN</div>
        <div style="font-size: 10pt;">Telp: 021-59319109, Email: humas.smaitlc@gmail.com</div>
        <div style="font-size: 10pt;">Website: sma.latansacendekia.sch.id</div>
    </div>
    <div style="border-bottom: 2px solid black; margin-top: 10px; margin-bottom: 20px;"></div>
    
    <div style="text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold; font-size: 12pt; margin-bottom: 30px;">
        KEPUASAN KONSELI TERHADAP PROSES KONSELING INDIVIDUAL
    </div>

    <table style="width: 100%; font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-bottom: 20px;" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td style="width: 130px;">Identitas</td>
            <td style="width: 10px;">:</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama Konseli</td>
            <td>:</td>
            <td style="border-bottom: 1.5px dashed #000; padding-left: 5px; font-style: italic;">
                @php 
                    $studentNames = $items->map(function($item) {
                        return $item->user->name ?? '';
                    })->filter()->unique()->implode(', ');
                @endphp
                {{ $studentNames ?: ($laporan->user->name ?? '-') }}
            </td>
        </tr>
        <tr>
            <td>Nama Konselor</td>
            <td>:</td>
            <td style="border-bottom: 1.5px dashed #000; padding-left: 5px; font-style: italic;">{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</td>
        </tr>
    </table>

    <div style="font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-bottom: 15px;">
        Petunjuk :<br>
        Bacalah secara teliti, Berilah tanda centang pada kolom jawaban yang tersedia
    </div>

    <style>
        @media print {
            .feedback-table, .feedback-table th, .feedback-table td {
                border: 1px solid black !important;
            }
        }
    </style>
    <table class="feedback-table" style="width: 100%; border-collapse: collapse; font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-bottom: 60px; text-align: center; border: 1px solid black;">
        <thead style="font-weight: bold;">
            <tr>
                <td style="padding: 12px 5px; width: 6%; border: 1px solid black;">No</td>
                <td style="padding: 12px 5px; width: 46%; border: 1px solid black;">Aspek yang dinilai</td>
                <td style="padding: 12px 5px; width: 16%; border: 1px solid black;">Sangat<br>Memuaskan</td>
                <td style="padding: 12px 5px; width: 16%; border: 1px solid black;">Memuaskan</td>
                <td style="padding: 12px 5px; width: 16%; border: 1px solid black;">Kurang<br>Memuaskan</td>
            </tr>
        </thead>
        <tbody>
            @php
                $feedbacks = [];
                if (isset($firstItemWithFeedback)) {
                    $feedbacks = [
                        'Penerimaan guru bimbingan dan konseling atau konselor terhadap kehadiran Anda' => $firstItemWithFeedback->kepuasan_penerimaan,
                        'Kemudahan guru bimbingan dan konseling atau konselor untuk diajak curhat' => $firstItemWithFeedback->kepuasan_kemudahan,
                        'Kepercayaan Anda terhadap guru bimbingan dan konseling atau konselor dalam layanan konseling' => $firstItemWithFeedback->kepuasan_kepercayaan,
                        'Pelayanan pemecahan masalah tercapai melalui konseling individual' => $firstItemWithFeedback->kepuasan_pelayanan
                    ];
                }
                $no = 1;
            @endphp
            @foreach($feedbacks as $aspek => $nilai)
            <tr>
                <td style="padding: 15px 5px; border: 1px solid black;">{{ $no++ }}</td>
                <td style="padding: 15px 10px; text-align: left; border: 1px solid black;">{{ $aspek }}</td>
                <td style="padding: 15px 5px; border: 1px solid black;">
                    @if($nilai == 'Sangat Memuaskan') <span style="font-size: 16pt;">&#10003;</span> @endif
                </td>
                <td style="padding: 15px 5px; border: 1px solid black;">
                    @if($nilai == 'Memuaskan') <span style="font-size: 16pt;">&#10003;</span> @endif
                </td>
                <td style="padding: 15px 5px; border: 1px solid black;">
                    @if($nilai == 'Kurang Memuaskan') <span style="font-size: 16pt;">&#10003;</span> @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; border: none; font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-bottom: 50px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                Peserta didik/Konseli,<br><br><br><br><br>
                <span style="border-bottom: 1px dotted #000; padding: 0 20px; display: inline-block;">
                    {{ $studentNames ?: ($laporan->user->name ?? '-') }}
                </span>
            </td>
        </tr>
    </table>

    <div style="border-top: 1px solid black; padding-top: 5px; font-size: 10pt; font-family: 'Times New Roman', Times, serif; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="font-style: italic; margin-bottom: 2px;">Keterangan: Dokumen Ini Bersifat Rahasia</div>
            <div>SMAIT LATANSA CENDEKIA BANTEN</div>
            <div>{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</div>
        </div>
        <div>
            https://gurubkkonselor.com
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Sembunyikan printArea saat normal */
    #printArea, #printFeedbackArea { display: none; }
    
    @media print {
        /* Hide layout elements explicitly */
        aside, header, nav, .no-print, #app-wrapper { display: none !important; }
        body { background: white !important; margin: 0; padding: 0; }
        #printWrap {
            display: block !important;
            font-family: 'Times New Roman', Times, serif;
            padding: 40px;
            color: black;
            width: 100%;
            background: white;
            line-height: 1.5;
        }
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

    function cetakFeedback() {
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
        printWrap.innerHTML = document.getElementById('printFeedbackArea').innerHTML;
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