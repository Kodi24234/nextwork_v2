<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NextWork - @yield('title', 'Dashboard')</title>

    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-inter antialiased bg-white text-gray-800 transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">

        {{-- Desktop Sidebar --}}
        <aside class="hidden md:flex flex-shrink-0 w-64 bg-white border-r border-gray-200 overflow-y-auto">
            @include('layouts.partials.sidebar')
        </aside>

        {{-- Mobile Sidebar --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden" id="mobileSidebarBackdrop"
            onclick="toggleMobileSidebar()"></div>
        <aside
            class="fixed inset-y-0 left-0 w-64 bg-white z-50 transform -translate-x-full md:hidden transition-transform duration-300"
            id="mobileSidebar">
            @include('layouts.partials.sidebar')
        </aside>

        {{-- Main Content Area --}}
        <div class="flex flex-col flex-1 overflow-y-auto">
            @include('layouts.partials.header')

            <main class="flex-1 p-6 md:p-8 bg-gray-50">
                @yield('content')
            </main>

            @include('layouts.partials.mobile-nav')
        </div>
    </div>

    {{-- Fallback sidebar toggling script (if no Alpine.js) --}}
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>

    @stack('scripts')
</body>

</html>
