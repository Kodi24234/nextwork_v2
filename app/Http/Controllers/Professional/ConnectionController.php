<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Models\User;
use App\Notifications\NewConnectionRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ConnectionController extends Controller
{
    //

    use AuthorizesRequests;
    // public function getConnectionWith(User $otherUser)
    // {
    //     return Connection::where(function ($query) use ($otherUser) {
    //         $query->where('requester_id', $this->id)
    //             ->where('addressee_id', $otherUser->id);
    //     })->orWhere(function ($query) use ($otherUser) {
    //         $query->where('requester_id', $otherUser->id)
    //             ->where('addressee_id', $this->id);
    //     })->first();
    // }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $requester = Auth::user();
        $user      = User::findOrFail($request->input('user_id'));

        if ($requester->id === $user->id) {
            return Redirect::back()->with('error', 'You cannot connect with yourself.');
        }

        $existingConnection = $requester->getConnectionWith($user);
        if ($existingConnection) {
            return Redirect::back()->with('error', 'A connection request already exists.');
        }

        Connection::create([
            'requester_id' => $requester->id,
            'addressee_id' => $user->id,
            'status'       => 'pending',
        ]);

        $user->notify(new NewConnectionRequest($requester));

        return Redirect::back()->with('status', 'Connection request sent!');
    }

    /**
     * Accept a pending connection request.
     */
    public function update(Request $request, Connection $connection): RedirectResponse
    {
        // Security Check: Ensure the person accepting is the one who received the request
        if ($connection->addressee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update the status to 'accepted'
        $connection->update(['status' => 'accepted']);

        return Redirect::back()->with('status', 'Connection accepted!');
    }

    /**
     * Decline a pending request or remove an existing connection.
     */
    public function destroy(Connection $connection): RedirectResponse
    {
        $currentUser = Auth::user();

        // Security Check: Ensure the user is part of this connection
        if ($connection->requester_id !== $currentUser->id && $connection->addressee_id !== $currentUser->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the connection record entirely
        $connection->delete();

        return Redirect::back()->with('status', 'Connection removed.');
    }

}
