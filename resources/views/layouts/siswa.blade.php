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

@include('partials.siswa.modals')

<div class="w-full mx-auto bg-transparent min-h-screen relative flex flex-col">
    @include('partials.siswa.navbar')

    @yield('content')
</div>

@include('partials.siswa.bottom-nav')

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<script>
    // Toast masuk (Animasi dengan Tailwind classes)
    window.addEventListener('load', () => {
        @if(session('login_success'))
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.replace('-translate-y-[80px]', 'translate-y-0');
            setTimeout(() => toast.classList.replace('translate-y-0', '-translate-y-[80px]'), 3500);
        }
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
