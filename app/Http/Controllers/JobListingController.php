<?php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\View\View;

class JobListingController extends Controller
{
    //
    public function index(): View
    {
        $query = Job::where('status', 'open')->with('company');

        // Filter: Keyword (title or company)
        if (request()->filled('keyword')) {
            $keyword = request('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                    ->orWhereHas('company', function ($c) use ($keyword) {
                        $c->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // Filter: Location
        if (request()->filled('location')) {
            $query->where('location', 'like', '%' . request('location') . '%');
        }

        // Filter: Job Type
        if (request()->filled('type')) {
            $query->where('type', request('type'));
        }

        $jobs = $query->latest()->paginate(5)->withQueryString(); // keep filters on pagination

        return view('jobs.index', [
            'jobs' => $jobs,
        ]);
    }
    public function show(Job $job): View
    {
        $job->load('company'); // Load related company details

        return view('jobs.show', [
            'job' => $job,
        ]);
    }

}
