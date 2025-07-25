@extends('layouts.nextwork')

@section('title', 'Personal Space')

@section('content')
    <div class="space-y-8 mb-20">

        <!-- Hero Welcome Section -->
        <div
            class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-teal-600 rounded-3xl shadow-2xl">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-48 translate-x-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-32 -translate-x-32"></div>

            <div class="relative p-8 lg:p-12">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                                <i class="ti ti-sparkles text-2xl text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-white">
                                    Welcome back, {{ Auth::user()->name }}!
                                    <span class="inline-block animate-bounce">👋</span>
                                </h1>
                                <p class="text-blue-100 text-lg mt-2">Ready to make today productive? Here's your overview.
                                </p>
                            </div>
                        </div>

                        <!-- Quick Stats in Hero -->
                        <div class="flex flex-wrap gap-4 mt-6">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                <span class="text-white/80 text-sm">Posts</span>
                                <span class="text-white font-bold text-lg ml-2">{{ $postCount ?? 0 }}</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                <span class="text-white/80 text-sm">Connections</span>
                                <span class="text-white font-bold text-lg ml-2">{{ $connectionCount ?? 0 }}</span>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/20">
                                <span class="text-white/80 text-sm">Applications</span>
                                <span class="text-white font-bold text-lg ml-2">{{ $applicationCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('profile.show') }}"
                            class="group bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2">
                            <i class="ti ti-user-circle text-lg"></i>
                            <span>View Profile</span>
                            <i class="ti ti-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('cv.index') }}"
                            class="group bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/20 transition-all duration-200 transform hover:scale-105 border border-white/30 flex items-center gap-2">
                            <i class="ti ti-file-text text-lg"></i>
                            <span>Generate CV</span>
                            <i class="ti ti-download text-sm group-hover:translate-y-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Posts Card -->
            <div
                class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="ti ti-edit text-xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-800">{{ $postCount ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Total Posts</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800">Your Content</h3>
                            <p class="text-sm text-gray-600">Posts & updates shared</p>
                        </div>
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-trending-up text-purple-600 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:h-2 transition-all duration-300">
                </div>
            </div>

            <!-- Connections Card -->
            <div
                class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-teal-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="ti ti-users text-xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-800">{{ $connectionCount ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Connections</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800">Your Network</h3>
                            <p class="text-sm text-gray-600">Professional connections</p>
                        </div>
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-network text-blue-600 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-blue-500 to-teal-500 group-hover:h-2 transition-all duration-300">
                </div>
            </div>

            <!-- Applications Card -->
            <div
                class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="ti ti-briefcase text-xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-800">{{ $applicationCount ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Applications</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800">Job Hunt</h3>
                            <p class="text-sm text-gray-600">Applications submitted</p>
                        </div>
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-target text-green-600 text-sm"></i>
                        </div>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-green-500 to-emerald-500 group-hover:h-2 transition-all duration-300">
                </div>
            </div>
        </div>

        <!-- Recent Posts Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <i class="ti ti-article text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Recent Posts</h3>
                            <p class="text-sm text-gray-600">Your latest content and updates</p>
                        </div>
                    </div>
                    <a href="{{ route('posts.mine') }}"
                        class="group flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium text-sm transition-colors">
                        <span>View All</span>
                        <i class="ti ti-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="p-6">
                @forelse ($recentPosts as $index => $post)
                    <div x-data="{ menuOpen: false }"
                        class="group {{ !$loop->last ? 'border-b border-gray-100 pb-6 mb-6' : '' }}">
                        <div class="flex gap-4">
                            <!-- Post Index -->
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-bold text-indigo-600">{{ $index + 1 }}</span>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="flex-1 min-w-0">
                                <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                                    <p class="text-gray-800 leading-relaxed">{{ $post->body }}</p>
                                </div>

                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <i class="ti ti-clock text-xs"></i>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Post Actions -->
                                    <div class="relative">
                                        <button @click="menuOpen = !menuOpen"
                                            class="opacity-0 group-hover:opacity-100 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-lg transition-all duration-200">
                                            <i class="ti ti-dots text-sm"></i>
                                        </button>

                                        <div x-show="menuOpen" @click.away="menuOpen = false" x-transition
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-10">
                                            <button
                                                @click.prevent="
                                                menuOpen = false;
                                                $dispatch('open-edit-modal', {
                                                    body: @js($post->body),
                                                    url: '{{ route('posts.update', $post) }}'
                                                })"
                                                class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="ti ti-edit text-blue-500"></i>
                                                <span>Edit Post</span>
                                            </button>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                    <i class="ti ti-trash text-red-500"></i>
                                                    <span>Delete Post</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-article text-2xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">No posts yet</h4>
                        <p class="text-gray-500 mb-6 max-w-sm mx-auto">Start sharing your thoughts and updates with your
                            network!</p>
                        <a href="{{ route('feed.index') }}"
                            class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-indigo-700 transition-colors">
                            <i class="ti ti-plus text-sm"></i>
                            <span>Create First Post</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Connections Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-teal-500 to-blue-500 rounded-xl flex items-center justify-center">
                            <i class="ti ti-users text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Your Network</h3>
                            <p class="text-sm text-gray-600">Recent professional connections</p>
                        </div>
                    </div>
                    <a href="{{ route('professionals.index') }}"
                        class="group flex items-center gap-2 text-teal-600 hover:text-teal-700 font-medium text-sm transition-colors">
                        <span>Explore People</span>
                        <i class="ti ti-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="p-6">
                @forelse ($recentConnections as $connection)
                    <div
                        class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors group {{ !$loop->last ? 'mb-4' : '' }}">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            <img class="w-14 h-14 rounded-xl object-cover border-2 border-gray-100 group-hover:border-teal-300 transition-all duration-200 group-hover:scale-105"
                                src="{{ $connection->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($connection->name) . '&background=0f766e&color=fff' }}"
                                alt="{{ $connection->name }}">
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 border-2 border-white rounded-full">
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-800 group-hover:text-teal-600 transition-colors truncate">
                                {{ $connection->name }}
                            </h4>
                            <p class="text-sm text-gray-600 truncate">
                                {{ $connection->profile->job_title ?? 'Professional' }}
                            </p>
                        </div>

                        <!-- Action -->
                        <div class="flex-shrink-0">
                            <button
                                class="opacity-0 group-hover:opacity-100 p-2 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all duration-200">
                                <i class="ti ti-message text-sm"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-users text-2xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">No connections yet</h4>
                        <p class="text-gray-500 mb-6 max-w-sm mx-auto">Start building your professional network by
                            connecting with colleagues and industry peers!</p>
                        <a href="{{ route('professionals.index') }}"
                            class="inline-flex items-center gap-2 bg-teal-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-teal-700 transition-colors">
                            <i class="ti ti-plus text-sm"></i>
                            <span>Find People</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            /* Custom animations */
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            /* Gradient text animation */
            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .animate-gradient {
                background: linear-gradient(-45deg, #667eea, #764ba2, #6B73FF, #9A8AFF);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }


            .card-hover:hover {
                transform: translateY(-2px);
            }


            * {
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            }
        </style>
    @endpush

@endsection
