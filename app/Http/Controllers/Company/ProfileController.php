<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    //
    public function edit(): View
    {
        // Get the authenticated user's company profile
        $company = Auth::user()->company;

        return view('company.profile.edit', [
            'company' => $company,
        ]);
    }

    /**
     * Update the company's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $company = Auth::user()->company;

        // 1. Validate the form data.
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'industry'    => ['nullable', 'string', 'max:255'],
            'about'       => ['nullable', 'string', 'max:5000'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // 2MB Max
        ]);

        // 2. Handle the logo upload if a new one is provided.
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }
            // Store the new logo and update the path in our validated data array
            $validated['logo_path'] = $request->file('logo')->store('company-logos', 'public');
        }

        // 3. Update the company record with the validated data.
        $company->update($validated);

        return back()->with('status', 'company-profile-updated');
    }
}
