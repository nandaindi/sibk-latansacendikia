@extends('layouts.admin')

@section('title', 'Data BK – Admin')

@section('content')

{{-- Notifications --}}
@if(session('sukses_tambah'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">Data guru BK berhasil ditambahkan.</div>
@endif
@if(session('sukses_edit'))
    <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-xl">Data guru BK berhasil diperbarui.</div>
@endif
@if(session('sukses_hapus'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">Data guru BK berhasil dihapus.</div>
@endif

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">List Data Guru BK</h2>
    <a href="{{ route('admin.data-bk.tambah') }}"
       class="inline-flex items-center gap-1.5 px-5 py-2 bg-[#1a9488] text-white rounded-full text-[0.9rem] font-bold hover:brightness-105 transition-all no-underline shadow-[0_4px_12px_rgba(26,148,136,0.3)] shrink-0">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Guru BK
    </a>
</div>

<div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] overflow-x-hidden w-full">
    <table id="bkTable" class="w-full text-left border-collapse display">
        <thead>
            <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">No</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Nama</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">NIP</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Jabatan</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Telepon</th>
                <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-center w-[1%] whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#edf2f1]">
            @foreach($bk as $i => $item)
            <tr class="hover:bg-[#fcfdfd] transition-colors">
                <td class="p-4 text-[0.9rem] font-bold text-[#1a9488]">{{ $i + 1 }}</td>
                <td class="p-4 text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $item->name }}</td>
                <td class="p-4 text-[0.9rem] text-[#555]">{{ $item->nip ?? '-' }}</td>
                <td class="p-4 text-[0.9rem] text-[#555]">{{ $item->jabatan ?? '-' }}</td>
                <td class="p-4 text-[0.9rem] text-[#555]">{{ $item->telepon ?? '-' }}</td>
                <td class="p-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.data-bk.detail', ['id' => $item->id]) }}" title="Detail" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <a href="{{ route('admin.data-bk.edit', ['id' => $item->id]) }}" title="Edit" class="p-2 text-[#f59e0b] hover:bg-[#fffbeb] rounded-lg transition-colors">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <button type="button" onclick="showDeleteBkModal({{ $item->id }})" title="Hapus" class="p-2 text-[#ef4444] hover:bg-[#fef2f2] rounded-lg transition-colors border-none bg-transparent cursor-pointer">
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
<div id="deleteBkModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteBkModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-40 w-full"><img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain"></div>
        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus data guru BK?</p>
        <div class="flex gap-5 w-full justify-center mt-2">
            <form id="deleteBkForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                </button>
            </form>
            <button type="button" onclick="hideDeleteBkModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#bkTable').DataTable({
        language: { searchPlaceholder: "Cari guru BK..." },
        columnDefs: [
            { orderable: false, targets: [0, -1] },
            { className: 'dt-center', targets: -1 },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 }
        ]
    });
});

function showDeleteBkModal(id) {
    document.getElementById('deleteBkForm').action = "{{ route('admin.data-bk.destroy') }}?id=" + id;
    document.getElementById('deleteBkModal').classList.remove('hidden');
    document.getElementById('deleteBkModal').classList.add('flex');
}
function hideDeleteBkModal() {
    document.getElementById('deleteBkModal').classList.add('hidden');
    document.getElementById('deleteBkModal').classList.remove('flex');
}
</script>
@endpush
