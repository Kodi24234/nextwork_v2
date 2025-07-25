<header class="w-full bg-white shadow-sm border-b border-gray-200 p-4 flex items-center justify-between z-30">
    <div class="flex items-center space-x-4 ml-auto">
        <!-- Notifications Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="relative p-2 rounded-full bg-gray-100 text-gray-500 hover:text-teal-600 transition-colors">
                <i class="ti ti-bell text-xl"></i>

            </button>

            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-20">


                <div class="p-4 font-bold border-b">Notifications</div>

                <div class="py-1">

                    <p class="text-center text-gray-500 py-4">You have no new notifications.</p>

                </div>


                <div class="p-2 text-center border-t">
                    <a href="#" class="text-sm text-teal-600 hover:underline">View all notifications</a>
                </div>
            </div>
        </div>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                <span class="hidden md:block text-gray-800 font-medium">{{ Auth::user()->company->name }}</span>
            </button>

            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">


                <!-- Logout Form -->
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
