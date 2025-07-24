<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;
// Personal user channel (optional, for notifications)
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Chat message channel (for 1-on-1 chat)
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return Chat::where('id', $chatId)
        ->where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })
        ->exists();
});
