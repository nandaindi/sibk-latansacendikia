@extends('layouts.admin')

@section('title', 'Detail Data Guru BK – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.data-bk') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Data Guru BK</h2>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium">
            Kelola Data / Data BK / Detail
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 shadow-sm mb-6">
        <div class="flex items-center gap-6 mb-6">
            <div class="w-20 h-20 md:w-24 md:h-24 shrink-0 rounded-full bg-[#1a9488] flex items-center justify-center text-white">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">{{ $user->name }}</h3>
                <p class="text-[0.9rem] text-[#888] font-medium">NIP: {{ $user->nip ?? '-' }}</p>
                <p class="text-[0.85rem] text-[#1a9488] font-bold uppercase mt-1">Guru BK</p>
            </div>
        </div>

        {{-- Data Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-[#f8fffe] rounded-xl p-4 border border-[#e0f5f3]">
                <p class="text-[0.75rem] font-bold text-[#1a9488] uppercase tracking-wide mb-1">Jenis Kelamin</p>
                <p class="text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
            </div>
            <div class="bg-[#f8fffe] rounded-xl p-4 border border-[#e0f5f3]">
                <p class="text-[0.75rem] font-bold text-[#1a9488] uppercase tracking-wide mb-1">Jabatan / Spesialisasi</p>
                <p class="text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $user->jabatan ?? '-' }}</p>
            </div>
            <div class="bg-[#f8fffe] rounded-xl p-4 border border-[#e0f5f3]">
                <p class="text-[0.75rem] font-bold text-[#1a9488] uppercase tracking-wide mb-1">No. Telepon / WhatsApp</p>
                <p class="text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $user->telepon ?? '-' }}</p>
            </div>
            <div class="bg-[#f8fffe] rounded-xl p-4 border border-[#e0f5f3]">
                <p class="text-[0.75rem] font-bold text-[#1a9488] uppercase tracking-wide mb-1">Email</p>
                <p class="text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $user->email }}</p>
            </div>
            <div class="bg-[#f8fffe] rounded-xl p-4 border border-[#e0f5f3] md:col-span-2">
                <p class="text-[0.75rem] font-bold text-[#1a9488] uppercase tracking-wide mb-1">Alamat Lengkap</p>
                <p class="text-[0.95rem] font-semibold text-[#1a1a1a]">{{ $user->alamat ?? '-' }}</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3 mt-6">
            <a href="{{ route('admin.data-bk.edit', ['id' => $user->id]) }}" class="px-6 py-2 bg-[#f59e0b] text-white rounded-full text-[0.85rem] font-bold hover:brightness-105 transition-all no-underline shadow-md">Edit Data</a>
            <button onclick="showDeleteModal()" class="px-6 py-2 bg-[#ef4444] text-white rounded-full text-[0.85rem] font-bold hover:brightness-105 transition-all border-none cursor-pointer shadow-md">Hapus Data</button>
        </div>
    </div>

</div>

{{-- Delete Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>
        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus data guru BK?</p>
        <div class="flex gap-5 w-full justify-center mt-2">
            <form action="{{ route('admin.data-bk.destroy', ['id' => $user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)] border-none cursor-pointer">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                </button>
            </form>
            <button type="button" onclick="hideDeleteModal()" class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)] border-none cursor-pointer">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}
function hideDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}
</script>
@endpush
