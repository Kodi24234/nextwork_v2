<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('professional.dashboard', [
            'postCount'         => $user->posts()->count(),
            'connectionCount'   => $user->getFriends()->count(),
            'applicationCount'  => $user->jobApplications()->count(),
            'recentPosts'       => $user->posts()->withCount(['likes', 'comments'])->latest()->take(3)->get(),
            'recentConnections' => $user->getFriends()->take(4),
        ]);
    }
}
