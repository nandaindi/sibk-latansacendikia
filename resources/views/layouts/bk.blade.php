<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BK – Bimbingan Konseling')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('img/latansaico.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f6f9;
            margin: 0;
        }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scroll::-webkit-scrollbar { display: none; }

        /* Toast Animations */
        @keyframes toast-in {
            0% { transform: translateY(-20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-toast-in { animation: toast-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .toast-hide { opacity: 0; transform: translateY(-20px); transition: all 0.4s ease; }

    </style>
    <!-- DataTables Tailwind & Responsive CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    
    <style>
        /* ── DataTables UI/UX Overrides (Fix for JIT Compiler) ────────────────── */
        .dataTables_wrapper {
            width: 100%;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Top Controls Layout */
        .dt-top-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            padding: 1rem 1.2rem;
            background: #fff;
            border-bottom: 1px solid #edf2f1;
        }
        @media (min-width: 768px) {
            .dt-top-wrapper {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }
        
        /* Bottom Controls Layout */
        .dt-bottom-wrapper {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.2rem;
            background: #fff;
            gap: 1rem;
            width: 100%;
        }
        
        /* Length Menu */
        .dataTables_length {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #555;
            font-weight: 500;
        }
        .dataTables_length select {
            border-radius: 10px !important;
            border: 2px solid #edf2f1 !important;
            padding: 6px 30px 6px 12px !important;
            font-size: 0.9rem !important;
            outline: none !important;
            appearance: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23888' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") no-repeat right 0.5rem center/1.25rem 1.25rem;
            cursor: pointer;
        }
        
        /* Search Box */
        .dataTables_filter {
            display: flex;
            width: 100%;
        }
        @media (min-width: 768px) {
            .dataTables_filter { width: auto; justify-content: flex-end; }
        }
        .dataTables_filter label {
            width: 100%;
            display: flex;
            align-items: center;
        }
        .dataTables_filter input {
            width: 100%;
            border-radius: 12px !important;
            border: 2px solid #edf2f1 !important;
            padding: 10px 16px !important;
            font-size: 0.95rem !important;
            outline: none !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02) !important;
            transition: all 0.25s;
            margin-left: 0 !important;
        }
        @media (min-width: 768px) {
            .dataTables_filter input { min-width: 250px; width: auto; }
        }
        .dataTables_filter input:focus {
            border-color: #1a9488 !important;
            box-shadow: 0 4px 12px rgba(26,148,136,0.1) !important;
        }
        
        /* Info */
        .dataTables_info {
            font-size: 0.75rem;
            color: #888;
            font-weight: 600;
            white-space: nowrap;
        }
        @media (min-width: 768px) {
            .dataTables_info { font-size: 0.85rem; }
        }
        
        /* Pagination */
        .dataTables_paginate {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.25rem;
            flex-wrap: nowrap;
        }
        .dataTables_paginate .paginate_button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 32px !important;
            height: 32px !important;
            padding: 0 6px !important;
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            color: #fff !important;
            background: #1a7a70 !important;
            border: 2px solid #1a7a70 !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            user-select: none;
            text-decoration: none !important;
        }
        .dataTables_paginate .paginate_button,
        .dataTables_paginate .paginate_button:link,
        .dataTables_paginate .paginate_button:visited,
        .dataTables_paginate a.paginate_button,
        .dataTables_paginate a.paginate_button:link,
        .dataTables_paginate a.paginate_button:visited {
            color: #fff !important;
        }
        /* Force white text on prev/next — DataTables CDN CSS override */
        html body .dataTables_paginate a.paginate_button,
        html body .dataTables_paginate span.paginate_button {
            color: #fff !important;
            background: #1a7a70 !important;
            border: 2px solid #1a7a70 !important;
        }
        @media (min-width: 768px) {
            .dataTables_paginate .paginate_button {
                min-width: 36px !important;
                height: 36px !important;
                padding: 0 10px !important;
                font-size: 0.85rem !important;
                border-radius: 10px !important;
                gap: 0.4rem;
            }
        }
        .dataTables_paginate .paginate_button:hover {
            background: #1a9488 !important;
            color: #fff !important;
            border-color: #1a9488 !important;
        }
        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button.current:hover,
        .dataTables_paginate span .paginate_button.current,
        .dataTables_paginate span .paginate_button.current:hover {
            background: #1a9488 !important;
            color: #fff !important;
            border-color: #1a9488 !important;
            box-shadow: 0 4px 10px rgba(26,148,136,0.2) !important;
            text-shadow: none !important;
        }
        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            background: #1a7a70 !important;
            color: #fff !important;
        }
        
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
            .dataTables_wrapper { overflow-x: hidden !important; }
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

<div class="w-full mx-auto bg-transparent min-h-screen relative flex flex-col">
    @include('partials.siswa.navbar')

    @yield('content')
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<script>
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
</script>

@if(session('error'))
<script>
    window.addEventListener('load', () => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'error', title: 'Gagal!', text: {!! json_encode(session('error')) !!}, confirmButtonColor: '#1a9488' });
        }
    });
</script>
@endif

@if(session('sukses'))
<script>
    window.addEventListener('load', () => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: {!! json_encode(session('sukses')) !!}, confirmButtonColor: '#1a9488' });
        }
    });
</script>
@endif

<script>
    window.addEventListener('load', () => {
        if (window.Echo) {
            const canAutoReload = [
                /^\/bk\/dashboard\/?$/,
                /^\/bk\/daftar-pengajuan\/?$/,
                /^\/bk\/sesi-konseling\/?$/,
                /^\/bk\/riwayat-panggilan\/?$/,
                /^\/bk\/laporan-konseling\/?$/,
                /^\/bk\/konseling-online\/?$/,
                /^\/bk\/panggil-siswa\/?$/
            ];
            const shouldAutoReload = canAutoReload.some((pattern) => pattern.test(window.location.pathname));

            window.Echo.private('App.Models.User.' + {{ auth()->id() }})
                .notification((notification) => {
                    if (window.showToast) {
                        window.showToast(notification.title || 'Notifikasi Baru', 'success', true);
                    }

                    const reloadableTypes = ['konseling_pengajuan_baru', 'konseling_status', 'pelanggaran_baru', 'pelanggaran_status'];
                    if (shouldAutoReload && reloadableTypes.includes(notification?.data?.event_type) && !window.__bkNotifReloadScheduled) {
                        window.__bkNotifReloadScheduled = true;
                        setTimeout(() => window.location.reload(), 600);
                    }
                });
        }
    });
</script>


<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
    if (typeof jQuery == 'undefined') {
        console.error('jQuery is not loaded!');
    } else {
        console.log('jQuery is loaded correctly.');
    }
</script>

<script>
// Global DataTable defaults — shared across all BK pages
$.fn.dataTable.defaults.responsive = true;
$.fn.dataTable.defaults.scrollX    = false;
$.fn.dataTable.defaults.autoWidth  = false;
$.fn.dataTable.defaults.dom        = '<"dt-top-wrapper"lf>rt<"dt-bottom-wrapper"ip>';
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        search: "",
        lengthMenu:   "Tampilkan _MENU_ entri",
        info:         "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty:    "",
        infoFiltered: "(filter dari _MAX_)",
        paginate: {
            first:    "Awal",
            last:     "Akhir",
            next:     '<svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>',
            previous: '<svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>'
        }
    }
});
</script>
@stack('scripts')
</body>
</html>
