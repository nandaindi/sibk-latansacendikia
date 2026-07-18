@extends('layouts.admin')

@section('title', 'Kelola Laporan – Admin')

@section('content')

{{-- Notifications --}}
@if(session('sukses_tambah'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">Laporan berhasil ditambahkan.</div>
@endif
@if(session('sukses_edit'))
    <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-xl">Laporan berhasil diperbarui.</div>
@endif
@if(session('sukses_hapus'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">Laporan berhasil dihapus.</div>
@endif

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">List Daftar Laporan</h2>
    <div class="flex flex-wrap items-center gap-2">
        <button type="button" onclick="exportExcel()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a9488] text-white rounded-full text-[0.9rem] font-bold hover:brightness-105 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1a9488] transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Export Excel
        </button>
        <button type="button" onclick="exportPDF()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[#1a1a1a] rounded-full text-[0.9rem] font-bold hover:bg-[#f0f9f8] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1a9488] transition-colors border border-[#1a9488] cursor-pointer">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <path d="M8 13h8M8 17h6"/>
            </svg>
            Export PDF
        </button>
    </div>
</div>

<div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-x-hidden w-full">
    <table id="laporanTable" class="w-full text-left border-collapse display">
        <thead>
            <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama Laporan</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Penulis</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-center w-[1%] whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#edf2f1]">
            @foreach($laporans as $i => $item)
            <tr class="hover:bg-[#fcfdfd] transition-colors">
                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $i + 1 }}</td>
                <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $item->nama_laporan }}</td>
                <td class="p-4 text-[0.9rem] text-[#555]">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                <td class="p-4 text-[0.9rem] text-[#555]">{{ $item->author->name ?? 'Unknown' }}</td>
                <td class="p-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.kelola-laporan.detail', ['id' => $item->id]) }}" title="Detail" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <button type="button" onclick="showDeleteLaporanModal({{ $item->id }})" title="Hapus" class="p-2 text-[#ef4444] hover:bg-[#fef2f2] rounded-lg transition-colors border-none bg-transparent cursor-pointer">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Delete Modal --}}
<div id="deleteLaporanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteLaporanModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-40 w-full"><img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain"></div>
        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus laporan?</p>
        <div class="flex gap-5 w-full justify-center mt-2">
            <form id="deleteLaporanForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                </button>
            </form>
            <button type="button" onclick="hideDeleteLaporanModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- SheetJS untuk export Excel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
$(document).ready(function() {
    $('#laporanTable').DataTable({
        language: { searchPlaceholder: "Cari laporan..." },
        columnDefs: [
            { orderable: false, targets: [0, -1] },
            { className: 'dt-center', targets: -1 },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 }
        ]
    });
});

function exportExcel() {
    const allData = getLaporanRows();
    const headers = ['No', 'Nama Laporan', 'Tanggal', 'Penulis'];

    const rows = allData.map((row, idx) => [idx + 1, row.nama, row.tanggal, row.penulis]);

    const ws_data = [headers, ...rows];
    const ws = XLSX.utils.aoa_to_sheet(ws_data);

    // Styling lebar kolom
    ws['!cols'] = [
        { wch: 5 },
        { wch: 40 },
        { wch: 18 },
        { wch: 25 }
    ];

    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Daftar Laporan');

    const now = new Date();
    const dateStr = now.getFullYear() + '-' +
        String(now.getMonth()+1).padStart(2,'0') + '-' +
        String(now.getDate()).padStart(2,'0');

    XLSX.writeFile(wb, `Laporan_Konseling_${dateStr}.xlsx`);
    window.showToast('Export Excel berhasil diunduh!', 'success');
}

function getLaporanRows() {
    const dt = $('#laporanTable').DataTable();
    const strip = (html) => {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        return (tmp.textContent || tmp.innerText || '').replace(/\s+/g, ' ').trim();
    };

    return dt.rows().data().toArray().map((row) => ({
        nama: strip(row[1]),
        tanggal: strip(row[2]),
        penulis: strip(row[3])
    }));
}

function exportPDF() {
    if (!window.jspdf || typeof window.jspdf.jsPDF !== 'function') {
        window.showToast('Pustaka PDF belum siap. Silakan coba lagi.', 'error');
        return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ unit: 'mm', format: 'a4', orientation: 'portrait' });
    const now = new Date();
    const dateStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
    const fileDate = now.toISOString().slice(0, 10);
    const rows = getLaporanRows();

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(15);
    doc.text('LAPORAN KONSELING', 105, 18, { align: 'center' });
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.text('Daftar laporan konseling', 105, 24, { align: 'center' });
    doc.text(`Tanggal cetak: ${dateStr}`, 14, 34);
    doc.setDrawColor(120, 120, 120);
    doc.line(14, 37, 196, 37);

    doc.autoTable({
        startY: 43,
        head: [['No', 'Nama Laporan', 'Tanggal', 'Penulis']],
        body: rows.map((row, index) => [index + 1, row.nama, row.tanggal, row.penulis]),
        theme: 'grid',
        styles: { font: 'helvetica', fontSize: 9, cellPadding: 3, textColor: [30, 30, 30] },
        headStyles: { fillColor: [245, 245, 245], textColor: [25, 25, 25], fontStyle: 'bold', lineColor: [120, 120, 120], lineWidth: 0.2 },
        columnStyles: { 0: { cellWidth: 12, halign: 'center' }, 1: { cellWidth: 78 }, 2: { cellWidth: 38 }, 3: { cellWidth: 54 } },
        margin: { left: 14, right: 14 },
        didDrawPage: () => {
            const page = doc.internal.getCurrentPageInfo().pageNumber;
            doc.setFontSize(8);
            doc.setTextColor(100, 100, 100);
            doc.text(`Halaman ${page}`, 196, 287, { align: 'right' });
        }
    });

    doc.save(`Laporan_Konseling_${fileDate}.pdf`);
    window.showToast('Export PDF berhasil diunduh!', 'success');
}

function showDeleteLaporanModal(id) {
    document.getElementById('deleteLaporanForm').action = "{{ route('admin.kelola-laporan.destroy') }}?id=" + id;
    document.getElementById('deleteLaporanModal').classList.remove('hidden');
    document.getElementById('deleteLaporanModal').classList.add('flex');
}
function hideDeleteLaporanModal() {
    document.getElementById('deleteLaporanModal').classList.add('hidden');
    document.getElementById('deleteLaporanModal').classList.remove('flex');
}
</script>
@endpush
