<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index(Chat $chat)
    {
        $user = Auth::user();
        abort_if($chat->sender_id !== $user->id && $chat->receiver_id !== $user->id, 403);
        return $chat->messages()->with('sender')->get();
    }

    public function store(Request $request, Chat $chat)
    {
        $user = Auth::user();
        abort_if($chat->sender_id !== $user->id && $chat->receiver_id !== $user->id, 403);

        $receiverId = $chat->sender_id === $user->id
        ? $chat->receiver_id
        : $chat->sender_id;

        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        try {
            $message = Message::create([
                'chat_id'     => $chat->id,
                'sender_id'   => $user->id,
                'receiver_id' => $receiverId,
                'body'        => $request->input('body'),
            ]);

            $chat->touch();

            Log::info('✅ Message saved:', [
                'message_id'  => $message->id,
                'chat_id'     => $chat->id,
                'sender_id'   => $user->id,
                'receiver_id' => $receiverId,
            ]);

            // Broadcasting removed (not needed for non-realtime)
            return response()->json($message->load('sender'));
        } catch (\Exception $e) {
            Log::error('❌ Message save failed: ' . $e->getMessage());
            return response()->json(['error' => 'Message save failed'], 500);
        }
    }

    // NEW METHOD: Send message to a user (creates chat if needed)
    public function sendToUser(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|different:' . auth()->id(),
            'body'        => 'required|string|max:2000',
        ]);

        $senderId   = auth()->id();
        $receiverId = $request->receiver_id;

        try {
            // Find or create chat
            $chat = Chat::where(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
            })->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
            })->first();

            if (! $chat) {
                $chat = Chat::create([
                    'sender_id'   => $senderId,
                    'receiver_id' => $receiverId,
                ]);
                Log::info('🆕 New chat created:', ['chat_id' => $chat->id]);
            }

            // Create message
            $message = Message::create([
                'chat_id'     => $chat->id,
                'sender_id'   => $senderId,
                'receiver_id' => $receiverId,
                'body'        => $request->input('body'),
            ]);

            $chat->touch();

            Log::info('✅ Message sent to user:', [
                'message_id'  => $message->id,
                'chat_id'     => $chat->id,
                'sender_id'   => $senderId,
                'receiver_id' => $receiverId,
            ]);

            // Broadcasting removed (not needed for non-realtime)
            return response()->json([
                'message' => $message->load('sender'),
                'chat_id' => $chat->id,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Send to user failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }
}
