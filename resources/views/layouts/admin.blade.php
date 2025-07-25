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


    {{-- Alpine.js for interactivity --}}
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

<body class="font-inter antialiased bg-gray-100 text-gray-800" x-data="{ isSidebarOpen: false }"
    @resize.window="isSidebarOpen = window.innerWidth >= 768 ? false : isSidebarOpen" {{-- Reset on resize to desktop --}}
    @keydown.escape.window="isSidebarOpen = false">

    {{-- Mobile Overlay --}}
    <div x-show="isSidebarOpen" @click="isSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden transition-opacity duration-300 ease-in-out" x-cloak
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 md:w-72 bg-white shadow-xl 
                      transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0"
            :class="{ 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }" aria-label="Sidebar">

            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="ti ti-shield-lock text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">NextWork Admin</h1>
                        <p class="text-xs text-gray-500 font-medium">Platform Control</p>
                    </div>
                </a>
                {{-- Close button for mobile view --}}
                <button @click="isSidebarOpen = false"
                    class="md:hidden p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="ti ti-x text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-3 custom-scrollbar overflow-y-auto">
                {{-- Navigation Links --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ Route::is('admin.dashboard') ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'text-gray-700 hover:bg-gray-50 hover:text-teal-600' }}">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-lg {{ Route::is('admin.dashboard') ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-500 group-hover:bg-teal-50 group-hover:text-teal-500' }} transition-colors">
                        <i class="ti ti-dashboard text-lg"></i>
                    </div>
                    <span>Dashboard</span>
                    @if (Route::is('admin.dashboard'))
                        <div class="ml-auto w-2 h-2 bg-teal-500 rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('admin.admins.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ Route::is('admin.admins.*') ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'text-gray-700 hover:bg-gray-50 hover:text-teal-600' }}">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-lg {{ Route::is('admin.admins.*') ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-500 group-hover:bg-teal-50 group-hover:text-teal-500' }} transition-colors">
                        <i class="ti ti-users text-lg"></i>
                    </div>
                    <span>Manage Admins</span>
                    @if (Route::is('admin.admins.*'))
                        <div class="ml-auto w-2 h-2 bg-teal-500 rounded-full"></div>
                    @endif
                </a>


            </nav>

            {{-- Logout Button at the bottom --}}
            <div class="p-6 mt-auto border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="group w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-red-600 bg-red-50 border border-red-200 hover:bg-red-100 hover:text-red-700 transition-all duration-200">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-600 transition-colors">
                            <i class="ti ti-logout text-lg"></i>
                        </div>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Topbar --}}
            <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-lg border-b border-gray-200/80 shadow-sm">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-5">
                    {{-- Mobile Menu Toggle --}}
                    <button @click="isSidebarOpen = !isSidebarOpen"
                        class="lg:hidden inline-flex items-center justify-center p-2 text-gray-600 hover:text-teal-600 hover:bg-gray-100 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <i class="ti ti-menu-2 text-xl"></i>
                    </button>

                    {{-- Page Title / Breadcrumbs (Optional) --}}
                    <div class="flex items-center">

                    </div>

                    {{-- Admin Info & Actions --}}
                    <div class="flex items-center gap-3">
                        {{-- Notifications (Placeholder) --}}
                        <button
                            class="relative p-2 text-gray-600 hover:text-teal-600 hover:bg-gray-100 rounded-xl transition-colors">
                            <i class="ti ti-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        {{-- Admin Profile  --}}
                        <div class="hidden sm:flex items-center gap-3 px-3 py-2 bg-gray-50 rounded-xl">
                            <div
                                class="w-9 h-9 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? '', 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate max-w-[150px]">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content Area --}}
            <main class="flex-1 overflow-y-auto custom-scrollbar p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Custom scrollbar for sidebar/content --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.4);
            /* Gray-400 opacity */
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.6);
            /* Darker gray on hover */
        }


        :root {
            --color-teal-500: #14b8a6;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;
            --color-white: #ffffff;
            --color-red-50: #fef2f2;
            --color-red-100: #fee2e2;
            --color-red-200: #fecaca;
            --color-red-500: #ef4444;
            --color-red-600: #dc2626;
            --color-red-700: #b91c1c;
        }
    </style>

    @stack('scripts')
</body>

</html>
