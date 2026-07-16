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
    @include('partials.echo-notifications', [
        'canAutoReload' => [
            '^/bk/dashboard/?$',
            '^/bk/daftar-pengajuan/?$',
            '^/bk/sesi-konseling/?$',
            '^/bk/detail-sesi.*$',
            '^/bk/riwayat-panggilan/?$',
            '^/bk/laporan-konseling/?$',
            '^/bk/laporan/detail.*$',
            '^/bk/konseling-online.*$',
            '^/bk/panggil-siswa/?$',
            '^/bk/panggil-siswa/detail.*$'
        ],
        'reloadableTypes' => ['konseling_pengajuan_baru', 'konseling_status', 'pelanggaran_baru', 'pelanggaran_status'],
        'autoRedirect' => false
    ])
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
