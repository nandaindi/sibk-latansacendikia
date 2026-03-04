@extends('layouts.admin')

@section('title', 'Detail Akun – Admin')

@section('content')

<div class="w-full">

    {{-- Title & Desktop Breadcrumb --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-[1.3rem] md:text-[1.5rem] font-extrabold text-[#1a1a1a]">Detail Akun</h2>
        </div>
        <div class="hidden md:block text-[0.95rem] text-[#888] font-medium">
            Kelola Akun/Detail
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white border-[2px] border-[#1a9488] rounded-2xl p-6 md:p-8 flex items-center gap-6 shadow-sm">
        {{-- Avatar --}}
        <div class="w-20 h-20 md:w-24 md:h-24 shrink-0 rounded-full bg-[#1a9488] flex items-center justify-center text-white">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>
        {{-- Details --}}
        <div class="flex flex-col gap-1.5 md:gap-2">
            <p class="text-[0.95rem] md:text-[1.1rem] font-bold text-[#1a1a1a]">Nama : Ibu Eni Kustiyorini S.Psi</p>
            <p class="text-[0.95rem] md:text-[1.1rem] font-bold text-[#1a1a1a]">Email &nbsp;: example@gmail.com</p>
            <p class="text-[0.95rem] md:text-[1.1rem] font-bold text-[#1a1a1a]">Status: Admin</p>
        </div>
    </div>

</div>

{{-- ===== KONFIRMASI HAPUS AKUN MODAL ===== --}}
<div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideDeleteModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[420px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">

        {{-- Illustration --}}
        <div class="h-40 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.1rem] md:text-[1.2rem] font-semibold text-[#1a1a1a] text-center">Apakah anda yakin hapus akun?</p>

        <div class="flex gap-5 w-full justify-center mt-2">
            {{-- Button OK (Hapus) --}}
            <form action="{{ route('admin.detail-akun.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="h-[48px] w-[90px] bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                    </svg>
                </button>
            </form>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideDeleteModal()"
                    class="h-[48px] w-[90px] bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
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
