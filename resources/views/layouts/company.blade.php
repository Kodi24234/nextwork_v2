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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-inter antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Sidebar -->
        <aside :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-teal-800 text-white transform lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-200 ease-in-out">
            <div class="p-4 text-center border-b border-teal-700">
                <a href="{{ route('company.dashboard') }}" class="text-2xl font-bold text-white">Nextwork</a>
                <div class="text-xs text-teal-300 mt-1">for Companies</div>
            </div>
            <nav class="mt-6 space-y-2 px-4">
                <a href="{{ route('company.dashboard') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-lg {{ Route::is('company.dashboard') ? 'bg-teal-700 bg-opacity-30' : 'hover:bg-teal-700 hover:bg-opacity-20 transition' }}">
                    <i class="ti ti-smart-home"></i> Dashboard
                </a>
                <a href="{{ route('company.jobs.index') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-lg {{ Route::is('company.jobs.*') ? 'bg-teal-700 bg-opacity-30' : 'hover:bg-teal-700 hover:bg-opacity-20 transition' }}">
                    <i class="ti ti-briefcase"></i> Manage Jobs
                </a>
                <a href="{{ route('company.profile.edit') }}"
                    class="flex items-center gap-3 py-2 px-3 rounded-lg {{ Route::is('company.profile.edit') ? 'bg-teal-700 bg-opacity-30' : 'hover:bg-teal-700 hover:bg-opacity-20 transition' }}">
                    <i class="ti ti-building-skyscraper"></i> Company Profile
                </a>
            </nav>
        </aside>

        <!-- Page Content -->
        <div class="flex flex-col flex-1 min-h-screen">
            <!-- Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b shadow-sm">
                <!-- Sidebar Toggle (Mobile Only) -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-500 hover:text-teal-600 focus:outline-none" aria-label="Toggle Sidebar">
                    <i class="ti ti-menu-2 text-2xl"></i>
                </button>

                <!-- User Info + Logout -->
                <div class="flex items-center gap-6">
                    <span class="font-semibold text-gray-800 text-base truncate max-w-[150px]">
                        {{ Auth::user()->company->name ?? Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm text-gray-600 hover:text-teal-600 transition focus:outline-none">
                            Sign Out
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto px-6 py-6 bg-gray-50">
                @yield('content')
            </main>
        </div>

    </div>
</body>

</html>
