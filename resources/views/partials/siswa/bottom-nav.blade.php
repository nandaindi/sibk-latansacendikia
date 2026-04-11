<!-- Bottom Nav (Mobile Only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white h-[70px] flex items-center justify-around border-t border-[#e0e0e0] z-50 pb-[env(safe-area-inset-bottom)] rounded-t-[20px] shadow-[0_-4px_20px_rgba(0,0,0,0.03)]">
    <a href="{{ route('siswa.dashboard') }}" class="bg-transparent border-none flex flex-col items-center gap-1 p-2 {{ request()->routeIs('siswa.dashboard') ? 'text-[#1a9488]' : 'text-[#888]' }} hover:text-[#1a9488] transition-colors no-underline">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="{{ request()->routeIs('siswa.dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('siswa.dashboard') ? '0.5' : '2' }}" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
        </svg>
        <span class="text-[0.75rem] font-semibold currentColor">Beranda</span>
    </a>
    <a href="{{ route('siswa.panggilan') }}" class="bg-transparent border-none flex flex-col items-center gap-1 p-2 {{ request()->routeIs('siswa.panggilan*', 'siswa.detail-panggilan') ? 'text-[#1a9488]' : 'text-[#888]' }} hover:text-[#1a9488] transition-colors no-underline">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07"/>
            <path d="M16.72 11.06A10.94 10.94 0 0 1 19 19H5a10.94 10.94 0 0 1 6-9.95"/>
            <path d="M2 4.27l6.91 6.91"/>
            <path d="m22 2-7 7"/>
        </svg>
        <span class="text-[0.75rem] font-semibold currentColor">Panggilan</span>
    </a>
    <a href="{{ route('siswa.riwayat-konseling') }}" class="bg-transparent border-none flex flex-col items-center gap-1 p-2 {{ request()->routeIs('siswa.riwayat-konseling*', 'siswa.detail-laporan') ? 'text-[#1a9488]' : 'text-[#888]' }} hover:text-[#1a9488] transition-colors no-underline">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
        </svg>
        <span class="text-[0.75rem] font-semibold currentColor">Laporan</span>
    </a>
    <button onclick="document.getElementById('logout-form').submit()" class="bg-transparent border-none flex flex-col items-center gap-1 p-2 text-[#e74c3c] hover:text-[#c0392b] transition-colors cursor-pointer">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        <span class="text-[0.75rem] font-semibold currentColor">Keluar</span>
    </button>
</nav>
