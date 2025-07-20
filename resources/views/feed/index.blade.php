@extends('layouts.nextwork')

@section('title', 'News Feed')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Create Post Card -->
        <!-- Success Message -->
        @if (session('status') === 'post-created')
            <div x-data="{ show: true }" x-show="show" x-transition
                class="flex items-center justify-between gap-2 bg-teal-50 text-teal-700 border border-teal-200 px-4 py-2 rounded-lg text-sm mb-6">
                <div class="flex items-center gap-2">
                    <i class="ti ti-circle-check text-lg"></i>
                    <span>Post published successfully!</span>
                </div>
                <button @click="show = false" class="text-teal-700 hover:text-teal-900">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
        @endif



        <!-- Post Trigger -->
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-3 border border-gray-200 cursor-pointer" x-data
            @click="$dispatch('open-post-modal')">
            <div class="flex items-center gap-4">
                <img class="h-10 w-10 rounded-full object-cover"
                    src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                    alt="{{ Auth::user()->name }}" />
                <span class="text-gray-500">What's on your mind, {{ Auth::user()->name }}?</span>
            </div>
        </div>

        <div class="mt-4 border-t border border-gray-200 mb-3"></div>


        <!-- Posts Loop -->
        <!-- Posts Loop -->
        <div class="space-y-3 ">
            @forelse ($posts as $post)
                <div x-data="{ commentsOpen: false }"
                    class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                    {{-- Post Header --}}
                    <div class="flex items-start justify-between ">
                        <div class="flex items-center gap-4">
                            <img class="h-12 w-12 rounded-full object-cover"
                                src="{{ $post->user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&color=FFFFFF&background=14B8A6' }}"
                                alt="{{ $post->user->name }}">
                            <div>
                                <p class="font-semibold text-gray-900 hover:underline">{{ $post->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $post->user->profile->headline ?? 'Nextwork Member' }}
                                </p>
                                </p>
                                <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        @can('update', $post)
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                    <button
                                        @click.prevent="
                                    open = false;
                                    $dispatch('open-edit-modal', {
                                        body: @js($post->body),
                                        url: '{{ route('posts.update', $post) }}'
                                    })"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</button>

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                    </div>

                    {{-- Post Body --}}
                    <p class="text-gray-800 whitespace-pre-wrap mt-3 text-sm leading-relaxed">{{ $post->body }}</p>


                    <!-- Like & Comment Stats + Buttons -->
                    <div x-data="likeComponent({{ $post->isLikedByAuthUser() ? 'true' : 'false' }}, {{ $post->likes_count }}, {{ $post->id }})">

                        <!-- Reaction Count (Top) -->
                        <div class="flex justify-between items-center text-sm text-gray-500 px-4 pt-3">
                            <div class="flex items-center gap-2">
                                <span x-text="likeCount + ' like' + (likeCount !== 1 ? 's' : '')"></span>
                            </div>
                            <div>
                                {{ $post->comments_count }} comment{{ $post->comments_count !== 1 ? 's' : '' }}
                            </div>
                        </div>

                        <!-- Action Buttons (Bottom) -->
                        <div
                            class="border-t border-gray-100 mt-2 px-4 py-3 text-sm text-gray-600 flex justify-around items-center">
                            <button @click.prevent="toggleLike()" :disabled="isLoading"
                                :class="{ 'font-bold text-teal-600 scale-105': isLiked, 'hover:text-teal-600': !isLiked }"
                                class="flex items-center gap-1 text-gray-600 hover:text-teal-600 hover:bg-gray-100 px-2 py-1 rounded-md transition-all duration-150 ease-in-out">
                                <template x-if="isLiked">
                                    <i class="ti ti-thumb-up-filled"></i>
                                </template>
                                <template x-if="!isLiked">
                                    <i class="ti ti-thumb-up"></i>
                                </template>
                                <span x-text="isLiked ? 'Liked' : 'Like'"></span>
                            </button>

                            <button @click="commentsOpen = !commentsOpen"
                                class="flex items-center gap-1 hover:text-teal-600 hover:bg-gray-100 px-3 py-1 rounded-md transition">
                                <i class="ti ti-message-circle"></i>
                                <span>Comment</span>
                            </button>
                        </div>
                    </div>
                    {{-- Comment Section --}}
                    <div x-data="commentComponent({{ $post->id }})" x-show="commentsOpen" x-transition
                        class="pt-4 mt-4 border-t border-gray-100 space-y-4">
                        {{-- New Comment Form --}}
                        <div class="flex items-start space-x-3">
                            <img class="h-9 w-9 rounded-full object-cover"
                                src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                                alt="{{ Auth::user()->name }}" />
                            <div class="flex-1">
                                <form @submit.prevent="submitComment">
                                    <input type="text" x-model="commentBody" x-ref="commentInput"
                                        x-on:input="$refs.commentInput.style.height = 'auto'; $refs.commentInput.style.height = $refs.commentInput.scrollHeight + 'px'"
                                        class="w-full text-sm border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm resize-none overflow-hidden"
                                        style="height: 38px;" placeholder="Write a comment..." required />

                                    <div class="flex justify-end mt-2">
                                        <button type="submit"
                                            class="bg-teal-600 text-white font-semibold px-4 py-1.5 rounded-md hover:bg-teal-700 text-xs"
                                            x-bind:disabled="isSubmitting">
                                            <span x-show="!isSubmitting">Post Comment</span>
                                            <span x-show="isSubmitting">Posting...</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Existing Comments --}}
                        <template x-for="comment in comments" :key="comment.id">
                            <div class="flex items-start space-x-3 w-full">
                                <img class="h-9 w-9 rounded-full object-cover"
                                    src="{{ Auth::user()->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=14B8A6' }}"
                                    alt="comment.user.name" />

                                <div class="flex-1 bg-gray-50 rounded-lg px-4 py-2 w-full min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-sm text-gray-800" x-text="comment.user.name"></span>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-1 break-all leading-relaxed w-full"
                                        x-text="comment.body"></p>
                                </div>
                            </div>
                        </template>

                        @foreach ($post->comments as $comment)
                            <div class="flex items-start space-x-3 w-full">
                                <img class="h-9 w-9 rounded-full object-cover"
                                    src="{{ $comment->user->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&color=FFFFFF&background=14B8A6' }}"
                                    alt="{{ $comment->user->name }}" />

                                <div class="flex-1 bg-gray-50 rounded-lg px-4 py-2 w-full min-w-0">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-sm text-gray-800">{{ $comment->user->name }}</span>
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-gray-400 hover:text-red-500"
                                                    title="Delete comment">×</button>
                                            </form>
                                        @endcan
                                    </div>
                                    <p class="text-sm text-gray-700 mt-1 break-all leading-relaxed w-full">
                                        {{ $comment->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @empty
                <div class="text-center text-gray-500 py-20">
                    <i class="ti ti-activity-heartbeat text-6xl text-teal-400 mb-4"></i>
                    <h3 class="text-2xl font-semibold">The feed is quiet...</h3>
                    <p class="mt-1">Be the first to share something with the network!</p>
                </div>
            @endforelse

        </div>

    </div>

    <!--Create  Modal -->
    <div x-data="{ open: false }" x-on:open-post-modal.window="open = true" x-cloak>
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="open = false" class="bg-white w-full max-w-xl mx-auto rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Create Post</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>

                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea name="body" rows="4"
                        class="w-full border border-gray-300 focus:border-teal-500 focus:ring-teal-100 rounded-lg px-4 py-2"
                        placeholder="What's on your mind, {{ Auth::user()->name }}?">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2 text-red-500 text-sm" />

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Post Modal -->
    <div x-data="{ open: false, postBody: '', postUrl: '' }"
        x-on:open-edit-modal.window="open = true;postBody = $event.detail.body;postUrl = $event.detail.url;$nextTick(() => $refs.edit_textarea.focus());"x-cloak>
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="open = false" class="bg-white w-full max-w-xl mx-auto rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Edit Post</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
                </div>


                <form x-bind:action="postUrl" method="POST">
                    @csrf
                    @method('PATCH')

                    <textarea name="body" rows="4"
                        class="w-full border border-gray-300 focus:border-teal-500 focus:ring-teal-100 rounded-lg px-4 py-2"
                        x-model="postBody" x-ref="edit_textarea"></textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2 text-red-500 text-sm" />

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function likeComponent(initialIsLiked, initialLikeCount, postId) {
            return {
                isLiked: initialIsLiked,
                likeCount: initialLikeCount,
                isLoading: false,

                toggleLike() {
                    if (this.isLoading) {
                        return;
                    }
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
                            // Update state based on the action
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
    </script>
    <script>
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
                            this.comments.unshift(data.comment); // Optional: auto-display
                            this.commentBody = '';
                        })
                        .catch(error => {
                            console.error(error);
                            this.error = 'Could not post comment. Try again.';
                        })
                        .finally(() => {
                            this.isSubmitting = false;
                        });
                }
            };
        }
    </script>


@endsection
