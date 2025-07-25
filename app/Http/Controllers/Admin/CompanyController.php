<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    //
    public function index()
    {
        $query = Company::with(['user', 'jobs']);

        // Search filter
        if ($search = request('search')) {
            $query->where('name', 'like', "%$search%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
        }

        $companies = $query->latest()->paginate(10)->appends(request()->query());

        return view('admin.companies.index', compact('companies'));
    }

}
