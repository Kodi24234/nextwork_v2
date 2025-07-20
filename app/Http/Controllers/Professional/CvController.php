<?php
namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CvController extends Controller
{
    //
    public function index()
    {
        return view('cv.index');
    }
    public function update(Request $request)
    {
        $request->validate([
            'field' => 'required|in:headline,summary',
            'value' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->profile()->update([
            $request->field => $request->value,
        ]);

        return redirect()->route('cv.index')->with('status', 'updated');
    }
    public function preview()
    {
        $user = Auth::user();

        return view('cv.preview', compact('user'));
    }

    public function download()
    {
        $user = Auth::user();

        $pdf = Pdf::loadView('cv.pdf-template', compact('user'));

        $fileName = 'CV-' . Str::slug($user->name) . '.pdf';

// Download the PDF
        return $pdf->download($fileName);

    }

}
