<x-app-layout>
    <!-- Top Navbar -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <img src="/images/logo.png" class="w-8 h-8" alt="Logo">
                <span class="text-lg font-bold text-teal-700">Nextwork</span>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:block w-full max-w-md">
                <div class="relative">
                    <input type="text" placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-100 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M16.65 11A5.65 5.65 0 1111 5.35 5.65 5.65 0 0116.65 11z" />
                    </svg>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="flex items-center space-x-4">
                <button class="p-2 rounded-full bg-gray-100 text-gray-500 hover:text-teal-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                    </svg>
                </button>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <img src="https://via.placeholder.com/32" class="w-8 h-8 rounded-full" alt="User">
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="bg-teal-50 min-h-screen py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Create Post Box -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Start a post..."
                        class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <!-- Feed Posts Section -->
            <div class="space-y-6">
                <!-- Example Feed Post -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-teal-200"></div>
                        <div>
                            <h4 class="text-md font-bold text-teal-800">Jane Doe</h4>
                            <p class="text-sm text-gray-500">UI/UX Designer at CoolStartup</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        Just wrapped up an awesome design sprint with my team. 🚀 Excited to show what we built!
                    </p>
                    <div class="flex space-x-6 text-sm text-gray-500">
                        <span class="hover:text-teal-600 cursor-pointer">Like</span>
                        <span class="hover:text-teal-600 cursor-pointer">Comment</span>
                        <span class="hover:text-teal-600 cursor-pointer">Share</span>
                    </div>
                </div>
                <!-- More posts can go here -->
            </div>
        </div>
    </div>
    </x-app-layout>
