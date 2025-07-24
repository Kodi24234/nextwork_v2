@extends('layouts.nextwork')

@section('title', 'News Feed')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mb-20">
        <!-- Success Message -->
        @if (session('status') === 'post-created')
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center justify-between gap-3 bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-800 border border-emerald-200 px-4 py-3 rounded-xl shadow-sm mb-6">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <i class="ti ti-circle-check text-xl text-emerald-600"></i>
                    </div>
                    <span class="font-medium">Post published successfully!</span>
                </div>
                <button @click="show = false"
                    class="text-emerald-600 hover:text-emerald-800 transition-colors p-1 rounded-full hover:bg-emerald-100">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
        @endif

        <!-- Create Post Trigger -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md p-6 mb-6 border border-gray-100 cursor-pointer transition-all duration-200 hover:border-teal-200"
            x-data @click="$dispatch('open-post-modal')">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100"
                        src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                        alt="{{ Auth::user()->name }}" />
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-teal-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1 bg-gray-50 rounded-full px-6 py-3 hover:bg-gray-100 transition-colors">
                    <span class="text-gray-600">What's on your mind, {{ Auth::user()->name }}?</span>
                </div>
            </div>

        </div>

        <!-- Posts Loop -->
        <div class="space-y-6">
            @forelse ($posts as $post)
                <article x-data="{ commentsOpen: false }"
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 overflow-hidden">

                    <!-- Post Header -->
                    <div class="flex items-start justify-between p-6 pb-4">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100"
                                    src="{{ $post->user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=FFFFFF&background=14B8A6' }}"
                                    alt="{{ $post->user->name }}">
                                <div
                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div>
                                <h3
                                    class="font-semibold text-gray-900 hover:text-teal-600 cursor-pointer transition-colors">
                                    {{ $post->user->name }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <span class="inline-flex items-center gap-1">
                                        <i class="ti ti-briefcase text-xs"></i>
                                        Professional
                                    </span>
                                    <span>•</span>
                                    <time class="hover:text-gray-700 transition-colors"
                                        title="{{ $post->created_at->format('M j, Y \a\t g:i A') }}">
                                        {{ $post->created_at->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                        </div>

                        @can('update', $post)
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-10">
                                    <button
                                        @click.prevent="
                                        open = false;
                                        $dispatch('open-edit-modal', {
                                            body: @js($post->body),
                                            url: '{{ route('posts.update', $post) }}'
                                        })"
                                        class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="ti ti-edit text-blue-500"></i>
                                        Edit Post
                                    </button>

                                    <div x-data="{ showDeleteModal: false }">
                                        <!-- Trigger Button -->
                                        <button type="button" @click="showDeleteModal = true"
                                            class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="ti ti-trash text-red-500"></i>
                                            Delete Post
                                        </button>

                                        <!-- Modal -->
                                        <div x-show="showDeleteModal" x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                            <div @click.away="showDeleteModal = false"
                                                class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 space-y-4 text-center">
                                                <h2 class="text-xl font-semibold text-gray-800">Delete Post?</h2>
                                                <p class="text-gray-600 text-sm">Are you sure you want to delete this post? This
                                                    action cannot be undone.</p>

                                                <div class="flex justify-center gap-4 mt-4">
                                                    <button @click="showDeleteModal = false"
                                                        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @endcan
                    </div>

                    <!-- Post Content -->
                    <div class="px-6 pb-4">
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $post->body }}</p>
                        </div>
                    </div>

                    <!-- Engagement Stats & Actions -->
                    <div x-data="likeComponent({{ $post->isLikedByAuthUser() ? 'true' : 'false' }}, {{ $post->likes_count }}, {{ $post->id }})">
                        <!-- Stats -->
                        <div
                            class="flex justify-between items-center text-sm text-gray-500 px-6 py-3 border-t border-gray-50">
                            <div class="flex items-center gap-2">
                                <div class="flex -space-x-1">
                                    <div
                                        class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                        <i class="ti ti-thumb-up text-white text-xs"></i>
                                    </div>

                                </div>
                                <span x-text="likeCount + ' like' + (likeCount !== 1 ? 's' : '')"
                                    class="hover:underline cursor-pointer"></span>
                            </div>
                            <button @click="commentsOpen = !commentsOpen" class="hover:underline cursor-pointer">
                                {{ $post->comments_count }} comment{{ $post->comments_count !== 1 ? 's' : '' }}
                            </button>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex border-t border-gray-100 bg-gray-50">
                            <button @click.prevent="toggleLike()" :disabled="isLoading"
                                :class="{ 'text-blue-600 bg-blue-50': isLiked, 'text-gray-600 hover:bg-gray-100': !isLiked }"
                                class="flex-1 flex items-center justify-center gap-2 py-3 font-medium transition-all duration-200 hover:bg-gray-100">
                                <div class="relative">
                                    <template x-if="isLiked">
                                        <i class="ti ti-thumb-up-filled text-lg"></i>
                                    </template>
                                    <template x-if="!isLiked">
                                        <i class="ti ti-thumb-up text-lg"></i>
                                    </template>

                                </div>
                                <span x-text="isLiked ? 'Liked' : 'Like'"></span>
                            </button>

                            <button @click="commentsOpen = !commentsOpen"
                                :class="{ 'text-teal-600 bg-teal-50': commentsOpen, 'text-gray-600': !commentsOpen }"
                                class="flex-1 flex items-center justify-center gap-2 py-3 font-medium hover:bg-gray-100 transition-all duration-200">
                                <i class="ti ti-message-circle text-lg"></i>
                                <span>Comment</span>
                            </button>


                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div x-data="commentComponent({{ $post->id }})" x-show="commentsOpen"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
                        class="border-t border-gray-100 bg-gray-50 overflow-hidden">

                        <!-- New Comment Form -->
                        <div class="p-6 pb-4">
                            <div class="flex items-start gap-3">
                                <img class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-100"
                                    src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                                    alt="{{ Auth::user()->name }}" />
                                <div class="flex-1">
                                    <form @submit.prevent="submitComment" class="relative">
                                        <textarea x-model="commentBody" x-ref="commentInput"
                                            x-on:input="$refs.commentInput.style.height = 'auto'; $refs.commentInput.style.height = $refs.commentInput.scrollHeight + 'px'"
                                            class="w-full text-sm border-gray-200 focus:border-teal-400 focus:ring-teal-400 rounded-xl shadow-sm resize-none overflow-hidden bg-white placeholder-gray-500"
                                            style="min-height: 44px;" placeholder="Write a thoughtful comment..." rows="1" required></textarea>

                                        <div class="flex justify-between items-center mt-3">

                                            <button type="submit"
                                                :disabled="isSubmitting || commentBody.trim() === ''"
                                                :class="{
                                                    'opacity-50 cursor-not-allowed': isSubmitting || commentBody
                                                        .trim() === ''
                                                }"
                                                class="bg-teal-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-teal-700 transition-all text-sm flex items-center gap-2">
                                                <span x-show="!isSubmitting">Post</span>
                                                <span x-show="isSubmitting" class="flex items-center gap-2">
                                                    <div
                                                        class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin">
                                                    </div>
                                                    Posting...
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Comments List -->
                        <div class="px-6 pb-6 space-y-4">
                            <!-- Dynamic Comments -->
                            <template x-for="comment in comments" :key="comment.id">
                                <div class="flex items-start gap-3">
                                    <img class="h-8 w-8 rounded-full object-cover ring-1 ring-gray-200"
                                        src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                                        alt="comment.user.name" />
                                    <div class="flex-1 min-w-0">
                                        <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-gray-100">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-semibold text-sm text-gray-900"
                                                    x-text="comment.user.name"></span>
                                                <time class="text-xs text-gray-500">just now</time>
                                            </div>
                                            <p class="text-sm text-gray-700 leading-relaxed break-words"
                                                x-text="comment.body"></p>
                                        </div>
                                        <div class="flex items-center gap-4 mt-2 px-4">
                                            <button
                                                class="text-xs text-gray-500 hover:text-blue-600 font-medium transition-colors">Like</button>
                                            <button
                                                class="text-xs text-gray-500 hover:text-gray-700 font-medium transition-colors">Reply</button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Server-side Comments -->
                            @foreach ($post->comments as $comment)
                                <div class="flex items-start gap-3">
                                    <img class="h-8 w-8 rounded-full object-cover ring-1 ring-gray-200"
                                        src="{{ $comment->user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&color=FFFFFF&background=14B8A6' }}"
                                        alt="{{ $comment->user->name }}" />
                                    <div class="flex-1 min-w-0">
                                        <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-gray-100">
                                            <div class="flex items-center justify-between mb-1">
                                                <span
                                                    class="font-semibold text-sm text-gray-900">{{ $comment->user->name }}</span>
                                                <div class="flex items-center gap-2">
                                                    <time class="text-xs text-gray-500"
                                                        title="{{ $comment->created_at->format('M j, Y \a\t g:i A') }}">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </time>
                                                    @can('delete', $comment)
                                                        <div x-data="{ showCommentDeleteModal: false }" class="relative inline-block">
                                                            <!-- Delete Button -->
                                                            <button @click="showCommentDeleteModal = true"
                                                                class="text-xs text-gray-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50"
                                                                title="Delete comment">
                                                                <i class="ti ti-trash"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div x-show="showCommentDeleteModal" x-cloak
                                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                                                <div @click.away="showCommentDeleteModal = false"
                                                                    class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6 text-center space-y-4">
                                                                    <h2 class="text-lg font-semibold text-gray-800">Delete
                                                                        Comment?</h2>
                                                                    <p class="text-sm text-gray-600">Are you sure you want to
                                                                        delete this comment? This action cannot be undone.</p>

                                                                    <div class="flex justify-center gap-4 mt-4">
                                                                        <button @click="showCommentDeleteModal = false"
                                                                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                                                            Cancel
                                                                        </button>
                                                                        <form
                                                                            action="{{ route('comments.destroy', $comment) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                                                                                Delete
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endcan

                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-700 leading-relaxed break-words">
                                                {{ $comment->body }}</p>
                                        </div>
                                        <div class="flex items-center gap-4 mt-2 px-4">
                                            <button
                                                class="text-xs text-gray-500 hover:text-blue-600 font-medium transition-colors">Like</button>
                                            <button
                                                class="text-xs text-gray-500 hover:text-gray-700 font-medium transition-colors">Reply</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </article>
            @empty
                <div class="text-center py-16">
                    <div
                        class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-teal-400 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-activity-heartbeat text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">The feed is quiet...</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Be the first to share something with the network! Your
                        thoughts and updates help keep the community connected.</p>
                    <button @click="$dispatch('open-post-modal')"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-blue-600 text-white font-semibold px-6 py-3 rounded-xl hover:from-teal-700 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="ti ti-plus"></i>
                        Create Your First Post
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Create Post Modal -->
    <div x-data="{ open: false }" x-on:open-post-modal.window="open = true" x-cloak>
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white w-full max-w-2xl mx-auto rounded-2xl shadow-2xl overflow-hidden">

                <div class="bg-gradient-to-r from-teal-600 to-blue-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">Create Post</h2>
                        <button @click="open = false"
                            class="text-white hover:text-gray-200 transition-colors p-2 rounded-full hover:bg-white hover:bg-opacity-20">
                            <i class="ti ti-x text-xl"></i>
                        </button>
                    </div>
                </div>

                <form action="{{ route('posts.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="flex items-start gap-4 mb-4">
                        <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100"
                            src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                            alt="{{ Auth::user()->name }}" />
                        <div>
                            <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500">Posting to your network</p>
                        </div>
                    </div>

                    <textarea name="body" rows="6" class="w-full border-0 focus:ring-0 resize-none text-lg placeholder-gray-400"
                        placeholder="What's on your mind, {{ Auth::user()->name }}?" style="outline: none;">{{ old('body') }}</textarea>

                    <x-input-error :messages="$errors->get('body')" class="mt-2 text-red-500 text-sm" />

                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                        <div class="ml-auto">
                            <button type="submit"
                                class="bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                Post
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Edit Post Modal -->
    <div x-data="{ open: false, postBody: '', postUrl: '' }"
        x-on:open-edit-modal.window="open = true;postBody = $event.detail.body;postUrl = $event.detail.url;$nextTick(() => $refs.edit_textarea.focus());"
        x-cloak>
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white w-full max-w-2xl mx-auto rounded-2xl shadow-2xl overflow-hidden">

                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">Edit Post</h2>
                        <button @click="open = false"
                            class="text-white hover:text-gray-200 transition-colors p-2 rounded-full hover:bg-white hover:bg-opacity-20">
                            <i class="ti ti-x text-xl"></i>
                        </button>
                    </div>
                </div>

                <form x-bind:action="postUrl" method="POST" class="p-6">
                    @csrf
                    @method('PATCH')

                    <textarea name="body" rows="6" class="w-full border-0 focus:ring-0 resize-none text-lg placeholder-gray-400"
                        x-model="postBody" x-ref="edit_textarea" style="outline: none;"></textarea>

                    <x-input-error :messages="$errors->get('body')" class="mt-2 text-red-500 text-sm" />

                    <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Post Modal -->



    <!-- JavaScript Components -->
    <script>
        function likeComponent(initialIsLiked, initialLikeCount, postId) {
            return {
                isLiked: initialIsLiked,
                likeCount: initialLikeCount,
                isLoading: false,

                toggleLike() {
                    if (this.isLoading) return;

                    this.isLoading = true;
                    const url = `/posts/${postId}/like`;
                    const method = this.isLiked ? 'DELETE' : 'POST';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (method === 'POST') {
                                this.isLiked = true;
                                this.likeCount++;
                            } else {
                                this.isLiked = false;
                                this.likeCount--;
                            }
                        })
                        .catch(error => console.error('Error:', error))
                        .finally(() => {
                            this.isLoading = false;
                        });
                }
            }
        }

        function commentComponent(postId) {
            return {
                commentBody: '',
                isSubmitting: false,
                error: '',
                comments: [],

                submitComment() {
                    if (this.isSubmitting || this.commentBody.trim() === '') return;

                    this.isSubmitting = true;
                    this.error = '';

                    fetch(`/posts/${postId}/comments`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                body: this.commentBody
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to post comment');
                            return response.json();
                        })
                        .then(data => {
                            this.comments.unshift(data.comment);
                            this.commentBody = '';
                            // Reset textarea height
                            this.$refs.commentInput.style.height = '44px';
                        })
                        .catch(error => {
                            console.error(error);
                            this.error = 'Could not post comment. Please try again.';
                        })
                        .finally(() => {
                            this.isSubmitting = false;
                        });
                }
            };
        }
    </script>

@endsection
