@extends('layouts.admin')

@section('title', 'Data Siswa – Admin')

@section('content')

{{-- Notifications --}}
@if(session('sukses_tambah'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">Data siswa berhasil ditambahkan.</div>
@endif
@if(session('sukses_edit'))
    <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-xl">Data siswa berhasil diperbarui.</div>
@endif
@if(session('sukses_hapus'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">Data siswa berhasil dihapus.</div>
@endif

<div class="flex items-start justify-between mb-5 gap-4 flex-wrap">
    <div>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">List Data Siswa</h2>
        <div class="mt-3">
            <a href="{{ route('admin.data-siswa.tambah') }}"
               class="inline-flex items-center gap-1.5 px-5 py-2 bg-[#1a9488] text-white rounded-full text-[0.9rem] font-bold hover:brightness-105 transition-all no-underline shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Siswa
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="flex flex-col items-end gap-1 w-full sm:w-auto">
        <span class="text-[0.78rem] text-[#888] mr-1 hidden sm:block">data siswa</span>
        <div class="flex items-center border-[2px] border-[#1a9488] rounded-full px-4 py-2 bg-white gap-2 w-full sm:w-52 focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a9488" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Search" onkeyup="filterSiswa()"
                   class="border-none outline-none text-[0.9rem] text-[#1a1a1a] placeholder-[#bbb] bg-transparent font-medium w-full"/>
        </div>
    </div>
</div>

{{-- Table Header --}}
<div class="hidden sm:flex items-center gap-4 bg-[#1a9488] text-white rounded-2xl px-5 py-3 mb-1 font-bold text-[0.85rem] tracking-wide uppercase">
    <span class="w-[40px] shrink-0 text-center">No</span>
    <span class="flex-1 min-w-[140px]">Nama</span>
    <span class="flex-1 hidden md:block">NIS</span>
    <span class="flex-1 hidden lg:block">Kelas</span>
    <span class="w-[80px] shrink-0 text-center hidden sm:block">JK</span>
    <span class="w-[112px] shrink-0 text-center">Aksi</span>
</div>

{{-- Data List --}}
<div id="siswaList" class="flex flex-col gap-3 w-full">
    @forelse($siswa as $item)
    <div class="siswa-item bg-white border-[2px] border-[#1a9488] rounded-2xl px-4 sm:px-5 py-3.5 flex items-center gap-3 sm:gap-4 shadow-sm hover:shadow-md transition-shadow">
        <span class="w-[30px] sm:w-[40px] shrink-0 text-center text-[0.85rem] font-bold text-[#1a9488]">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</span>
        <span class="flex-1 text-[0.93rem] font-semibold text-[#1a1a1a] min-w-[100px] truncate">{{ $item->name }}</span>
        <span class="flex-1 text-[0.9rem] text-[#555] hidden md:block">{{ $item->nis ?? '-' }}</span>
        <span class="flex-1 text-[0.9rem] text-[#555] hidden lg:block">{{ $item->kelas ?? '-' }}</span>
        <span class="w-[80px] shrink-0 text-center text-[0.9rem] text-[#555] hidden sm:block">{{ $item->jenis_kelamin ?? '-' }}</span>
        <div class="flex items-center justify-center gap-1.5 sm:gap-2 shrink-0 w-[100px] sm:w-[112px]">
            <a href="{{ route('admin.data-siswa.detail', ['id' => $item->id]) }}" title="Detail" class="w-8 h-8 rounded-full bg-[#e6f4f2] text-[#1a9488] flex items-center justify-center hover:bg-[#1a9488] hover:text-white transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
            <a href="{{ route('admin.data-siswa.edit', ['id' => $item->id]) }}" title="Edit" class="w-8 h-8 rounded-full bg-[#fff4e5] text-[#f59e0b] flex items-center justify-center hover:bg-[#f59e0b] hover:text-white transition-colors">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </a>
            <button type="button" onclick="showDeleteSiswaModal({{ $item->id }})" title="Hapus" class="w-8 h-8 rounded-full bg-[#fce8e8] text-[#ef4444] flex items-center justify-center hover:bg-[#ef4444] hover:text-white transition-colors border-none cursor-pointer">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </div>
    </div>
    @empty
    <div class="text-center py-6 text-gray-500 font-medium bg-white rounded-2xl border-[2px] border-[#edf2f1]">Belum ada data siswa.</div>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $siswa->appends(request()->query())->links() }}
    </div>
</div>

{{-- Delete Modal --}}
<div id="deleteSiswaModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteSiswaModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>
        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus data siswa?</p>
        <div class="flex gap-5 w-full justify-center mt-2">
            <form id="deleteSiswaForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                </button>
            </form>
            <button type="button" onclick="hideDeleteSiswaModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function filterSiswa() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.siswa-item').forEach(el => {
        el.style.display = el.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
}
function showDeleteSiswaModal(id) {
    document.getElementById('deleteSiswaForm').action = "{{ route('admin.data-siswa.destroy') }}?id=" + id;
    document.getElementById('deleteSiswaModal').classList.remove('hidden');
    document.getElementById('deleteSiswaModal').classList.add('flex');
}
function hideDeleteSiswaModal() {
    document.getElementById('deleteSiswaModal').classList.add('hidden');
    document.getElementById('deleteSiswaModal').classList.remove('flex');
}
</script>
@endpush
