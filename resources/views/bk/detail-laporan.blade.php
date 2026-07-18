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
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-[0.7rem] font-bold text-[#888] uppercase tracking-wider block m-0">Deskripsi Permasalahan</label>
                            @php
                                $pType = $item->problem_type ?? 'umum';
                                $typeLabels = ['akademik' => 'Akademik', 'sosial' => 'Sosial', 'keluarga' => 'Keluarga', 'karir' => 'Karir', 'lainnya' => 'Lainnya', 'umum' => 'Umum'];
                            @endphp
                            <span class="px-2.5 py-0.5 bg-[#e0f5f3] text-[#1a9488] font-bold rounded-md text-[0.65rem] uppercase tracking-wider">
                                {{ $typeLabels[$pType] ?? 'Umum' }}
                            </span>
                        </div>
                        <div class="text-[0.9rem] text-[#444] leading-relaxed">{!! nl2br(e($problem)) !!}</div>
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
                        <div class="overflow-hidden rounded-xl border border-[#edf2f1]">
                            <table id="kepuasanTable" class="w-full border-collapse text-left display">
                                <thead>
                                    <tr class="bg-[#fcfdfd] border-b-2 border-[#edf2f1]">
                                        <th class="py-3 px-4 text-[0.75rem] font-bold text-[#888] uppercase tracking-wider w-12">No</th>
                                        <th class="py-3 px-4 text-[0.75rem] font-bold text-[#888] uppercase tracking-wider">Aspek yang Dinilai</th>
                                        <th class="py-3 px-4 text-[0.75rem] font-bold text-[#888] uppercase tracking-wider text-center">Sangat Memuaskan</th>
                                        <th class="py-3 px-4 text-[0.75rem] font-bold text-[#888] uppercase tracking-wider text-center">Memuaskan</th>
                                        <th class="py-3 px-4 text-[0.75rem] font-bold text-[#888] uppercase tracking-wider text-center">Kurang Memuaskan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#edf2f1]">
                                    @php $no = 1; @endphp
                                    @foreach($kepuasanItems as $label => $value)
                                        @if($value)
                                        <tr class="hover:bg-[#fcfdfd] transition-colors">
                                            <td class="py-3 px-4 text-[0.9rem] text-[#555] font-semibold align-middle">{{ $no }}</td>
                                            <td class="py-3 px-4 text-[0.9rem] font-medium text-[#1a1a1a] whitespace-normal min-w-[200px] leading-snug align-middle">{{ $label }}</td>
                                            <td class="py-3 px-4 text-center align-middle">
                                                @if($value == 'Sangat Memuaskan') <span class="text-[#16a34a] font-bold text-[1.2rem]">✓</span> @endif
                                            </td>
                                            <td class="py-3 px-4 text-center align-middle">
                                                @if($value == 'Memuaskan') <span class="text-[#ca8a04] font-bold text-[1.2rem]">✓</span> @endif
                                            </td>
                                            <td class="py-3 px-4 text-center align-middle">
                                                @if($value == 'Kurang Memuaskan') <span class="text-[#ef4444] font-bold text-[1.2rem]">✓</span> @endif
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

<div id="printArea" style="display: none;">
    <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid black; padding-bottom: 15px;">
        <div style="font-size: 16pt; font-weight: bold; font-family: 'Times New Roman', Times, serif; letter-spacing: 1px;">SMAIT LATANSA CENDEKIA</div>
        <div style="font-size: 11pt; font-family: 'Times New Roman', Times, serif; margin-top: 4px;">Telp: 021-59319100, Email: humas.smaitlc@gmail.com</div>
        <div style="font-size: 11pt; font-family: 'Times New Roman', Times, serif;">Website: sma.latansacendekia.sch.id</div>
    </div>

    <div style="text-align: center; margin-bottom: 35px; font-family: 'Times New Roman', Times, serif;">
        <div style="font-size: 14pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; margin-bottom: 5px;">{{ strtoupper($laporan->nama_laporan ?? 'LAPORAN PELAKSANAAN LAYANAN KONSELING') }}</div>
        @php
            $tanggalLap = \Carbon\Carbon::parse($laporan->tanggal ?? now());
            $bulan = $tanggalLap->month;
            $tahun = $tanggalLap->year;
            $semester = ($bulan >= 7 && $bulan <= 12) ? 'GANJIL' : 'GENAP';
            $tahunAjaran = ($bulan >= 7) ? $tahun . '/' . ($tahun + 1) : ($tahun - 1) . '/' . $tahun;
        @endphp
        <div style="font-size: 12pt; font-weight: bold; text-transform: uppercase;">SEMESTER {{ $semester }} TAHUN AJARAN {{ $tahunAjaran }}</div>
    </div>

    <table style="width: 100%; font-size: 12pt; margin-bottom: 25px; border-collapse: collapse; font-family: 'Times New Roman', Times, serif;">
        <tr>
            <td style="width: 5%; vertical-align: top; padding: 6px 0;">1.</td>
            <td style="width: 25%; vertical-align: top; padding: 6px 0;">Nama Konseli</td>
            <td style="width: 3%; vertical-align: top; padding: 6px 0;">:</td>
            <td style="width: 67%; vertical-align: top; padding: 6px 0; font-weight: bold;">
                @php $konseliNames = $items->map(fn($item) => $item->user->name)->unique()->implode(', '); @endphp
                {{ $konseliNames ?: '-' }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding: 6px 0;">2.</td>
            <td style="vertical-align: top; padding: 6px 0;">Kelas</td>
            <td style="vertical-align: top; padding: 6px 0;">:</td>
            <td style="vertical-align: top; padding: 6px 0;">
                @php 
                    $kelasNames = $items->map(function($item) {
                        return $item->user->kelas ?? '-';
                    })->filter(fn($val) => $val !== '-')->unique()->implode(', ');
                @endphp
                {{ $kelasNames ?: '-' }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding: 6px 0;">3.</td>
            <td style="vertical-align: top; padding: 6px 0;">Hari, Tanggal</td>
            <td style="vertical-align: top; padding: 6px 0;">:</td>
            <td style="vertical-align: top; padding: 6px 0;">
                @php 
                    $firstItem = $items->first();
                    $dateStr = $firstItem ? \Carbon\Carbon::parse($firstItem->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') : '-';
                @endphp
                {{ $dateStr }}
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding: 6px 0;">4.</td>
            <td style="vertical-align: top; padding: 6px 0;">Pertemuan Ke</td>
            <td style="vertical-align: top; padding: 6px 0;">:</td>
            <td style="vertical-align: top; padding: 6px 0;">
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
            <td style="vertical-align: top; padding: 6px 0;">5.</td>
            <td style="vertical-align: top; padding: 6px 0;">Waktu</td>
            <td style="vertical-align: top; padding: 6px 0;">:</td>
            <td style="vertical-align: top; padding: 6px 0;">
                 {{ $firstItem && $firstItem->waktu ? \Carbon\Carbon::parse($firstItem->waktu)->format('H:i') : '-' }} WIB
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding: 6px 0;">6.</td>
            <td style="vertical-align: top; padding: 6px 0;">Tempat</td>
            <td style="vertical-align: top; padding: 6px 0;">:</td>
            <td style="vertical-align: top; padding: 6px 0;">
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
                <td style="vertical-align: top; padding: 12px 0 6px 0;">{{ $counter++ }}.</td>
                <td style="vertical-align: top; padding: 12px 0 6px 0;" colspan="3">
                    <span style="font-weight: bold;">Deskripsi Permasalahan :</span><br>
                    <div style="margin-top: 8px; text-align: justify; line-height: 1.6;">{!! nl2br(e($problem)) !!}</div>
                </td>
            </tr>
            @endif

            @if($solution)
            <tr>
                <td style="vertical-align: top; padding: 12px 0 6px 0;">{{ $counter++ }}.</td>
                <td style="vertical-align: top; padding: 12px 0 6px 0;" colspan="3">
                    <span style="font-weight: bold;">Solusi dan Tindakan :</span><br>
                    <div style="margin-top: 8px; text-align: justify; line-height: 1.6;">{!! nl2br(e($solution)) !!}</div>
                </td>
            </tr>
            @endif

            @if($additional)
            <tr>
                <td style="vertical-align: top; padding: 12px 0 6px 0;">{{ $counter++ }}.</td>
                <td style="vertical-align: top; padding: 12px 0 6px 0;" colspan="3">
                    <span style="font-weight: bold;">Catatan Tambahan :</span><br>
                    <div style="margin-top: 8px; text-align: justify; line-height: 1.6;">{!! nl2br(e($additional)) !!}</div>
                </td>
            </tr>
            @endif
        @empty
            <tr>
                <td colspan="4" style="font-style: italic; padding-top: 15px;">Belum ada sesi pada laporan ini.</td>
            </tr>
        @endforelse
    </table>

    <table style="width: 100%; margin-top: 60px; font-size: 12pt; font-family: 'Times New Roman', Times, serif; text-align: center; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                Mengetahui,<br>
                Kepala Sekolah
                <br><br><br><br><br><br>
                <span style="font-weight: bold; text-decoration: underline;">Louly Risdianty, S.P., S.Pd</span>
            </td>
            <td style="width: 50%; vertical-align: top;">
                Tangerang, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}<br>
                Guru Bimbingan Konseling
                <br><br><br><br><br><br>
                <span style="font-weight: bold; text-decoration: underline;">{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</span>
            </td>
        </tr>
    </table>

    <div style="border-top: 2px solid black; margin-top: 50px; padding-top: 10px; font-size: 10pt; font-family: 'Times New Roman', Times, serif; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="font-style: italic; margin-bottom: 4px;">Keterangan: Dokumen Ini Bersifat Rahasia</div>
            <div style="font-weight: bold;">SMAIT LATANSA CENDEKIA</div>
            <div>{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</div>
        </div>
        <div style="text-align: right; color: #555;">
            https://sma.latansacendekia.sch.id
        </div>
    </div>
</div>

<div id="printFeedbackArea" style="display: none;">
    <div style="text-align: center; margin-bottom: 25px; border-bottom: 3px solid black; padding-bottom: 15px;">
        <div style="font-size: 16pt; font-weight: bold; font-family: 'Times New Roman', Times, serif; letter-spacing: 1px;">SMAIT LATANSA CENDEKIA</div>
        <div style="font-size: 11pt; font-family: 'Times New Roman', Times, serif; margin-top: 4px;">Telp: 021-59319100, Email: humas.smaitlc@gmail.com</div>
        <div style="font-size: 11pt; font-family: 'Times New Roman', Times, serif;">Website: sma.latansacendekia.sch.id</div>
    </div>
    
    <div style="text-align: center; font-family: 'Times New Roman', Times, serif; font-weight: bold; font-size: 14pt; margin-bottom: 35px; text-decoration: underline;">
        KEPUASAN KONSELI TERHADAP PROSES KONSELING INDIVIDUAL
    </div>

    <table style="width: 100%; font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin-bottom: 25px;" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td style="width: 20%; padding: 6px 0; font-weight: bold;">Identitas</td>
            <td style="width: 3%; padding: 6px 0;"></td>
            <td style="width: 77%; padding: 6px 0;"></td>
        </tr>
        <tr>
            <td style="padding: 6px 0 6px 15px;">Nama Konseli</td>
            <td style="padding: 6px 0;">:</td>
            <td style="padding: 6px 0; font-weight: bold;">
                @php 
                    $studentNames = $items->map(function($item) {
                        return $item->user->name ?? '';
                    })->filter()->unique()->implode(', ');
                @endphp
                {{ $studentNames ?: ($laporan->user->name ?? '-') }}
            </td>
        </tr>
        <tr>
            <td style="padding: 6px 0 6px 15px;">Nama Konselor</td>
            <td style="padding: 6px 0;">:</td>
            <td style="padding: 6px 0;">{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</td>
        </tr>
    </table>

    <div style="font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-bottom: 15px; font-style: italic;">
        Petunjuk :<br>
        Bacalah secara teliti, Berilah tanda centang (✓) pada kolom jawaban yang tersedia
    </div>

    <style>
        @media print {
            .feedback-table {
                border-collapse: collapse !important;
            }
            .feedback-table th, .feedback-table td {
                border: 1px solid black !important;
            }
            .feedback-table thead th {
                background-color: #f3f4f6 !important; /* light gray for header */
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }
    </style>
    <table class="feedback-table" style="width: 100%; border-collapse: collapse; font-family: 'Times New Roman', Times, serif; font-size: 11pt; margin-bottom: 60px; text-align: center; border: 1px solid black;">
        <thead>
            <tr style="font-weight: bold; background-color: #f3f4f6;">
                <th style="padding: 15px 5px; width: 6%; border: 1px solid black;">No</th>
                <th style="padding: 15px 15px; width: 46%; border: 1px solid black; text-align: left;">Aspek yang dinilai</th>
                <th style="padding: 15px 5px; width: 16%; border: 1px solid black;">Sangat<br>Memuaskan</th>
                <th style="padding: 15px 5px; width: 16%; border: 1px solid black;">Memuaskan</th>
                <th style="padding: 15px 5px; width: 16%; border: 1px solid black;">Kurang<br>Memuaskan</th>
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
                <td style="padding: 15px 15px; text-align: left; border: 1px solid black; line-height: 1.4;">{{ $aspek }}</td>
                <td style="padding: 15px 5px; border: 1px solid black; font-weight: bold; font-size: 16pt;">
                    @if($nilai == 'Sangat Memuaskan') &#10003; @endif
                </td>
                <td style="padding: 15px 5px; border: 1px solid black; font-weight: bold; font-size: 16pt;">
                    @if($nilai == 'Memuaskan') &#10003; @endif
                </td>
                <td style="padding: 15px 5px; border: 1px solid black; font-weight: bold; font-size: 16pt;">
                    @if($nilai == 'Kurang Memuaskan') &#10003; @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; border: none; font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin-bottom: 50px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center;">
                Tangerang, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}<br>
                Peserta Didik / Konseli,
                <br><br><br><br><br><br>
                <span style="font-weight: bold; text-decoration: underline; padding: 0 10px;">
                    {{ $studentNames ?: ($laporan->user->name ?? '_________________________') }}
                </span>
            </td>
        </tr>
    </table>

    <div style="border-top: 2px solid black; padding-top: 10px; font-size: 10pt; font-family: 'Times New Roman', Times, serif; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <div style="font-style: italic; margin-bottom: 4px;">Keterangan: Dokumen Ini Bersifat Rahasia</div>
            <div style="font-weight: bold;">SMAIT LATANSA CENDEKIA</div>
            <div>{{ $laporan->author->name ?? 'Eni Kustiyorini' }}</div>
        </div>
        <div style="text-align: right; color: #555;">
            https://sma.latansacendekia.sch.id
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#kepuasanTable')) {
            $('#kepuasanTable').DataTable().destroy();
        }
        $('#kepuasanTable').DataTable({
            responsive: true,
            scrollX: false,
            autoWidth: false,
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            dom: 'rt', // Only show the table, no wrappers
            columnDefs: [
                { responsivePriority: 1, targets: 1 }, // Aspek
                { responsivePriority: 2, targets: 0 }  // No
            ]
        });
    });

    function printHtmlContent(htmlContent, title) {
        // Buat iframe tersembunyi
        let iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.width = '0px';
        iframe.style.height = '0px';
        iframe.style.border = 'none';
        document.body.appendChild(iframe);
        
        let doc = iframe.contentWindow.document;
        doc.open();
        doc.write('<!DOCTYPE html>');
        doc.write('<html><head><title>' + title + '</title>');
        doc.write('<style>');
        doc.write('@page { size: A4 portrait; margin: 20mm; }');
        doc.write('body { font-family: "Times New Roman", Times, serif; margin: 0; padding: 0; color: black; background: white; }');
        doc.write('</style>');
        doc.write('</head><body>');
        doc.write(htmlContent);
        doc.write('</body></html>');
        doc.close();
        
        // Beri waktu sejenak agar iframe dirender sebelum diprint
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
            // Hapus iframe setelah dialog print muncul/ditutup
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 2000);
        }, 500);
    }

    function cetakLaporan() {
        let content = document.getElementById('printArea').innerHTML;
        printHtmlContent(content, 'Cetak Laporan Konseling');
    }

    function cetakFeedback() {
        let content = document.getElementById('printFeedbackArea').innerHTML;
        printHtmlContent(content, 'Cetak Kepuasan Konseli');
    }
</script>
@endpush