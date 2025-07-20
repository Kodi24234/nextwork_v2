<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WorkExperienceController extends Controller
{
    use AuthorizesRequests;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title'    => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'start_date'   => ['required', 'date'],
            'end_date'     => ['nullable', 'date', 'after_or_equal:start_date'],
            'description'  => ['nullable', 'string', 'max:5000'],
        ]);
        $request->user()->workExperiences()->create($validated);
        return redirect()->route('profile.show')->with('success', 'Work experience added successfully.');

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
    public function update(Request $request, WorkExperience $experience): RedirectResponse
    {
        //
        // 1. Authorize that the logged-in user owns this experience
        $this->authorize('update', $experience);

        // 2. Validate the incoming data
        $validated = $request->validate([
            'job_title'    => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'start_date'   => ['required', 'date'],
            'end_date'     => ['nullable', 'date', 'after_or_equal:start_date'],
            'description'  => ['nullable', 'string', 'max:5000'],
        ]);

        // 3. Update the model with the validated data
        $experience->update($validated);

        // 4. Redirect back with a success message
        return Redirect::route('profile.edit')->with('status', 'experience-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkExperience $experience): RedirectResponse
    {

        // 1. Authorize that the logged-in user owns this experience
        $this->authorize('delete', $experience);

        // 2. Delete the model from the database
        $experience->delete();

        // 3. Redirect back with a success message
        return Redirect::route('profile.edit')->with('status', 'experience-deleted');
    }
}
