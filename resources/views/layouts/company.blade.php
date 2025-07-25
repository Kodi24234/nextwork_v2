<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nextwork for Companies - @yield('title', 'Dashboard')</title>

    <!-- Icons and Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.4);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.6);
        }

        /* Backdrop blur fallback */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
    </style>
</head>

<body class="font-inter antialiased bg-gray-50 min-h-screen">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen mb-20">

        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden" style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 transform lg:translate-x-0 lg:static lg:inset-0 transition-all duration-300 ease-in-out lg:z-auto shadow-xl lg:shadow-none">

            <!-- Logo Section -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <a href="{{ route('company.dashboard') }}" class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="ti ti-building-skyscraper text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Nextwork</h1>
                        <p class="text-xs text-gray-500 font-medium">for Companies</p>
                    </div>
                </a>
                <!-- Close button for mobile -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="ti ti-x text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2 custom-scrollbar overflow-y-auto">
                <div class="space-y-1">
                    <a href="{{ route('company.dashboard') }}"
                        class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ Route::is('company.dashboard') ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'text-gray-700 hover:bg-gray-50 hover:text-teal-600' }}">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg {{ Route::is('company.dashboard') ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-500 group-hover:bg-teal-50 group-hover:text-teal-500' }} transition-colors">
                            <i class="ti ti-dashboard text-lg"></i>
                        </div>
                        <span>Dashboard</span>
                        @if (Route::is('company.dashboard'))
                            <div class="ml-auto w-2 h-2 bg-teal-500 rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('company.jobs.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ Route::is('company.jobs.*') ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'text-gray-700 hover:bg-gray-50 hover:text-teal-600' }}">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg {{ Route::is('company.jobs.*') ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-500 group-hover:bg-teal-50 group-hover:text-teal-500' }} transition-colors">
                            <i class="ti ti-briefcase text-lg"></i>
                        </div>
                        <span>Manage Jobs</span>
                        @if (Route::is('company.jobs.*'))
                            <div class="ml-auto w-2 h-2 bg-teal-500 rounded-full"></div>
                        @endif
                    </a>

                    <a href="{{ route('company.profile.edit') }}"
                        class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ Route::is('company.profile.edit') ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'text-gray-700 hover:bg-gray-50 hover:text-teal-600' }}">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-lg {{ Route::is('company.profile.edit') ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-500 group-hover:bg-teal-50 group-hover:text-teal-500' }} transition-colors">
                            <i class="ti ti-building text-lg"></i>
                        </div>
                        <span>Company Profile</span>
                        @if (Route::is('company.profile.edit'))
                            <div class="ml-auto w-2 h-2 bg-teal-500 rounded-full"></div>
                        @endif
                    </a>
                </div>


            </nav>

            <!-- User section at bottom -->
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->company->name ?? Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">
                            {{ Auth::user()->company->name ?? Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">Company Account</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                            title="Sign Out">
                            <i class="ti ti-logout text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen lg:min-h-0">
            <!-- Header -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200/80 shadow-sm">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-2">
                    <!-- Mobile menu button -->
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true"
                            class="lg:hidden inline-flex items-center justify-center p-2 text-gray-600 hover:text-teal-600 hover:bg-gray-100 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <i class="ti ti-menu-2 text-xl"></i>
                        </button>

                        <!-- Page title for mobile -->
                        <div class="lg:hidden">
                            <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <!-- Desktop breadcrumb/title -->


                    <!-- Right side actions -->
                    <div class="flex items-center gap-3">
                        <!-- Notifications (placeholder) -->
                        <button
                            class="relative p-2 text-gray-600 hover:text-teal-600 hover:bg-gray-100 rounded-xl transition-colors">
                            <i class="ti ti-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User menu (desktop only, simplified) -->
                        <div class="hidden sm:flex items-center gap-3 px-3 py-2 bg-gray-50 rounded-xl">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-semibold text-xs">
                                {{ strtoupper(substr(Auth::user()->company->name ?? Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 max-w-[120px] truncate">
                                {{ Auth::user()->company->name ?? Auth::user()->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto custom-scrollbar">
                <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile-friendly touch targets -->
    <script>
        // Close sidebar when clicking on main content on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const mainContent = document.querySelector('main');
            mainContent.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    // Trigger Alpine.js to close sidebar
                    window.dispatchEvent(new CustomEvent('sidebar-close'));
                }
            });
        });
    </script>
</body>

</html>
