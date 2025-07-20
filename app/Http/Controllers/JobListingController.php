<?php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\View\View;

class JobListingController extends Controller
{
    //
    public function index(): View
    {

        $jobs = Job::where('status', 'open')
            ->with('company')
            ->latest()
            ->paginate(10);

        return view('jobs.index', [
            'jobs' => $jobs,
        ]);
    }
    public function show(Job $job): View
    {
        // Eager load the company info for the detail view.
        $job->load('company');

        return view('jobs.show', [
            'job' => $job,
        ]);
    }
}
