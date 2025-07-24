<nav
    class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 flex justify-around items-center h-16 shadow-lg z-50 mt-20">
    <a href="{{ route('professional.dashboard') }}"
        class="flex flex-col items-center justify-center text-gray-700 hover:text-blue-600 text-xs p-2 {{ request()->routeIs('professional.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
        <i class="ti ti-home text-xl mb-1"></i>
        <span>My Space</span>
    </a>
    <a href="{{ route('jobs.index') }}"
        class="flex flex-col items-center justify-center text-xs p-2
          {{ request()->routeIs('jobs.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
        <i class="ti ti-tool text-xl mb-1"></i>
        <span>Jobs</span>
    </a>
    <a href="{{ route('feed.index') }}"
        class="flex flex-col items-center justify-center text-xs p-2
          {{ request()->routeIs('feed.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
        <i class="ti ti-news text-xl mb-1"></i>
        <span>Feed</span>
    </a>

    <a href="{{ route('chat.index') }}"
        class="flex flex-col items-center justify-center text-xs p-2
          {{ request()->routeIs('chat.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
        <i class="ti ti-message text-xl mb-1"></i>
        <span>Chat</span>
    </a>

    <a href="{{ route('professionals.index') }}"
        class="flex flex-col items-center justify-center text-xs p-2
          {{ request()->routeIs('professionals.index') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
        <i class="ti ti-user text-xl mb-1"></i>
        <span>People</span>
    </a>

</nav>
