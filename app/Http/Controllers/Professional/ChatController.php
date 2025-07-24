<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Load all chats with latest message, then sort by latestMessage.created_at
        $chats = Chat::with('latestMessage')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->get()
            ->sortBy(function ($chat) {
                return optional($chat->latestMessage)->created_at ?? $chat->created_at;
            })
            ->values();

        // Build chat map keyed by friend ID
        $chatMap = $chats->mapWithKeys(function ($chat) use ($user) {
            $friendId = $chat->sender_id === $user->id ? $chat->receiver_id : $chat->sender_id;
            return [$friendId => $chat];
        });

        // Get all connected friends
        $friends = $user->getFriends();
        // Sort friends by latest conversation (latest message timestamp)
        $friends = $friends->sortByDesc(function ($friend) use ($chatMap) {
            $chat = $chatMap[$friend->id] ?? null;
            return $chat && $chat->latestMessage ? $chat->latestMessage->created_at : null;
        })->values();

        return view('chat.index', compact('chats', 'friends', 'chatMap'));
    }
}
