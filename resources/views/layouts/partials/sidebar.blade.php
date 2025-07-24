<div class="flex flex-col h-full bg-white border-r border-gray-200 shadow-sm">
    <!-- Header Section -->
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <a href="{{ route('feed.index') }}"
                class="flex items-center group transition-all duration-200 hover:scale-105">
                <div class="relative">
                    <x-application-logo class="w-10 h-10 mr-3" />
                    <div
                        class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-br from-blue-500 to-teal-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    </div>
                </div>
                <span
                    class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    NextWork
                </span>
            </a>

            <!-- Mobile Close Button -->
            <button onclick="toggleMobileSidebar()"
                class="md:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <i class="ti ti-x text-xl"></i>
            </button>
        </div>

        <!-- User Quick Info (Optional) -->
        <div class="mt-4 p-3 bg-gradient-to-r from-blue-50 to-teal-50 rounded-lg border border-blue-100">
            <div class="flex items-center">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-teal-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ auth()->user()->name ?? 'User' }}
                    </p>
                    <p class="text-xs text-blue-600">Professional</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Section -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <!-- Main Navigation -->
        <div class="space-y-1">
            <a href="{{ route('professional.dashboard') }}"
                class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 transform hover:scale-105
                  {{ request()->routeIs('professional.dashboard')
                      ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/25'
                      : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                <div
                    class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg
                       {{ request()->routeIs('professional.dashboard')
                           ? 'bg-white/20'
                           : 'bg-gray-100 group-hover:bg-blue-100 text-gray-600 group-hover:text-blue-600' }}
                       transition-colors duration-200">
                    <i class="ti ti-home text-lg"></i>
                </div>
                <span>My Space</span>
            </a>

            <a href="{{ route('chat.index') }}"
                class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 transform hover:scale-105
                  {{ request()->routeIs('chat.index')
                      ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-lg shadow-teal-500/25'
                      : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                <div
                    class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg
                       {{ request()->routeIs('chat.index')
                           ? 'bg-white/20'
                           : 'bg-gray-100 group-hover:bg-teal-100 text-gray-600 group-hover:text-teal-600' }}
                       transition-colors duration-200">
                    <i class="ti ti-message text-lg"></i>
                </div>
                <span>Messages</span>
            </a>

            <a href="{{ route('jobs.index') }}"
                class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 transform hover:scale-105
                  {{ request()->routeIs('jobs.index')
                      ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg shadow-purple-500/25'
                      : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                <div
                    class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg
                       {{ request()->routeIs('jobs.index')
                           ? 'bg-white/20'
                           : 'bg-gray-100 group-hover:bg-purple-100 text-gray-600 group-hover:text-purple-600' }}
                       transition-colors duration-200">
                    <i class="ti ti-tool text-lg"></i>
                </div>
                <span>Opportunities</span>
            </a>

            <a href="{{ route('feed.index') }}"
                class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 transform hover:scale-105
                  {{ request()->routeIs('feed.index')
                      ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg shadow-green-500/25'
                      : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                <div
                    class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg
                       {{ request()->routeIs('feed.index')
                           ? 'bg-white/20'
                           : 'bg-gray-100 group-hover:bg-green-100 text-gray-600 group-hover:text-green-600' }}
                       transition-colors duration-200">
                    <i class="ti ti-news text-lg"></i>
                </div>
                <span>News Feed</span>
            </a>

            <a href="{{ route('professionals.index') }}"
                class="group flex items-center px-3 py-3 rounded-xl text-sm font-medium transition-all duration-200 transform hover:scale-105
                  {{ request()->routeIs('professionals.index')
                      ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg shadow-orange-500/25'
                      : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                <div
                    class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg
                       {{ request()->routeIs('professionals.index')
                           ? 'bg-white/20'
                           : 'bg-gray-100 group-hover:bg-orange-100 text-gray-600 group-hover:text-orange-600' }}
                       transition-colors duration-200">
                    <i class="ti ti-friends text-lg"></i>
                </div>
                <span>Network</span>
            </a>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-gray-200"></div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group flex items-center w-full px-3 py-3 rounded-xl text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 transition">
                <div
                    class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-gray-100 group-hover:bg-red-100 text-gray-500 group-hover:text-red-600 transition">
                    <i class="ti ti-logout text-lg"></i>
                </div>
                <span>Logout</span>
            </button>
        </form>
    </nav>



</div>

<style>
    /* Custom scrollbar for sidebar navigation */
    nav::-webkit-scrollbar {
        width: 4px;
    }

    nav::-webkit-scrollbar-track {
        background: transparent;
    }

    nav::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 2px;
    }

    nav::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }

    /* Smooth hover animations */
    .group:hover .ti {
        transform: scale(1.1);
        transition: transform 0.2s ease-in-out;
    }

    /* Active state animations */
    .bg-gradient-to-r {
        position: relative;
        overflow: hidden;
    }

    .bg-gradient-to-r::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .bg-gradient-to-r:hover::before {
        left: 100%;
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .group:hover {
            transform: none;
        }

        .transform.hover\:scale-105:hover {
            transform: none;
        }
    }
</style>
