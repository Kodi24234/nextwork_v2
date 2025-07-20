<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CompanyRegistrationController extends Controller
{
    //
    public function create(): View
    {
        // We will create this view in the next step
        return view('auth.company-register');
    }

    /**
     * Handle an incoming company registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the form data. Note the new fields.
        $request->validate([
            'user_name'    => ['required', 'string', 'max:255'], // The name of the person
            'company_name' => ['required', 'string', 'max:255'], // The name of the company
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'     => ['required', 'confirmed', Password::defaults()],
        ]);

        // 2. Create the User record for the person managing the page.
        $user = User::create([
            'name'     => $request->user_name, // Use 'user_name' from the form
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Assign the 'company' role to this new user.
        $user->assignRole('company');

        // 4. Create the associated Company record.
        $user->company()->create([
            'name' => $request->company_name, // Use 'company_name' from the form
        ]);

        // 5. Log the new user in.
        event(new Registered($user));
        Auth::login($user);

        // 6. Redirect them to their new company dashboard.
        // We will create this route later.
        return redirect()->route('company.dashboard');
    }
}
