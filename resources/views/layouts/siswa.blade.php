<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Siswa – BK')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/latansaico.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('preload')
    <style>

        body { font-family: 'Poppins', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }

        /* Robot Animations Fail-safe */
        @keyframes robot-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        @keyframes robot-wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(8deg); }
            75% { transform: rotate(-8deg); }
        }
        @keyframes robot-heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        @keyframes antenna-blink {
            0%, 100% { opacity: 1; filter: brightness(1.2); }
            50% { opacity: 0.6; filter: brightness(0.8); }
        }
        .animate-robot-float { animation: robot-float 3s ease-in-out infinite; }
        .animate-robot-wave { animation: robot-wave 2s ease-in-out infinite; transform-origin: bottom center; }
        .animate-robot-pulse { animation: robot-heartbeat 1.5s ease-in-out infinite; }
        .animate-antenna { animation: antenna-blink 2s infinite; }

        /* Toast Animations */
        @keyframes toast-in {
            0% { transform: translateY(-20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-toast-in { animation: toast-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        .toast-hide { opacity: 0; transform: translateY(-20px); transition: all 0.4s ease; }

        @media (prefers-reduced-motion: reduce) {
            .animate-toast-in { animation: none; opacity: 1; transform: none; }
            .toast-hide { transition: opacity 0.2s ease; transform: none; }
        }
    </style>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-[#f4f6f9] min-h-screen text-[#1a1a1a]">

<div id="toast-container" class="fixed top-5 z-[9999] pointer-events-none flex flex-col items-center gap-2" style="left:50%;transform:translateX(-50%);width:max-content;max-width:min(320px,calc(100vw - 2rem));"></div>

@include('partials.siswa.modals')

<div class="w-full mx-auto bg-transparent min-h-screen relative flex flex-col">
    @include('partials.siswa.navbar')

    @yield('content')
</div>

@include('partials.siswa.bottom-nav')

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
            <div id="${id}" class="animate-toast-in pointer-events-auto ${bgColor} text-white px-5 py-2.5 rounded-full text-[0.85rem] font-semibold shadow-[0_8px_24px_rgba(0,0,0,0.18)] flex items-center gap-2.5 whitespace-nowrap">
                ${icon}
                <span>${message}</span>
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
        @if(session('login_success'))
        const loginToastShown = sessionStorage.getItem('login_toast_shown');
        if (!loginToastShown) {
            showToast('Login Berhasil', 'success');
            sessionStorage.setItem('login_toast_shown', 'true');
        }
        @endif

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

    function toggleModal() {
        const modal = document.getElementById('modalPanggilan');
        if (modal) {
            const modalBox = modal.querySelector('div');
            modal.classList.remove('invisible', 'opacity-0');
            modal.classList.add('visible', 'opacity-100');
            modalBox.classList.remove('translate-y-5');
            modalBox.classList.add('translate-y-0');
        }
    }
    function closeModal() {
        const modal = document.getElementById('modalPanggilan');
        if (modal) {
            const modalBox = modal.querySelector('div');
            modalBox.classList.remove('translate-y-0');
            modalBox.classList.add('translate-y-5');
            setTimeout(() => {
                modal.classList.remove('visible', 'opacity-100');
                modal.classList.add('invisible', 'opacity-0');
            }, 300); // Wait for transition
        }
    }

    document.querySelectorAll('[onclick="window.location=\'/logout\'"]').forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    });
</script>

<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
// Global DataTable defaults — shared across all Siswa pages
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
