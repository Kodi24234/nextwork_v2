<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //

    public function index(): View
    {
        // Get the authenticated user and their associated company profile
        $user = Auth::user()->load('company');

        return view('company.dashboard', [
            'user'    => $user,
            'company' => $user->company,
        ]);
    }
}
