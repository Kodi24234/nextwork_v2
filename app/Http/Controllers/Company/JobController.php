<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $jobs = Auth::user()->company->jobs()
            ->withCount('applicants') // <-- ADD THIS
            ->paginate(10);
        return view('company.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Job::class);
        return view('company.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'salary'      => ['nullable', 'string', 'max:255'],
            'type'        => ['required', Rule::in(['Full-time', 'Part-time', 'Contract', 'Internship'])],
        ]);

        Auth::user()->company->jobs()->create($validated);

        return redirect()->route('company.jobs.index')->with('status', 'job-posted');
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
    public function edit(Job $job): View
    {
        $this->authorize('update', $job);
        return view('company.jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'salary'      => ['nullable', 'string', 'max:255'],
            'type'        => ['required', Rule::in(['Full-time', 'Part-time', 'Contract', 'Internship'])],
            'status'      => ['required', Rule::in(['open', 'closed'])],
        ]);

        $job->update($validated);

        return redirect()->route('company.jobs.index')->with('status', 'job-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('company.jobs.index')->with('status', 'job-deleted');
    }
    public function applicants(Job $job): View
    {
        // Security Check: Ensure the company viewing the applicants owns the job.
        $this->authorize('update', $job);

        // Eager load the applicant's profile for efficiency
        $applicants = $job->applicants()->with('profile')->paginate(10);

        return view('company.jobs.applicants', [
            'job'        => $job,
            'applicants' => $applicants,
        ]);
    }
    public function showApplicant(Job $job, User $applicant): View
    {
        $this->authorize('update', $job);
        $applicant->load(['profile', 'workExperiences', 'education', 'skills']);

        return view('company.applicants.show', [
            'user'             => $applicant,
            'job'              => $job,
            // --- ADD THESE TWO LINES, PASSING NULL ---
            'connectionStatus' => null,
            'connection'       => null,
        ]);
    }
}
