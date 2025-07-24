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
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom styles for modern layout */
        body {
            font-family: 'Inter', 'Figtree', sans-serif;
        }

        /* Smooth sidebar animations */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Main content area styling */
        .main-content {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        /* Mobile header shadow */
        .mobile-header {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        /* Content area with proper spacing */
        .content-area {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }

        /* Sidebar backdrop blur effect */
        .sidebar-backdrop {
            backdrop-filter: blur(4px);
            transition: opacity 0.3s ease-in-out;
        }

        /* Hide scrollbar but maintain functionality */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-900">

    {{-- Main Layout Container --}}
    <div class="flex h-screen overflow-hidden">

        {{-- Desktop Sidebar --}}
        <aside
            class="hidden lg:flex flex-shrink-0 w-72  shadow-xl border-r border-gray-100 overflow-y-auto hide-scrollbar">
            @include('layouts.partials.sidebar')
        </aside>

        {{-- Mobile Sidebar Backdrop --}}
        <div class="fixed inset-0 bg-black/50 sidebar-backdrop z-40 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"
            id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()"></div>

        {{-- Mobile Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 transform -translate-x-full lg:hidden sidebar-transition overflow-y-auto hide-scrollbar"
            id="mobileSidebar">
            @include('layouts.partials.sidebar')
        </aside>

        {{-- Main Content Area --}}
        <div class="flex flex-col flex-1 overflow-hidden">

            {{-- Mobile Header (Only visible on mobile) --}}
            <header class="lg:hidden mobile-header border-b border-gray-200 sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 py-3">
                    {{-- Mobile Menu Button --}}
                    <button onclick="toggleMobileSidebar()"
                        class="p-2 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                        <i class="ti ti-menu-2 text-xl"></i>
                    </button>

                    {{-- Mobile Logo --}}
                    <div class="flex items-center">
                        <x-application-logo class="w-8 h-8 mr-2" />
                        <span class="text-lg font-bold text-gray-900">NextWork</span>
                    </div>

                    {{-- Mobile Profile Button --}}
                    <button
                        class="p-2 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                        <div
                            class="w-6 h-6 bg-gradient-to-br from-blue-500 to-teal-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                    </button>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1 overflow-auto main-content content-area">
                <div class="p-4 lg:p-8 max-w-7xl mx-auto">
                    {{-- Page Header (Optional) --}}
                    @hasSection('page-header')
                        <div class="mb-8">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                @yield('page-header')
                            </div>
                        </div>
                    @endif

                    {{-- Main Content --}}
                    <div class="space-y-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- Toast Notifications Container --}}
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    {{-- Global Scripts --}}
    <script>
        // Enhanced mobile sidebar toggle with smooth animations
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');

            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                // Close sidebar
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            } else {
                // Open sidebar
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100');
                document.body.classList.add('overflow-hidden'); // Prevent background scroll
            }
        }

        // Close sidebar when clicking on a link (mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('#mobileSidebar a[href]');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Add small delay to allow navigation to start
                    setTimeout(() => {
                        toggleMobileSidebar();
                    }, 150);
                });
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) { // lg breakpoint
                const sidebar = document.getElementById('mobileSidebar');
                const backdrop = document.getElementById('mobileSidebarBackdrop');

                // Reset mobile sidebar state on desktop
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                backdrop.classList.remove('opacity-100');
                document.body.classList.remove('overflow-hidden');
            }
        });

        // Toast notification system
        function showToast(message, type = 'info', duration = 5000) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const bgColors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const icons = {
                success: 'ti-check',
                error: 'ti-x',
                warning: 'ti-alert-triangle',
                info: 'ti-info-circle'
            };

            toast.className =
                `${bgColors[type]} text-white px-6 py-4 rounded-xl shadow-lg transform translate-x-full transition-transform duration-300 flex items-center space-x-3 max-w-sm`;
            toast.innerHTML = `
                <i class="ti ${icons[type]} text-lg"></i>
                <span class="flex-1 text-sm font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white">
                    <i class="ti ti-x text-sm"></i>
                </button>
            `;

            container.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            // Auto remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, duration);
        }

        // Global error handling
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e.error);
        });

        // CSRF token setup for AJAX requests
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.csrfToken = token.getAttribute('content');
        }
    </script>

    @stack('scripts')
</body>

</html>
