<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
    public function index(): View
    {
        $user = Auth::user()->load('company');

        $recentApplicants = DB::table('job_applications')
            ->join('users', 'job_applications.user_id', '=', 'users.id')
            ->join('jobs', 'job_applications.job_id', '=', 'jobs.id')
            ->whereIn('job_applications.job_id', $user->company->jobs()->pluck('id'))
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'jobs.title as job_title',
                'job_applications.created_at'
            )
            ->orderByDesc('job_applications.created_at')
            ->limit(5)
            ->get();

        return view('company.dashboard', [
            'user'             => $user,
            'company'          => $user->company,
            'recentApplicants' => $recentApplicants,
        ]);
    }
}
