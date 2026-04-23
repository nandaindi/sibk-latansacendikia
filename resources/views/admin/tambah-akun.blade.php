@extends('layouts.admin')

@section('title', 'Tambah Akun – Admin')

@section('content')

<div class="w-full">

    {{-- Back + Title --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kelola-akun') }}" class="text-[#1a9488] hover:text-[#12635a] transition-colors">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-[1.2rem] font-extrabold text-[#1a1a1a]">Tambah Akun</h2>
    </div>

    <form id="tambahAkunForm" method="POST" action="{{ route('admin.tambah-akun.store') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Nama --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <input type="text" name="nama" placeholder="Nama Lengkap" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Email --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <input type="email" name="email" placeholder="Email" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>


        <div class="border-[2px] border-[#1a9488] rounded-2xl bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all relative" id="roleDropdownWrapper">
            <input type="hidden" name="role" id="roleInput" required>
            <button type="button" onclick="toggleRoleDropdown()" id="roleButton"
                    class="w-full px-5 py-4 border-none outline-none text-[1rem] text-[#aaa] bg-transparent font-medium flex justify-between items-center cursor-pointer">
                <span id="roleText">Role</span>
                <svg id="roleIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" class="transition-transform duration-200 text-[#777]" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div id="roleMenu" class="absolute top-[calc(100%+8px)] left-0 right-0 bg-white border-[2px] border-[#1a9488] rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] z-50 overflow-hidden hidden flex-col">
                <button type="button" onclick="selectRole('admin', 'Admin')" 
                        class="text-left px-5 py-3 hover:bg-[#e0f5f3] hover:text-[#1a9488] transition-colors text-[1rem] font-medium text-[#1a1a1a] border-none bg-transparent cursor-pointer">Admin</button>
            </div>
        </div>

        {{-- Password --}}
        <div class="border-[2px] border-[#1a9488] rounded-2xl px-5 py-4 bg-white focus-within:shadow-[0_0_0_3px_rgba(26,148,136,0.15)] transition-all">
            <input type="password" name="password" placeholder="Password" required
                   class="w-full border-none outline-none text-[1rem] text-[#1a1a1a] placeholder-[#aaa] bg-transparent font-medium"/>
        </div>

        {{-- Save Button (Triggers Modal) --}}
        <div class="flex justify-end mt-2">
            <button type="button" onclick="showConfirmModal()"
                    class="px-10 py-3.5 bg-[#1a9488] text-white rounded-full text-[1rem] font-bold shadow-[0_4px_16px_rgba(26,148,136,0.35)] hover:brightness-105 hover:-translate-y-0.5 transition-all active:scale-95">
                Simpan
            </button>
        </div>
    </form>

</div>

{{-- ===== KONFIRMASI TAMBAH AKUN MODAL ===== --}}
<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideConfirmModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[320px] md:w-[400px] p-8 md:p-10 flex flex-col items-center gap-6 z-10 border-[2px] border-[#1a9488]">

        {{-- Illustration --}}
        <div class="h-32 w-full">
            <img src="{{ asset('img/question mark icon.svg') }}" alt="Question Mark" class="w-full h-full object-contain">
        </div>

        <p class="text-[1.05rem] font-bold text-[#1a1a1a] text-center">Apakah anda yakin tambah akun?</p>

        <div class="flex gap-4 w-full justify-center mt-2">
            {{-- Button OK (Submit Form) --}}
            <button type="button" onclick="submitForm()"
                    class="h-[46px] px-8 bg-[#1a9488] text-white rounded-full flex items-center justify-center hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>
                </svg>
            </button>

            {{-- Button Cancel --}}
            <button type="button" onclick="hideConfirmModal()"
                    class="h-[46px] px-8 bg-[#b94040] text-white rounded-full flex items-center justify-center hover:brightness-110 transition-all shadow-[0_4px_12px_rgba(185,64,64,0.3)]">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="shrink-0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let isRoleOpen = false;
function toggleRoleDropdown() {
    isRoleOpen = !isRoleOpen;
    const menu = document.getElementById('roleMenu');
    const icon = document.getElementById('roleIcon');
    if (isRoleOpen) {
        menu.classList.remove('hidden');
        menu.classList.add('flex');
        icon.classList.add('rotate-180');
    } else {
        menu.classList.add('hidden');
        menu.classList.remove('flex');
        icon.classList.remove('rotate-180');
    }
}

function selectRole(val, label) {
    document.getElementById('roleInput').value = val;
    const textSpan = document.getElementById('roleText');
    textSpan.innerText = label;
    textSpan.classList.remove('text-[#aaa]');
    textSpan.classList.add('text-[#1a1a1a]');
    toggleRoleDropdown(); // close it
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('roleDropdownWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        if (isRoleOpen) toggleRoleDropdown();
    }
});

function showConfirmModal() {
    const roleInput = document.getElementById('roleInput');
    const roleButton = document.getElementById('roleButton');
    
    // Check role manually since it's a hidden input
    if (!roleInput.value) {
        roleButton.classList.add('border-red-400', 'bg-red-50');
        if (!isRoleOpen) toggleRoleDropdown();
        return;
    }
    
    roleButton.classList.remove('border-red-400', 'bg-red-50');

    // Basic validation for other fields
    const form = document.getElementById('tambahAkunForm');
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
    document.getElementById('tambahAkunForm').submit();
}
</script>
@endpush

