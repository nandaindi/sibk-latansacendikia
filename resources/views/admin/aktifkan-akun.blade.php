@extends('layouts.admin')

@section('title', 'Aktifkan Akun – Admin')

@section('content')

<div class="w-full">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kelola-akun') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Aktifkan Akun</h2>
    </div>

    <div class="bg-[#f8fffe] border-[2px] border-[#e0f5f3] rounded-2xl px-6 py-5 mb-6 shadow-sm">
        <div class="flex flex-col gap-1">
            <span class="text-[0.75rem] font-bold text-[#1a9488] uppercase tracking-wider">Profil Pengguna</span>
            <h3 class="text-[1.1rem] font-black text-[#1a1a1a]">{{ $user->name }}</h3>
            <p class="text-[0.9rem] text-[#555] font-medium">Berdasarkan data {{ $user->hasRole('siswa') ? 'Siswa' : 'Guru BK' }}</p>
        </div>
    </div>

    <form id="aktifkanAkunForm" method="POST" action="{{ route('admin.aktifkan-akun.store', ['id' => $user->id]) }}" class="flex flex-col gap-4">
        @csrf

        {{-- Username --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Username</label>
            <input type="text" name="username" placeholder="Username untuk login" value="{{ old('username', $user->username ?? ($user->nis ?? $user->nip)) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Email --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Email</label>
            <input type="email" name="email" placeholder="Email untuk login" value="{{ old('email', $user->email) }}" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <label class="text-[0.75rem] font-bold text-[#1a9488] block mb-1 uppercase tracking-wide">Password</label>
            <input type="password" name="password" placeholder="Minimal 6 karakter" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end mt-4">
            <button type="button" onclick="showConfirmModal()"
                    class="w-full md:w-auto px-12 py-4 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95">
                Aktifkan Akun Sekarang
            </button>
        </div>
    </form>

</div>

{{-- Confirm Modal --}}
<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[400px] p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">
        <div class="h-32 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>
        <p class="text-[1.1rem] font-bold text-[#1a1a1a] text-center">Yakin aktifkan akun login untuk pengguna ini?</p>
        <div class="flex gap-4 w-full justify-center">
            <button type="button" onclick="submitForm()"
                    class="h-[50px] px-10 bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </button>
            <button type="button" onclick="hideConfirmModal()"
                    class="h-[50px] px-10 bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showConfirmModal() {
    const form = document.getElementById('aktifkanAkunForm');
    if (form.checkValidity()) {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    } else {
        form.reportValidity();
    }
}
function hideConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}
function submitForm() {
    document.getElementById('aktifkanAkunForm').submit();
}
</script>
@endpush
