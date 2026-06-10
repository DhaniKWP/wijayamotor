<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Wijaya Motor — Booking Servis & Sparepart Online')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
            colors: {
              brand: { DEFAULT: '#FF8C00', dark: '#e67e00' }, 
              ink: { DEFAULT: '#0A192F', light: '#112a4f' },
              danger: '#E11D48',
            }
          }
        }
      }
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
      body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
      [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="text-gray-800 antialiased flex flex-col min-h-screen" x-data="{ mobileMenu: false }">

    @include('layouts.header')

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>