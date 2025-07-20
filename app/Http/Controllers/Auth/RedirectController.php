<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    //
    public function handle()
    {
        /** @var \App\Models\User $user */

        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('company')) {
            return redirect()->route('company.dashboard');
        }
        if ($user->hasRole('professional')) {
            return redirect()->route('feed.index');
        }

        return redirect()->route('welcome');
    }
}
