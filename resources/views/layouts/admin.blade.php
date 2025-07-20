<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NextWork Admin - @yield('title', 'Dashboard')</title>

    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Add Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    {{-- Prevents "flickering" when Alpine.js loads --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

{{-- Initialize Alpine.js state for the sidebar --}}

<body class="font-inter bg-gray-100 text-gray-800" x-data="{ isSidebarOpen: false }"
    @keydown.escape.window="isSidebarOpen = false">

    {{-- Overlay for mobile, appears when sidebar is open --}}
    <div x-show="isSidebarOpen" @click="isSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" x-cloak></div>

    <div class="min-h-screen flex">

        <!--
          Sidebar Changes:
          - `fixed` positioning for mobile to overlay content.
          - `transform -translate-x-full` to hide it off-screen by default.
          - `transition-transform` for a smooth slide-in/out animation.
          - `md:relative md:translate-x-0` to return it to the normal layout on desktop.
          - `:class` binding to add `translate-x-0` when `isSidebarOpen` is true.
        -->
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-md transform -translate-x-full transition-transform duration-300 ease-in-out md:relative md:translate-x-0"
            :class="{ 'translate-x-0': isSidebarOpen }">

            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <div class="text-teal-700 text-xl font-bold">
                    <i class="ti ti-shield-lock mr-2"></i> Admin Panel
                </div>
                {{-- Add a close button for mobile view --}}
                <button @click="isSidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-800">
                    <i class="ti ti-x h-6 w-6"></i>
                </button>
            </div>

            <nav class="mt-6 flex flex-col space-y-3 px-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 text-gray-700 hover:text-teal-600 font-medium">
                    <i class="ti ti-layout-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('admin.admins.index') }}"
                    class="flex items-center gap-2 text-gray-700 hover:text-teal-600 font-medium">
                    <i class="ti ti-users"></i> Manage Admins
                </a>
                <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-200">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-red-600 hover:underline font-medium">
                        <i class="ti ti-logout"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->


            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
