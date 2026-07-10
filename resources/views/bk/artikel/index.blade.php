@extends('layouts.bk')

@section('title', 'Kelola Artikel Edukasi')

@section('content')
<main class="w-full px-4 md:px-6 py-8 flex-1 flex flex-col gap-6">
    <div class="flex flex-wrap items-center justify-between gap-3 md:gap-4">
        <h2 class="text-[1.15rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a] leading-tight">Kelola Artikel Edukasi</h2>
        <a href="{{ route('bk.artikel.create') }}" class="px-4 py-2 md:px-5 md:py-2.5 bg-[#1a9488] text-white text-[0.8rem] md:text-sm font-bold rounded-xl shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 transition-all no-underline shrink-0">
            + Tambah Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 px-5 py-3 bg-[#e0f5f3] text-[#1a7a70] rounded-xl font-semibold border-[2px] border-[#1a9488]">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[24px] border border-[#edf2f1] shadow-[0_4px_12px_rgba(0,0,0,0.02)] p-4 md:p-6">
        <table id="artikelTable" class="w-full text-left border-collapse !border-none display">
            <thead>
                <tr class="bg-[#f8fcfb] border-b border-[#edf2f1]">
                    <th class="p-4 text-[0.85rem] text-[#1a9488] font-bold uppercase tracking-wider">Cover</th>
                    <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider w-1/3">Judul Artikel</th>
                    <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Penulis</th>
                    <th class="hidden md:table-cell p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider">Tanggal</th>
                    <th class="p-4 text-[0.85rem] text-[#888] font-bold uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#edf2f1]">
                @foreach($artikels as $artikel)
                <tr class="hover:bg-[#fcfdfd] transition-colors">
                    <td class="p-4 align-middle">
                        @if($artikel->gambar)
                            <div class="w-16 h-12 flex-shrink-0 min-w-[64px]">
                                <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Cover" class="w-full h-full rounded-lg object-cover border border-[#eee]">
                            </div>
                        @else
                            <div class="w-16 h-12 flex-shrink-0 min-w-[64px] rounded-lg bg-[#eee] flex items-center justify-center text-xs text-[#aaa]">No Img</div>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="text-[0.95rem] font-bold text-[#1a1a1a] leading-tight">{{ $artikel->judul }}</div>
                    </td>
                    <td class="hidden md:table-cell p-4 text-[0.9rem] font-medium text-[#555]">{{ $artikel->penulis->name ?? 'Unknown' }}</td>
                    <td class="hidden md:table-cell p-4 text-[0.85rem] text-[#888]">{{ $artikel->created_at->format('d M Y') }}</td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('bk.artikel.preview', $artikel->id) }}" target="_blank" class="p-2 text-[#1a9488] hover:bg-[#e0f5f3] rounded-lg transition-colors" title="Lihat Artikel">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('bk.artikel.edit', $artikel->id) }}" class="p-2 text-[#f59e0b] hover:bg-[#fffbeb] rounded-lg transition-colors" title="Edit">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" onclick="showDeleteModal('{{ route('bk.artikel.destroy', $artikel->id) }}')" class="p-2 text-[#ef4444] hover:bg-[#fef2f2] rounded-lg transition-colors border-none bg-transparent cursor-pointer" title="Hapus">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ===== KONFIRMASI HAPUS MODAL ===== --}}
    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
            <div class="h-40 w-full">
                <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
            </div>
            <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus artikel ini?</p>
            <div class="flex gap-5 w-full justify-center mt-2">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                        </svg>
                    </button>
                </form>
                <button type="button" onclick="hideDeleteModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#artikelTable').DataTable({
            responsive: true,
        scrollX: false,
        autoWidth: false,
            dom: '<"dt-top-wrapper"lf>rt<"dt-bottom-wrapper"ip>',
            language: {
                search: "",
                searchPlaceholder: "Cari artikel...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "",
                infoFiltered: "(filter dari _MAX_)",
                zeroRecords: `<div class="flex flex-col items-center justify-center py-4 gap-3">
                    <svg width="42" height="42" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8l-4 4v14a2 2 0 0 0 2 2z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 12h8"/><path d="M8 16h8"/></svg>
                    <span class="text-[#888] font-medium text-[0.95rem]">Belum ada artikel.</span>
                </div>`,
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>',
                    previous: '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>'
                }
            },
            columnDefs: [
                { orderable: false, targets: [0, 4] },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 3, targets: 4 }
            ]
        });
    });

    function showDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }
    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
</script>
@endpush
