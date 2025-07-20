<header class="w-full bg-white shadow-sm border-b border-gray-200 p-4 flex items-center justify-between z-30">
    <div class="flex items-center space-x-4 ml-auto">
        <!-- Notifications -->
        <div x-data="{ open: false, unread: {{ $unreadCount }} }" class="relative">
            <button @click="open = !open; if (unread > 0) markNotificationsRead()"
                class="relative p-2 rounded-full bg-gray-100 text-gray-500 hover:text-teal-600 transition-colors">
                <i class="ti ti-bell text-xl"></i>
                <span x-show="unread > 0" x-text="unread"
                    class="absolute top-0 right-0 h-4 w-4 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                </span>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-20">
                <div class="p-4 font-bold border-b">Notifications</div>

                <div class="py-1 max-h-64 overflow-y-auto">
                    @forelse ($notifications as $notification)
                        <a href="{{ $notification->data['url'] ?? '#' }}"
                            class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 border-b last:border-b-0">
                            <p class="font-medium">{{ $notification->data['requester_name'] ?? 'Notification' }}</p>
                            <p class="text-gray-600">{{ $notification->data['message'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <p class="text-center text-gray-500 py-4">You have no new notifications.</p>
                    @endforelse
                </div>

                <div class="p-2 text-center border-t">
                    <a href="#" class="text-sm text-teal-600 hover:underline">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                <img src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                    alt="Profile" class="w-10 h-10 rounded-full border-2">
                <span class="hidden md:block text-gray-800 font-medium">{{ Auth::user()->name }}</span>
            </button>

            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Sign out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
<script>
    function markNotificationsRead() {
        fetch('{{ route('notifications.read') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(res => {
            if (res.ok) {
                document.querySelector('[x-data]').__x.$data.unread = 0;
            }
        });
    }
</script>
