<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EducationController extends Controller
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
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'degree'           => ['required', 'string', 'max:255'],
            'field_of_study'   => ['nullable', 'string', 'max:255'],
            'start_date'       => ['required', 'date'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'description'      => ['nullable', 'string', 'max:5000'],
        ]);

        $request->user()->education()->create($validated);

        return back()->with('status', 'education-added');

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
    public function update(Request $request, Education $education): RedirectResponse
    {
        $this->authorize('update', $education);

        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'degree'           => ['required', 'string', 'max:255'],
            'field_of_study'   => ['nullable', 'string', 'max:255'],
            'start_date'       => ['required', 'date'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'description'      => ['nullable', 'string', 'max:5000'],
        ]);

        $education->update($validated);

        return Redirect::route('profile.edit')->with('status', 'education-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education): RedirectResponse
    {
        $this->authorize('delete', $education);

        $education->delete();

        return Redirect::route('profile.edit')->with('status', 'education-deleted');
    }
}
