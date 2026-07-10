<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin – Bimbingan Konseling')</title>
    <link rel="shortcut icon" href="{{ asset('img/latansaico.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f6f9;
            margin: 0;
        }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 220px;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 50;
        }
        #sidebar.sidebar-open {
            transform: translateX(0);
        }
        @media (min-width: 768px) {
            #sidebar {
                transform: translateX(0) !important;
            }
        }

        #adminMainContent { margin-left: 0; }
        @media (min-width: 768px) {
            #adminMainContent { margin-left: 220px; }
        }

        #sidebarOverlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            cursor: pointer;
        }
        #sidebarOverlay.overlay-visible {
            visibility: visible;
            opacity: 1;
        }
        @media (min-width: 768px) {
            #sidebarOverlay {
                display: none !important;
            }
        }

        /* Toast Animations */
        @keyframes toast-in {
            0% { transform: translateY(-20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-toast-in { animation: toast-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .toast-hide { opacity: 0; transform: translateY(-20px); transition: all 0.4s ease; }
    </style>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.tailwindcss.min.css" rel="stylesheet">
    <style>
        /* DataTables UI/UX Overrides */
        .dataTables_wrapper { width: 100%; font-family: 'Poppins', sans-serif; }
        .dt-top-wrapper { display: flex; flex-direction: column; gap: 1.2rem; padding: 1rem 1.2rem; background: #fff; border-bottom: 1px solid #edf2f1; }
        @media (min-width: 768px) { .dt-top-wrapper { flex-direction: row; justify-content: space-between; align-items: center; } }
        .dt-bottom-wrapper { display: flex; flex-direction: row; justify-content: space-between; align-items: center; padding: 1rem 1.2rem; background: #fff; gap: 1rem; width: 100%; }
        .dataTables_length { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #555; font-weight: 500; }
        .dataTables_length select { border-radius: 10px !important; border: 2px solid #edf2f1 !important; padding: 6px 30px 6px 12px !important; font-size: 0.9rem !important; outline: none !important; appearance: none; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23888' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right 0.5rem center/1.25rem 1.25rem; cursor: pointer; }
        .dataTables_filter { display: flex; width: 100%; }
        @media (min-width: 768px) { .dataTables_filter { width: auto; justify-content: flex-end; } }
        .dataTables_filter label { width: 100%; display: flex; align-items: center; }
        .dataTables_filter input { width: 100%; border-radius: 12px !important; border: 2px solid #edf2f1 !important; padding: 10px 16px !important; font-size: 0.95rem !important; outline: none !important; transition: all 0.25s; margin-left: 0 !important; }
        @media (min-width: 768px) { .dataTables_filter input { min-width: 250px; width: auto; } }
        .dataTables_filter input:focus { border-color: #1a9488 !important; box-shadow: 0 4px 12px rgba(26,148,136,0.1) !important; }
        .dataTables_info { font-size: 0.75rem; color: #888; font-weight: 600; white-space: nowrap; }
        @media (min-width: 768px) { .dataTables_info { font-size: 0.85rem; } }
        .dataTables_paginate { display: flex; align-items: center; justify-content: flex-end; gap: 0.25rem; flex-wrap: nowrap; }
        .dataTables_paginate .paginate_button { display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 32px !important; height: 32px !important; padding: 0 6px !important; border-radius: 8px !important; font-size: 0.8rem !important; font-weight: 700 !important; cursor: pointer !important; color: #555 !important; background: #fff !important; border: 2px solid #edf2f1 !important; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important; user-select: none; }
        @media (min-width: 768px) { .dataTables_paginate .paginate_button { min-width: 36px !important; height: 36px !important; padding: 0 10px !important; font-size: 0.85rem !important; border-radius: 10px !important; } }
        .dataTables_paginate .paginate_button:hover { background: #f4f6f9 !important; color: #1a9488 !important; border-color: #1a9488 !important; }
        .dataTables_paginate .paginate_button.current, .dataTables_paginate .paginate_button.current:hover { background: #1a9488 !important; color: #fff !important; border-color: #1a9488 !important; }
        .dataTables_paginate .paginate_button.disabled, .dataTables_paginate .paginate_button.disabled:hover { opacity: 0.35 !important; cursor: not-allowed !important; background: #fff !important; color: #aaa !important; border-color: #edf2f1 !important; }
        table.dataTable thead th { padding: 12px 16px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #888; background: #f8fcfb; border-bottom: 2px solid #edf2f1 !important; white-space: nowrap; }
        table.dataTable tbody tr { transition: background 0.15s; }
        table.dataTable tbody tr:hover { background: #fcfdfd !important; }
        table.dataTable tbody td { padding: 14px 16px; font-size: 0.9rem; color: #444; border-bottom: 1px solid #edf2f1 !important; vertical-align: middle; }

        /* Table overrides */
        table.dataTable {
            border-bottom: 1px solid #edf2f1 !important;
            margin: 0 !important;
        }

        /* Empty State */
        table.dataTable tbody td.dataTables_empty {
            text-align: center !important;
            padding: 3.5rem 1.5rem !important;
            color: #888 !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            background-color: #fcfdfd !important;
            border-bottom: none !important;
        }
        
        /* Responsive Expand Button */
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control, 
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control {
            position: relative;
            padding-left: 52px !important; /* Extra room for mobile button */
            cursor: pointer;
        }
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before, 
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before {
            position: absolute !important;
            top: 50% !important;
            left: 14px !important;
            transform: translateY(-50%) !important;
            background-color: #1a9488 !important;
            color: white !important;
            border-radius: 50% !important;
            box-shadow: 0 3px 8px rgba(26,148,136,0.3) !important;
            border: none !important;
            width: 26px !important;
            height: 26px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 18px !important;
            font-weight: bold !important;
            content: '+' !important;
            transition: all 0.3s;
        }
        table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.dtr-control:before, 
        table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th.dtr-control:before {
            background-color: #b94040 !important;
            box-shadow: 0 3px 8px rgba(185,64,64,0.3) !important;
            content: '-' !important;
            transform: translateY(-50%) rotate(180deg) !important;
        }
        
        /* Responsive Detail Row */
        .dtr-details {
            width: 100% !important;
            padding: 12px 20px !important;
            background-color: #fcfdfd !important;
        }
        .dtr-details li {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 12px 0 !important;
            border-bottom: 1px dashed #edf2f1 !important;
        }
        .dtr-details li:last-child {
            border-bottom: none !important;
        }
        .dtr-details li .dtr-title {
            font-weight: 800 !important;
            font-size: 0.7rem !important;
            color: #999 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            flex-shrink: 0;
            margin-right: 16px;
        }
        .dtr-details li .dtr-data {
            font-size: 0.9rem !important;
            color: #1a1a1a !important;
            text-align: right !important;
            font-weight: 600;
        }
        
        /* Mobile Specific Overrides */
        @media (max-width: 767px) {
            .dataTables_length { display: none !important; }
            /* Fix: wrapper + parent container must hide overflow to prevent horizontal scroll */
            .dataTables_wrapper { overflow-x: hidden !important; }
            #adminMainContent { overflow-x: hidden; }
            table.dataTable { width: 100% !important; min-width: 0 !important; }

            /* Only the expand-control cell gets extra left padding */
            table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control,
            table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control {
                padding-left: 48px !important;
                white-space: normal !important;
                word-break: break-word !important;
            }

            /* Regular cells - allow wrapping */
            table.dataTable tbody td {
                white-space: normal !important;
                word-break: break-word !important;
            }

            table.dataTable thead .dt-column-order,
            table.dataTable thead th:after,
            table.dataTable thead th:before { display: none !important; }

            .dataTables_info { margin-bottom: 0.5rem !important; }

            .dt-bottom-wrapper {
                flex-wrap: wrap !important;
                gap: 0.5rem !important;
            }
        }
        @media (max-width: 400px) {
            table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
                left: 10px !important;
                width: 22px !important;
                height: 22px !important;
                font-size: 15px !important;
            }
            table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control {
                padding-left: 42px !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f4f6f9] min-h-screen text-[#1a1a1a]">

<div id="toast-container" class="fixed top-5 left-4 right-4 md:left-1/2 md:right-auto md:-translate-x-1/2 z-[9999] pointer-events-none md:w-full md:max-w-sm flex flex-col items-center gap-3"></div>

<div class="flex min-h-screen">

    <aside id="sidebar" class="bg-[#1a7a70] flex flex-col items-center py-6 gap-5 shrink-0">

        <div class="w-28 h-28 mb-2 rounded-full overflow-hidden bg-white flex items-center justify-center border-4 border-white shadow-lg">
            <img src="{{ asset('img/logo latansa 1.png') }}" alt="Logo Latansa Cendekia" class="w-full h-full object-contain">
        </div>

        <nav class="flex flex-col gap-2 w-full px-4">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- [HIDDEN] Kelola Data Admin — aktifkan kembali jika diperlukan
            <a href="{{ route('admin.kelola-akun') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.kelola-akun*') || request()->routeIs('admin.detail-akun*') || request()->routeIs('admin.tambah-akun') || request()->routeIs('admin.edit-akun') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Kelola Data Admin</span>
            </a>
            --}}

            <a href="{{ route('admin.data-siswa') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.data-siswa*') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                </svg>
                <span>Kelola Data Siswa</span>
            </a>

            <a href="{{ route('admin.data-bk') }}"
               class="flex items-center gap-3 rounded-xl py-3 px-4 font-bold text-[0.95rem] transition-colors {{ request()->routeIs('admin.data-bk*') ? 'bg-[#12635a] text-white shadow-inner' : 'text-white/80 hover:bg-[#157167] hover:text-white' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>Kelola Data BK</span>
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

    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    <div id="adminMainContent" class="flex-1 flex flex-col min-h-screen">

        <header class="bg-white px-4 md:px-6 py-3 flex items-center justify-between border-b border-[#e5e7eb] sticky top-0 z-20 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-3">
                <button type="button" onclick="openSidebar()" class="md:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors border-none bg-transparent cursor-pointer">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <span class="text-[1.1rem] font-bold text-[#1a1a1a]">@yield('title', 'Admin Dashboard')</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative cursor-pointer" id="profileMenuContainer">
                    <div onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 hover:bg-[#f8f9fa] py-2 px-3 rounded-xl transition-colors">
                        <div class="text-right hidden md:block">
                            <div class="text-[0.9rem] font-bold text-[#1a1a1a]">{{ auth()->user()->name ?? 'Admin User' }}</div>
                            <div class="text-[0.75rem] text-[#888] capitalize">{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</div>
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
                        <svg id="profileDropdownIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-all duration-300"><path d="m6 9 6 6 6-6"/></svg>
                    </div>

                    <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] border border-[#eaeaea] opacity-0 invisible transition-all duration-200 origin-top-right transform scale-95 z-50">
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

        <main class="flex-1 p-6 md:p-8">
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

<div id="logoutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="hideLogoutModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-[340px] md:w-[420px] p-10 flex flex-col items-center gap-6 z-10">
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

<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.tailwindcss.min.js"></script>
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


function openSidebar() {
    document.getElementById('sidebar').classList.add('sidebar-open');
    document.getElementById('sidebarOverlay').classList.add('overlay-visible');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('sidebar-open');
    document.getElementById('sidebarOverlay').classList.remove('overlay-visible');
}

function toggleProfileDropdown(event) {
    if (event) event.stopPropagation();
    const dropdown = document.getElementById('profileDropdown');
    const icon = document.getElementById('profileDropdownIcon');
    
    dropdown.classList.toggle('opacity-0');
    dropdown.classList.toggle('invisible');
    dropdown.classList.toggle('scale-95');
    dropdown.classList.toggle('opacity-100');
    dropdown.classList.toggle('visible');
    dropdown.classList.toggle('scale-100');
    
    if (icon) {
        icon.classList.toggle('rotate-180');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profileDropdown');
    const container = document.getElementById('profileMenuContainer');
    const icon = document.getElementById('profileDropdownIcon');
    
    if (dropdown && container && !container.contains(event.target)) {
        dropdown.classList.add('opacity-0', 'invisible', 'scale-95');
        dropdown.classList.remove('opacity-100', 'visible', 'scale-100');
        
        if (icon) {
            icon.classList.remove('rotate-180');
        }
    }
});

/* Toast System */
window.showToast = function(message, type = 'success', sticky = false) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const id = 'toast-' + Date.now();
    const colors = {
        success: 'bg-[#1a9488]',
        error: 'bg-[#b94040]',
        warning: 'bg-amber-500'
    };
    const bgColor = colors[type] || colors.success;
    
    const icons = {
        success: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`,
        error: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        warning: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`
    };
    const icon = icons[type] || icons.success;

    const closeBtn = `<button onclick="closeToast('${id}')" class="ml-3 p-1 hover:bg-white/20 rounded-full transition-colors pointer-events-auto border-none bg-transparent text-white cursor-pointer"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>`;

    const toastHtml = `
        <div id="${id}" class="animate-toast-in pointer-events-auto ${bgColor} text-white px-4 py-3 rounded-xl text-[0.9rem] font-bold shadow-[0_8px_16px_rgba(0,0,0,0.15)] flex items-start gap-3 w-full">
            ${icon}
            <span class="min-w-0 break-words">${message}</span>
            ${sticky ? closeBtn : ''}
        </div>
    `;

    container.insertAdjacentHTML('beforeend', toastHtml);

    if (!sticky) {
        setTimeout(() => {
            closeToast(id);
        }, 4000);
    }
};

window.closeToast = function(id) {
    const toastEl = document.getElementById(id);
    if (toastEl) {
        toastEl.classList.add('toast-hide');
        setTimeout(() => toastEl.remove(), 450);
    }
};

window.addEventListener('load', () => {
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
    @if(session('warning'))
        showToast('{{ session('warning') }}', 'warning');
    @endif
});
</script>
</body>
</html>
