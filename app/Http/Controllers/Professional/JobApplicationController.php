<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JobApplicationController extends Controller
{
    //
    public function store(Request $request, Job $job): RedirectResponse
    {
        $user = $request->user();

        // Prevent a company from applying to their own job
        if ($user->company && $user->company->id === $job->company_id) {
            return Redirect::back()->with('error', 'You cannot apply to your own company\'s job.');
        }

        // The `syncWithoutDetaching` method creates the link
        // in the pivot table but won't create a duplicate if the user somehow applies twice.
        $job->applicants()->syncWithoutDetaching($user->id);

        //  can add a notification to the company here later.

        return Redirect::route('jobs.show', $job)->with('status', 'application-submitted');
    }
}
