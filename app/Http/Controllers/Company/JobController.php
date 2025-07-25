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

        return redirect()->route('company.jobs.index')->with('status', 'New job created successfully');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing
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

        return redirect()->route('company.jobs.index')->with('status', 'Job updated successfully');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('company.jobs.index')->with('status', 'job-deleted');
    }
    public function applicants(Request $request, Job $job): View
    {
        $this->authorize('update', $job);

        $query = $job->applicants()->with('profile');

        // 🔍 Filter: Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        //  Filter: Sort by name or created_at
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'name') {
                $query->orderBy('name');
            } else {
                $query->orderBy('job_applications.created_at', 'desc');
            }
        } else {
            $query->orderBy('job_applications.created_at', 'desc'); // default sort
        }

        $applicants = $query->paginate(10)->appends($request->query());

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

            'connectionStatus' => null,
            'connection'       => null,
        ]);
    }
}
