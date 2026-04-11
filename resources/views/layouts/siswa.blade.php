<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>@yield('title', 'Siswa – BK')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('preload')
    <style>
        /* Tetap simpan sedikit custom CSS khusus urusan transisi kompleks yang ribet jika di Tailwind-kan penuh,
           meski idealnya 100% Tailwind. Sesuai instruksi kita bersihkan sebanyak mungkin.
           Untuk toast dan modal, script js pakai class toggle, jadi tailwind arbitrary variant yang handle animasi. */
        body { font-family: 'Inter', sans-serif; }
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f4f6f9] min-h-screen text-[#1a1a1a]">

<div id="toast-container" class="fixed top-0 left-1/2 -translate-x-1/2 z-[9999] pointer-events-none w-full max-w-sm flex flex-col items-center"></div>

@include('partials.siswa.modals')

<div class="w-full mx-auto bg-transparent min-h-screen relative flex flex-col">
    @include('partials.siswa.navbar')

    @yield('content')
</div>

@include('partials.siswa.bottom-nav')

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<script>
    // Global Toast Function
    window.showToast = function(message, type = 'success') {
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

        const toastHtml = `
            <div id="${id}" class="mt-5 translate-y-[-100px] opacity-0 ${bgColor} text-white px-6 py-3.5 rounded-full text-[0.95rem] font-bold shadow-[0_10px_30px_rgba(0,0,0,0.15)] flex items-center gap-3 whitespace-nowrap transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]">
                ${icon}
                <span>${message}</span>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', toastHtml);
        const toastEl = document.getElementById(id);

        // Show
        setTimeout(() => {
            toastEl.classList.remove('translate-y-[-100px]', 'opacity-0');
            toastEl.classList.add('translate-y-0', 'opacity-100');
        }, 10);

        // Hide and Remove
        setTimeout(() => {
            toastEl.classList.add('translate-y-[-100px]', 'opacity-0');
            setTimeout(() => toastEl.remove(), 600);
        }, 4000);
    };

    // Toast masuk (Animasi dengan Tailwind classes)
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

    // Modal logic (Simulasi switch opacity dan visibility)
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

    // Logout link via script doesn't need attachment per element anymore, 
    // it's handled via correct form submission or onclick directly. 
    // Keep it just in case any old href uses the onclick approach.
    document.querySelectorAll('[onclick="window.location=\'/logout\'"]').forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    });
</script>
@stack('scripts')
</body>
</html>
