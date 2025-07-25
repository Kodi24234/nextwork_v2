<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
// If you still have a separate Company model, you can keep this.
// use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // Count users with the 'professional' role
        $professionalCount = User::role('professional')->count();

        //  count users with the 'company' role
        $companyCount = User::role('company')->count();

        // Count   jobs
        $jobCount       = Job::count();
        $openJobCount   = Job::where('status', 'open')->count();
        $closedJobCount = Job::where('status', 'closed')->count();

        $recentJobs = Job::with('company')->latest()->take(5)->get();

        $recentUsers     = User::latest()->take(5)->get();
        $recentCompanies = Company::with(['user', 'jobs'])
            ->latest()
            ->take(5)
            ->get();

        // Data for the user registration chart
        $userRegistrations = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $userChartLabels = $userRegistrations->map(function ($item) {
            return Carbon::parse($item->date)->format('M d');
        });

        $userChartData = $userRegistrations->pluck('count');

        $jobPostings = Job::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $jobChartLabels = $jobPostings->map(fn($item) => Carbon::parse($item->date)->format('M d'));
        $jobChartData   = $jobPostings->pluck('count');
        return view('admin.dashboard', [
            'professionalCount' => $professionalCount,
            'companyCount'      => $companyCount,
            'jobCount'          => $jobCount,
            'openJobCount'      => $openJobCount,
            'closedJobCount'    => $closedJobCount,
            'recentJobs'        => $recentJobs,
            'recentUsers'       => $recentUsers,
            'recentCompanies'   => $recentCompanies,
            'chartLabels'       => $userChartLabels,
            'chartData'         => $userChartData,
            'jobChartLabels'    => $jobChartLabels,
            'jobChartData'      => $jobChartData,
        ]);
    }
}
