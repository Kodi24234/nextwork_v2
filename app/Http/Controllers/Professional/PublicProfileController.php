<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    //
    // In app/Http/Controllers/Professional/PublicProfileController.php

    public function index(): View
    {
        $authUser = Auth::user();

        // 1. Get all professionals, excluding the logged-in user.
        $professionals = User::whereHas('roles', fn($q) => $q->where('name', 'professional'))
            ->where('id', '!=', $authUser->id)
            ->with('profile')
            ->paginate(12);

        // 2. Get all connection statuses for the professionals on the current page.
        $professionalIdsOnPage = $professionals->pluck('id');

        $connections = Connection::whereIn('requester_id', [$authUser->id])
            ->whereIn('addressee_id', $professionalIdsOnPage)
            ->orWhereIn('requester_id', $professionalIdsOnPage)
            ->whereIn('addressee_id', [$authUser->id])
            ->get()
            ->keyBy(function ($item) use ($authUser) {
                // Key the collection by the OTHER person's ID for easy lookup
                return $item->requester_id == $authUser->id ? $item->addressee_id : $item->requester_id;
            });

        return view('professional.index', [
            'professionals' => $professionals,
            'connections'   => $connections,
        ]);
    }

    /**
     * Display the specified professional's profile.
     */
    public function show(User $user): View
    {
        // Eager load all the necessary relationships
        $user->load(['profile', 'workExperiences', 'education', 'skills']);

        $authUser         = Auth::user();
        $connectionStatus = null;
        $connection       = null;

        // We only need to check for a connection if the user is not viewing their own profile
        if ($authUser->id !== $user->id) {
            // Use the helper methods we created in the User model
            $connectionStatus = $authUser->getConnectionStatusWith($user);
            $connection       = $authUser->getConnectionWith($user);
        }

        return view('professional.show', [
            'user'             => $user,
            'connectionStatus' => $connectionStatus,
            'connection'       => $connection,
        ]);
    }
}
