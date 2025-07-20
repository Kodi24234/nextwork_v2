<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{

    public function index()
    {
        $admins = User::role('admin')->latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'is_super_admin' => false,
        ]);

        $user->assignRole('admin');

        return redirect()->route('admin.admins.index')->with('success', 'Admin account created.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id() || $user->is_super_admin) {
            return back()->with('error', 'You cannot remove yourself or the super admin.');
        }

        $user->removeRole('admin');
        $user->delete();

        return back()->with('success', 'Admin removed.');
    }
}
