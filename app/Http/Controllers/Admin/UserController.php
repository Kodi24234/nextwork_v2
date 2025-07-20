<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $query = User::query();

        if (request('role')) {
            $query->role(request('role'));
        }

        if (request('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%');
            });
        }

        $users = $query->latest()->paginate(10)->appends(request()->query());

        return view('admin.users.index', compact('users'));
    }
}
