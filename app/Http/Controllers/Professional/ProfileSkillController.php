<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ProfileSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //  Validate the request.
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        //  Find or create the skill. This prevents duplicate skills in the 'skills' table.
        $skillName = Str::title(trim($validated['name']));
        $skill     = Skill::firstOrCreate(['name' => $skillName]);

        // 3. Attach the skill to the user.

        $request->user()->skills()->syncWithoutDetaching($skill->id);

        // 4. Redirect back with a success message.
        return Redirect::route('profile.edit')->with('status', 'skill-added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Skill $skill): RedirectResponse
    {

        $request->user()->skills()->detach($skill->id);

        return Redirect::route('profile.edit')->with('status', 'skill-removed');
    }
}
