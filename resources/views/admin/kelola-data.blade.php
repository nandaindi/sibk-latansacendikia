@extends('layouts.admin')

@section('title', 'Kelola Data – Admin')

@section('content')

{{-- Notifications --}}
@if(session('sukses_tambah'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">Data berhasil ditambahkan.</div>
@endif
@if(session('sukses_edit'))
    <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-xl">Data berhasil diperbarui.</div>
@endif
@if(session('sukses_hapus'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">Data berhasil dihapus.</div>
@endif

<div class="flex items-start justify-between mb-5 gap-4 flex-wrap">
    <div>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">List Daftar Konseling</h2>
        <div class="mt-3">
            <a href="{{ route('admin.kelola-data.tambah') }}" class="inline-flex items-center gap-1.5 px-5 py-2 bg-[#1a9488] text-white rounded-full text-[0.9rem] font-bold hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] no-underline">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Data
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="flex flex-col items-end gap-1">
        <span class="text-[0.78rem] text-[#888] mr-9">kelola data</span>
        <div class="flex items-center gap-3">
            <div class="flex items-center border-[2px] border-[#1a9488] rounded-full px-4 py-2 bg-white gap-2 w-52 focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Search" onkeyup="filterData()"
                       class="border-none outline-none text-[0.9rem] text-[#1a1a1a] placeholder-[#bbb] bg-transparent font-medium w-full"/>
            </div>
            {{-- Filter Icon (Funnels) --}}
            <button class="text-[#1a9488] hover:text-[#12635a] transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
            </button>
        </div>
    </div>
</div>

{{-- Table Header --}}
<div class="hidden sm:flex items-center justify-between gap-4 bg-[#1a9488] text-white rounded-2xl px-5 py-3 mb-1 font-bold text-[0.85rem] tracking-wide uppercase">
    <span class="w-[40px] shrink-0 text-center">No</span>
    <span class="flex-1 min-w-[150px]">Nama Siswa</span>
    <span class="flex-1 text-center hidden md:block">Tanggal</span>
    <span class="flex-1 text-center">Jenis</span>
    <span class="w-[112px] shrink-0 text-center">Aksi</span>
</div>

{{-- Data List --}}
<div id="dataList" class="flex flex-col gap-3 w-full">
    @forelse($konselings as $item)
    <div class="data-item bg-white border-[2px] border-[#1a9488] rounded-2xl px-5 py-3.5 flex items-center justify-between gap-4 shadow-sm hover:shadow-md transition-shadow">
        <span class="w-[40px] shrink-0 text-center text-[0.85rem] font-bold text-[#1a9488]">{{ $loop->iteration + ($konselings->currentPage() - 1) * $konselings->perPage() }}</span>
        <span class="text-[0.95rem] font-semibold text-[#1a1a1a] flex-1 min-w-[150px]">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</span>
        <span class="text-[0.9rem] text-[#555] flex-1 text-center hidden md:block">{{ \Carbon\Carbon::parse($item->tanggal)->format('l, d F Y') }}</span>
        <span class="text-[0.9rem] text-[#555] flex-1 text-center capitalize">{{ $item->jenis }}</span>
        <div class="flex items-center justify-center gap-2 shrink-0 w-[112px]">
            <a href="{{ route('admin.kelola-data.detail', ['id' => $item->id]) }}" title="Detail" class="w-8 h-8 rounded-full bg-[#e6f4f2] text-[#1a9488] flex items-center justify-center hover:bg-[#1a9488] hover:text-white transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
            <a href="{{ route('admin.kelola-data.edit-akun', ['id' => $item->user_id]) }}" title="Edit Siswa" class="w-8 h-8 rounded-full bg-[#fff4e5] text-[#f59e0b] flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition-colors">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </a>
            <button type="button" onclick="showDeleteDataModal({{ $item->id }})" title="Hapus Konseling" class="w-8 h-8 rounded-full bg-[#fce8e8] text-[#ef4444] flex items-center justify-center hover:bg-[#ef4444] hover:text-white transition-colors border-none cursor-pointer">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </div>
    </div>
    @empty
    <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">Belum ada data konseling.</div>
    @endforelse

    {{-- Pagination Links --}}
    <div class="mt-4">
        {{ $konselings->appends(request()->query())->links() }}
    </div>
</div>

{{-- ===== KONFIRMASI HAPUS DATA MODAL ===== --}}
<div id="deleteDataModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteDataModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        {{-- Illustration --}}
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus data konseling?</p>

        <div class="flex gap-5 w-full justify-center mt-2">
            {{-- Button OK (Hapus) --}}
            <form id="deleteDataForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                    </svg>
                </button>
            </form>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideDeleteDataModal()"
                    class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function filterData() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.data-item').forEach(el => {
        const text = el.innerText.toLowerCase();
        el.style.display = text.includes(q) ? '' : 'none';
    });
}

function showDeleteDataModal(id) {
    const form = document.getElementById('deleteDataForm');
    form.action = "{{ route('admin.kelola-data.destroy') }}?id=" + id;
    document.getElementById('deleteDataModal').classList.remove('hidden');
    document.getElementById('deleteDataModal').classList.add('flex');
}
function hideDeleteDataModal() {
    document.getElementById('deleteDataModal').classList.add('hidden');
    document.getElementById('deleteDataModal').classList.remove('flex');
}
</script>
@endpush
