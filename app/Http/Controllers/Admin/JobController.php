<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;

class JobController extends Controller
{
    //
    public function index()
    {
        $query = Job::with('company');

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('company')) {
            $query->whereHas('company', function ($q) {
                $q->where('name', 'like', '%' . request('company') . '%');
            });
        }

        $jobs = $query->latest()->paginate(10)->appends(request()->query());

        return view('admin.jobs.index', compact('jobs'));
    }

}
