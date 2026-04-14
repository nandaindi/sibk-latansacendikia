<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>@yield('title', 'Admin – Bimbingan Konseling')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/latansaico.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('preload')
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f4f6f9] min-h-screen text-[#1a1a1a]">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-[220px] shrink-0 bg-[#1a7a70] flex flex-col items-center py-6 gap-5 min-h-screen fixed left-0 top-0 z-30">

        {{-- Logo --}}
        <div class="w-28 h-28 mb-2 rounded-full overflow-hidden bg-white flex items-center justify-center border-4 border-white shadow-lg">
            <img src="{{ asset('img/logo latansa 1.png') }}" alt="Logo Latansa Cendekia" class="w-full h-full object-contain">
        </div>

        {{-- Nav Items --}}
        <nav class="flex flex-col gap-2 w-full px-4">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.kelola-akun') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.kelola-akun*') || request()->routeIs('admin.detail-akun*') || request()->routeIs('admin.tambah-akun') || request()->routeIs('admin.edit-akun') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Kelola Akun</span>
            </a>

            <a href="{{ route('admin.kelola-data') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.kelola-data*') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Kelola Data</span>
            </a>

            <a href="{{ route('admin.kelola-laporan') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.kelola-laporan*') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                </svg>
                <span>Kelola Laporan</span>
            </a>


        </nav>      
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 ml-[220px] flex flex-col min-h-screen">

        {{-- Top bar --}}
        <header class="bg-white px-6 py-3 flex items-center justify-between border-b border-[#e5e7eb] sticky top-0 z-20 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-3">
                <span class="text-[1.1rem] font-bold text-[#1a1a1a]">@yield('title', 'Admin Dashboard')</span>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Profile Dropdown Container -->
                <div class="relative group cursor-pointer" tabindex="0">
                    <div class="flex items-center gap-3 hover:bg-[#f8f9fa] py-2 px-3 rounded-xl transition-colors">
                        <div class="text-right hidden md:block">
                            <div class="text-[0.9rem] font-bold text-[#1a1a1a]">{{ auth()->user()->name ?? 'Admin User' }}</div>
                            <div class="text-[0.75rem] text-[#888] capitalize">{{ auth()->user()->role ?? 'Admin' }}</div>
                        </div>
                        @if(auth()->user()->avatar)
                            <div class="w-10 h-10 rounded-full border-2 border-[#1a9488] overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-[#e0f5f3] border-2 border-[#1a9488] flex items-center justify-center text-[#1a9488] font-bold shrink-0">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                        @endif
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#1a9488] transition-colors"><path d="m6 9 6 6 6-6"/></svg>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 focus-within:opacity-100 focus-within:visible focus-within:scale-100 z-50">
                        <div class="p-1.5 flex flex-col">
                            <div class="px-3 py-2 text-xs font-semibold text-[#888] uppercase tracking-wider mb-1">Akun Saya</div>
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-[#333] font-medium hover:bg-[#f0f9f8] hover:text-[#1a9488] rounded-lg transition-colors">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profil Saya
                            </a>
                            <div class="h-px bg-[#eaeaea] my-1"></div>
                            <button onclick="showLogoutModal()" class="flex items-center gap-3 px-3 py-2 text-sm text-[#e53e3e] font-medium hover:bg-[#fff5f5] rounded-lg transition-colors w-full cursor-pointer border-none bg-transparent">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 md:p-8">
            {{-- Global Validation Errors --}}
            @if($errors->any())
            <div class="mb-6 animate-[fadeInDown_0.4s_ease-out]">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm flex items-start gap-3">
                    <div class="shrink-0 text-red-500 mt-0.5">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[0.9rem] font-black text-red-800 uppercase tracking-wider mb-1">Terjadi Kesalahan Pengisian:</h4>
                        <ul class="list-disc list-inside text-[0.85rem] text-red-700 font-medium space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

{{-- ===== LOGOUT MODAL ===== --}}
<div id="logoutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideLogoutModal()"></div>
    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-[340px] md:w-[420px] p-10 flex flex-col items-center gap-6 z-10">
        {{-- Illustration --}}
        <div class="h-40 w-full mb-2">
            <img src="{{ asset('img/Man running up the stairs to the open door.svg') }}" alt="Logout Illustration" class="w-full h-full object-contain">
        </div>
        <p class="text-[1.1rem] font-bold text-[#1a1a1a] text-center">Apakah Anda Yakin?</p>
        <div class="flex gap-4 w-full justify-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="px-8 py-3 bg-[#1a9488] text-white rounded-full font-bold text-[1rem] hover:brightness-105 transition-all shadow-[0_4px_12px_rgba(26,148,136,0.3)]">
                    Logout
                </button>
            </form>
            <button onclick="hideLogoutModal()"
                    class="px-8 py-3 bg-red-500 text-white rounded-full font-bold text-[1rem] hover:bg-red-600 transition-all shadow-[0_4px_12px_rgba(239,68,68,0.3)]">
                Cancel
            </button>
        </div>
    </div>
</div>

@stack('scripts')
<script>
function showLogoutModal() {
    document.getElementById('logoutModal').classList.remove('hidden');
    document.getElementById('logoutModal').classList.add('flex');
}
function hideLogoutModal() {
    document.getElementById('logoutModal').classList.add('hidden');
    document.getElementById('logoutModal').classList.remove('flex');
}
</script>
</body>
</html>
