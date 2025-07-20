@extends('layouts.nextwork')

@section('title', 'Personal Space')

@section('content')
    <div class="space-y-6">

        <!-- Welcome Header -->
        <div class="bg-white rounded-xl shadow p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Welcome back, {{ Auth::user()->name }} 👋</h2>
                <p class="text-sm text-gray-600">Here’s what’s going on with your profile today.</p>
            </div>
            <a href="{{ route('profile.show') }}"
                class="bg-teal-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-teal-700 transition">
                View Profile
            </a>
        </div>


        <!-- My Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow p-4">
                <p class="text-gray-500 text-sm">Your Posts</p>
                <p class="text-2xl font-bold text-teal-700">{{ $postCount ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <p class="text-gray-500 text-sm">Connections</p>
                <p class="text-2xl font-bold text-teal-700">{{ $connectionCount ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4">
                <p class="text-gray-500 text-sm">Job Applications</p>
                <p class="text-2xl font-bold text-teal-700">{{ $applicationCount ?? 0 }}</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Need a CV?</h3>
                <p class="text-sm text-gray-600">Generate a clean PDF CV with your current profile data.</p>
            </div>
            <a href="{{ route('cv.index') }}"
                class="bg-teal-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-teal-700 transition">Generate
                CV</a>
        </div>


        <!-- Recent Posts -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Recent Posts</h3>

            <div class="space-y-6">
                @forelse ($recentPosts as $post)
                    <div x-data="{ menuOpen: false }" class="border-b pb-4">
                        <!-- Header -->
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-800">{{ $post->body }}</p>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="relative">
                                <button @click="menuOpen = !menuOpen" class="text-gray-500 hover:text-gray-700">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>

                                <div x-show="menuOpen" @click.away="menuOpen = false" x-transition
                                    class="absolute right-0 mt-2 w-40 bg-white rounded shadow z-10">
                                    <button
                                        @click.prevent="
                                    menuOpen = false;
                                    $dispatch('open-edit-modal', {
                                        body: @js($post->body),
                                        url: '{{ route('posts.update', $post) }}'
                                    })"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Edit
                                    </button>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">You haven’t posted anything yet.</p>
                @endforelse
            </div>

            <div class="mt-4 text-right">
                <a href="{{ route('posts.mine') }}" class="text-sm text-teal-600 hover:underline font-medium">View All
                    →</a>
            </div>
        </div>


        <!-- Connections Preview -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Connections</h3>
            <div class="flex items-center space-x-4">
                @forelse ($recentConnections as $connection)
                    <div class="flex flex-col items-center text-sm text-gray-700">
                        <img class="w-12 h-12 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode($connection->name) }}&color=7F9CF5&background=EBF4FF"
                            alt="{{ $connection->name }}">
                        <span class="mt-1">{{ $connection->name }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No connections yet. Go connect!</p>
                @endforelse
            </div>
        </div>

    </div>

@endsection
