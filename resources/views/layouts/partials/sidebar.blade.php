<!-- resources/views/layouts/partials/sidebar.blade.php -->
<div class="p-4 flex flex-col flex-grow bg-white border-r border-greys-200">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('feed.index') }}" class="flex items-center">
            <x-application-logo class="w-8 h-8 mr-2" />
            <span class="text-2xl font-bold text-gray-900">NextWork</span>
        </a>
        <button onclick="toggleMobileSidebar()" class="md:hidden text-gray-500 hover:text-gray-700">
            <i class="ti ti-x text-2xl"></i>
        </button>
    </div>
    <nav class="flex-1 space-y-2">
        <a href="{{ route('professional.dashboard') }}"
            class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200
                  {{ request()->routeIs('professional.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="ti ti-home mr-3 text-xl"></i> My Space
        </a>
        <a href="{{ route('feed.index') }}"
            class="flex items-center p-3 rounded-lg transition-colors duration-200
                  {{ request()->routeIs('feed.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="ti ti-news mr-3 text-xl"></i> News Feed
        </a>

        <a href="{{ route('chat.index') }}" class="flex items-center p-3 rounded-lg transition-colors duration-200">
            <i class="ti ti-message mr-3 text-xl"></i> Chat
        </a>
        <a href="{{ route('jobs.index') }}"
            class="flex items-center p-3 rounded-lg transition-colors duration-200
                  {{ request()->routeIs('jobs.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="ti ti-tool mr-3 text-xl"></i> Jobs
        </a>
        <a href="{{ route('professionals.index') }}"
            class="flex items-center p-3 rounded-lg transition-colors duration-200
                  {{ request()->routeIs('professionals.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="ti ti-friends mr-3 text-xl"></i> People
        </a>
        {{-- Add more links here --}}
    </nav>
</div>
