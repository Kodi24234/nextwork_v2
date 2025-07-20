<?php
namespace App\Http\Controllers\Professional;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function show(Request $request): View
    {
        return view('professional.profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        $user = $request->user()->load('profile', 'workExperiences', 'education', 'skills');

        return view('professional.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Update the User model (name, email)
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 2. Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile->profile_picture_path) {
                Storage::disk('public')->delete($user->profile->profile_picture_path);
            }
            // Store the new picture and save the path
            $path                                = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile->profile_picture_path = $path;
        }

        // 3. Update the Profile model (headline, location, etc.)
        if (! $user->profile) {
            $user->profile()->create([
                'headline'     => $request->headline,
                'location'     => $request->location,
                'summary'      => $request->summary,
                'website_url'  => $request->website_url,
                'linkedin_url' => $request->linkedin_url,
            ]);
        } else {
            $user->profile->update([
                'headline'     => $request->headline,
                'location'     => $request->location,
                'summary'      => $request->summary,
                'website_url'  => $request->website_url,
                'linkedin_url' => $request->linkedin_url,
            ]);
        }

        // Save all profile changes
        // No need to call save() after update(), as update() already persists changes

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
