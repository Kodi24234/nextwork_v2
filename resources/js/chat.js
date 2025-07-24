// resources/js/chat.js

// Define messagesArea and other DOM elements here, or pass them
// If you need window.authId and window.chats, ensure they are set globally
// or passed as parameters when you call initChat.

let activeChannel = null;

export function listenToChat(chatId, messagesArea, authId) {
    if (!window.Echo) {
        console.warn('❗Echo not ready yet in chat.js, retrying...');
        setTimeout(() => listenToChat(chatId, messagesArea, authId), 300);
        return;
    }

    // Leave previous channel
    if (activeChannel) {
        window.Echo.leave(`chat.${activeChannel}`); // Use `chat.` prefix here
        console.log(`📡 Leaving channel: chat.${activeChannel}`);
    }

    activeChannel = chatId;
    console.log(`📡 Joining channel: chat.${activeChannel}`);


    // IMPORTANT: Ensure your channel name matches your backend (e.g., private-chat.chatId vs chat.chatId)
    // If your backend broadcasts to `private-chat.chatId`, change this line:
    // window.Echo.private(`private-chat.${chatId}`)
    // If it broadcasts to `chat.chatId`, then this is correct:
    window.Echo.private(`chat.${chatId}`)
        .listen('MessageSent', (e) => {
            console.log('📡 New real-time message:', e);

            if (e.message.sender_id !== authId) { // Access sender_id correctly, might be e.message.sender_id
                const bubble = document.createElement('div');
                bubble.className = 'bg-white p-2 rounded shadow text-sm w-max';
                bubble.textContent = e.message.body; // Access message body correctly, might be e.message.body
                messagesArea.appendChild(bubble);
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }
        })
        .error((error) => {
            console.error('Echo channel error:', error);
        });
}

export function initializeChatInteractions(authId, chats) {
    document.addEventListener('DOMContentLoaded', function() {
        const friendLinks = document.querySelectorAll('.friend-link');
        const chatHeader = document.getElementById('chat-header');
        const chatInterface = document.getElementById('chat-interface');
        const chatPlaceholder = document.getElementById('chat-placeholder');
        const messagesArea = document.getElementById('messages-area');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');

        friendLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const friendId = parseInt(this.dataset.friendId);
                const friendName = this.dataset.friendName;

                chatHeader.textContent = `Chat with ${friendName}`;
                chatPlaceholder.classList.add('hidden');
                chatInterface.classList.remove('hidden');

                const chat = chats.find(c =>
                    (c.sender_id === authId && c.receiver_id === friendId) ||
                    (c.receiver_id === authId && c.sender_id === friendId) // Corrected for finding the chat
                );

                if (!chat) {
                    messagesArea.innerHTML = `<div class="text-gray-400 italic">No chat history found.</div>`;
                    messageInput.disabled = true; // Disable input if no chat
                    sendButton.disabled = true;
                    return;
                } else {
                    messageInput.disabled = false;
                    sendButton.disabled = false;
                }

                const chatId = chat.id;
                window.activeChatId = chatId; // Keep this global if other parts need it

                // Pass messagesArea and authId to the listener
                listenToChat(chatId, messagesArea, authId);

                fetch(`/chats/${chatId}/messages`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        messagesArea.innerHTML = '';
                        if (data.length === 0) {
                            messagesArea.innerHTML = `<div class="text-gray-400 italic text-center">Start a conversation!</div>`;
                        } else {
                            data.forEach(message => {
                                const isMine = message.sender_id === authId;
                                const bubble = document.createElement('div');
                                bubble.className = isMine ?
                                    'bg-blue-100 p-2 rounded shadow text-sm w-max ml-auto' :
                                    'bg-white p-2 rounded shadow text-sm w-max';
                                bubble.textContent = message.body;
                                messagesArea.appendChild(bubble);
                            });
                        }
                        messagesArea.scrollTop = messagesArea.scrollHeight;
                    })
                    .catch(error => console.error('Error fetching messages:', error));
            });
        });

        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendButton.click();
            }
        });

        sendButton.addEventListener('click', function() {
            const message = messageInput.value.trim();
            const chatId = window.activeChatId;

            if (!message || !chatId) return;

            fetch(`/chats/${chatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        body: message
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    const bubble = document.createElement('div');
                    bubble.className = 'bg-blue-100 p-2 rounded shadow text-sm w-max ml-auto';
                    bubble.textContent = data.body;
                    messagesArea.appendChild(bubble);

                    messageInput.value = '';
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                })
                .catch(error => console.error('Error sending message:', error));
        });
    });
}
