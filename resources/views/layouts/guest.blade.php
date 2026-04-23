<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bimbingan Konseling')</title>
    <link rel="shortcut icon" href="{{ asset('img/latansaico.png') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* Immediate styling to prevent FOUC */
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f5f7fa; 
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .font-caveat { font-family: 'Caveat', cursive; }
    </style>
</head>
<body class="bg-[#f5f7fa] min-h-screen text-[#1a1a1a] flex flex-col p-0 m-0">

    @yield('content')

    @stack('scripts')
</body>
</html>
