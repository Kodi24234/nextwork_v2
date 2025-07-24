@extends('layouts.nextwork')

@section('content')
    <div x-data="{ selectedChat: null, friendName: '', chatId: null }" class="flex h-screen bg-gray-100 overflow-hidden">

        {{-- Chat List Sidebar --}}
        <aside x-show="!selectedChat || window.innerWidth >= 768"
            :class="selectedChat && window.innerWidth < 768 ? 'hidden' : ''"
            class="w-full md:w-80 bg-white border-r border-gray-200 flex flex-col">

            {{-- Sidebar Header --}}
            <div class="px-6 py-4 bg-gradient-to-r from-teal-500 to-teal-600 text-white">
                <h1 class="text-xl font-semibold">Messages</h1>

            </div>

            {{-- Friends List --}}
            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-gray-100" id="friend-list">
                    @forelse ($friends as $friend)
                        @php
                            $chatMap = $chatMap ?? [];
                            $chat = $chatMap[$friend->id] ?? null;
                        @endphp

                        <li>
                            <a href="#"
                                class="friend-link flex items-center px-6 py-4 hover:bg-gray-50 transition-colors duration-200 group"
                                data-friend-id="{{ $friend->id }}" data-friend-name="{{ $friend->name }}"
                                @click.prevent="
                                    friendName = '{{ $friend->name }}';
                                    selectedChat = {{ $friend->id }};
                                    $nextTick(() => document.getElementById('load-chat-{{ $friend->id }}').click());
                                ">
                                {{-- Avatar --}}
                                <div class="relative">
                                    <img src="{{ $friend->profile->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($friend->name) . '&background=0f766e&color=fff' }}"
                                        alt="{{ $friend->name }}"
                                        class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-teal-300 transition-all" />

                                </div>

                                {{-- Chat Info --}}
                                <div class="ml-4 flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $friend->name }}</h3>
                                        @if ($chat && $chat->messages->isNotEmpty())
                                            <span class="text-xs text-gray-500">
                                                {{ $chat->latestMessage ? $chat->latestMessage->created_at->format('H:i') : '' }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($chat && $chat->messages->isNotEmpty())
                                        <p class="text-sm text-gray-600 truncate mt-1">
                                            {{ $chat->latestMessage ? $chat->latestMessage->body : '' }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-400 italic mt-1">No messages yet</p>
                                    @endif
                                </div>

                                {{-- Unread indicator (optional) --}}
                                <div class="ml-2">
                                    <div
                                        class="w-2 h-2 bg-teal-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>
                                </div>
                            </a>

                            {{-- Hidden button to trigger JavaScript loading --}}
                            <button id="load-chat-{{ $friend->id }}" class="hidden"
                                onclick="loadChat({{ $friend->id }}, '{{ $friend->name }}')"></button>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center">
                            <div class="text-gray-400 mb-2">
                                <i class="fas fa-comments text-3xl"></i>
                            </div>
                            <p class="text-gray-500">No connections yet</p>
                            <p class="text-sm text-gray-400 mt-1">Start connecting with people!</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </aside>

        {{-- Main Chat Area --}}
        <main class="flex-1 flex flex-col bg-white" x-show="selectedChat || window.innerWidth >= 768"
            :class="!selectedChat && window.innerWidth < 768 ? 'hidden' : ''">

            {{-- Chat Header --}}
            <header class="px-4 md:px-6 py-4 border-b border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        {{-- Mobile Back Button --}}
                        <button @click="selectedChat = null"
                            class="md:hidden mr-3 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>

                        {{-- Chat Info --}}
                        <div x-show="selectedChat" class="flex items-center">
                            <div
                                class="w-10 h-10 bg-teal-500 rounded-full flex items-center justify-center text-white font-semibold text-sm mr-3">
                                <span x-text="friendName ? friendName.charAt(0).toUpperCase() : ''"></span>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-900" x-text="friendName"></h2>

                            </div>
                        </div>

                        {{-- Default State --}}
                        <div x-show="!selectedChat" class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-comments text-gray-400"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-gray-900">Select a conversation</h2>
                                <p class="text-xs text-gray-500">Choose someone to start chatting</p>
                            </div>
                        </div>
                    </div>

                    {{-- Chat Actions --}}
                    <div x-show="selectedChat" class="flex items-center space-x-2">
                        <button
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-phone text-sm"></i>
                        </button>
                        <button
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-video text-sm"></i>
                        </button>
                        <button
                            class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="fas fa-ellipsis-v text-sm"></i>
                        </button>
                    </div>
                </div>
            </header>

            {{-- Messages Area --}}
            <div class="flex-1 flex flex-col min-h-0">
                <div id="messages-area" class="flex-1 overflow-y-auto px-4 md:px-6 py-4 space-y-3 bg-gray-50">

                    {{-- Default Empty State --}}
                    <div x-show="!selectedChat" class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-comments text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Welcome to Messages</h3>
                            <p class="text-gray-500 max-w-sm">Select a conversation from the sidebar to start chatting with
                                your connections.</p>
                        </div>
                    </div>

                    {{-- Loading State for Selected Chat --}}
                    <div x-show="selectedChat" class="h-full flex items-center justify-center" id="loading-state">
                        <div class="text-center">
                            <div
                                class="animate-spin w-8 h-8 border-2 border-teal-500 border-t-transparent rounded-full mx-auto mb-2">
                            </div>
                            <p class="text-gray-500">Loading messages...</p>
                        </div>
                    </div>
                </div>

                {{-- Message Input Area --}}
                <div class="border-t border-gray-200 bg-white p-4 md:p-6">
                    <div x-show="selectedChat" class="flex items-end space-x-3">


                        {{-- Message Input --}}
                        <div class="flex-1 relative">
                            <textarea id="message-input" rows="1" placeholder="Type your message..."
                                class="w-full resize-none overflow-hidden border border-gray-300 rounded-2xl px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all max-h-32"
                                style="min-height: 44px;"></textarea>


                        </div>

                        {{-- Send Button --}}
                        <button id="send-button"
                            class="bg-teal-500 hover:bg-teal-600 text-white p-3 rounded-full transition-colors shadow-lg hover:shadow-xl transform hover:scale-105 duration-200">
                            <i class="fas fa-paper-plane text-lg"></i>
                        </button>
                    </div>

                    {{-- Placeholder when no chat selected --}}
                    <div x-show="!selectedChat" class="flex items-center justify-center py-4">
                        <p class="text-gray-400 text-sm">Select a conversation to start messaging</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('styles')
        <style>
            /* Custom scrollbar for messages area */
            #messages-area::-webkit-scrollbar {
                width: 6px;
            }

            #messages-area::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }

            #messages-area::-webkit-scrollbar-thumb {
                background: #cbd5e0;
                border-radius: 3px;
            }

            #messages-area::-webkit-scrollbar-thumb:hover {
                background: #a0aec0;
            }

            /* Auto-resize textarea */
            #message-input {
                field-sizing: content;
            }

            /* Message bubble animations */
            .message-bubble {
                animation: slideIn 0.3s ease-out;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Mobile optimization */
            @media (max-width: 768px) {
                #messages-area {
                    height: calc(100vh - 200px);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            window.authId = {{ auth()->id() }};
            window.chats = @json($chats);
            let currentFriendId = null;

            // Auto-resize textarea
            document.addEventListener('DOMContentLoaded', function() {
                const textarea = document.getElementById('message-input');
                if (textarea) {
                    textarea.addEventListener('input', function() {
                        this.style.height = 'auto';
                        this.style.height = Math.min(this.scrollHeight, 128) + 'px';
                    });
                }
            });

            function loadChat(friendId, friendName) {
                const messagesArea = document.getElementById('messages-area');
                const loadingState = document.getElementById('loading-state');

                currentFriendId = friendId;

                // Show loading state
                if (loadingState) {
                    loadingState.style.display = 'flex';
                }

                const chat = window.chats.find(c =>
                    (c.sender_id === window.authId && c.receiver_id === friendId) ||
                    (c.sender_id === friendId && c.receiver_id === window.authId)
                );

                if (!chat) {
                    displayEmptyChat();
                    window.activeChatId = null;
                    return;
                }

                const chatId = chat.id;
                window.activeChatId = chatId;

                fetch(`/chats/${chatId}/messages`)
                    .then(res => res.json())
                    .then(data => {
                        displayMessages(data);
                    })
                    .catch(error => {
                        console.error('Error fetching messages:', error);
                        displayError();
                    })
                    .finally(() => {
                        if (loadingState) {
                            loadingState.style.display = 'none';
                        }
                    });
            }

            function displayMessages(messages) {
                const messagesArea = document.getElementById('messages-area');
                messagesArea.innerHTML = '';

                if (messages.length === 0) {
                    displayEmptyChat();
                    return;
                }

                messages.forEach(message => {
                    const messageElement = createMessageElement(message);
                    messagesArea.appendChild(messageElement);
                });

                scrollToBottom();
            }

            function displayEmptyChat() {
                const messagesArea = document.getElementById('messages-area');
                messagesArea.innerHTML = `
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-comment text-2xl text-teal-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Start the conversation!</h3>
                            <p class="text-gray-500">Send a message to begin chatting.</p>
                        </div>
                    </div>
                `;
            }

            function displayError() {
                const messagesArea = document.getElementById('messages-area');
                messagesArea.innerHTML = `
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Error loading messages</h3>
                            <p class="text-gray-500">Please try again later.</p>
                        </div>
                    </div>
                `;
            }

            function createMessageElement(message) {
                const isMine = message.sender_id === window.authId;
                const messageDiv = document.createElement('div');
                messageDiv.className = `message-bubble flex ${isMine ? 'justify-end' : 'justify-start'}`;

                const bubble = document.createElement('div');
                bubble.className = `max-w-xs lg:max-w-md px-4 py-2 rounded-2xl text-sm shadow-sm ${
                    isMine
                        ? 'bg-teal-500 text-white rounded-br-md'
                        : 'bg-white text-gray-800 border border-gray-200 rounded-bl-md'
                }`;

                // Add message text
                const textSpan = document.createElement('span');
                textSpan.textContent = message.body;
                bubble.appendChild(textSpan);

                // Add timestamp
                const timeSpan = document.createElement('div');
                timeSpan.className = `text-xs mt-1 ${isMine ? 'text-teal-100' : 'text-gray-500'}`;
                timeSpan.textContent = formatTime(message.created_at);
                bubble.appendChild(timeSpan);

                messageDiv.appendChild(bubble);
                return messageDiv;
            }

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function scrollToBottom() {
                const messagesArea = document.getElementById('messages-area');
                setTimeout(() => {
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }, 100);
            }

            function sendMessage() {
                const textarea = document.getElementById('message-input');
                const message = textarea.value.trim();
                if (!message) return;

                if (!window.activeChatId && currentFriendId) {
                    sendMessageToUser(currentFriendId, message);
                } else if (window.activeChatId) {
                    sendMessageToChat(window.activeChatId, message);
                } else {
                    alert('Please select a friend to chat with first.');
                }
            }

            function sendMessageToUser(receiverId, message) {
                const textarea = document.getElementById('message-input');

                return fetch('/messages/send-to-user', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            body: message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        window.activeChatId = data.chat_id;
                        if (!window.chats.find(c => c.id === data.chat_id)) {
                            window.chats.push({
                                id: data.chat_id,
                                sender_id: window.authId,
                                receiver_id: receiverId
                            });
                        }

                        const messagesArea = document.getElementById('messages-area');
                        const messageElement = createMessageElement(data.message);
                        messagesArea.appendChild(messageElement);

                        textarea.value = '';
                        textarea.style.height = 'auto';
                        scrollToBottom();
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Failed to send message. Please try again.');
                    });
            }

            function sendMessageToChat(chatId, message) {
                const textarea = document.getElementById('message-input');

                return fetch(`/chats/${chatId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            body: message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const messagesArea = document.getElementById('messages-area');
                        const messageElement = createMessageElement(data);
                        messagesArea.appendChild(messageElement);

                        textarea.value = '';
                        textarea.style.height = 'auto';
                        scrollToBottom();
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Failed to send message. Please try again.');
                    });
            }

            // Event listeners
            document.addEventListener('DOMContentLoaded', function() {
                const messageInput = document.getElementById('message-input');
                const sendButton = document.getElementById('send-button');

                if (messageInput) {
                    messageInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            sendMessage();
                        }
                    });
                }

                if (sendButton) {
                    sendButton.addEventListener('click', sendMessage);
                }
            });

            // Handle window resize for mobile responsiveness
            window.addEventListener('resize', function() {
                // Force Alpine.js to re-evaluate display conditions
                if (window.Alpine) {
                    window.Alpine.nextTick(() => {
                        // Trigger re-evaluation
                    });
                }
            });
        </script>
    @endpush
@endsection
