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
        // Load relationships to match PDF template data
        $user->load(['profile', 'workExperiences', 'education', 'skills']);

        return view('cv.preview', compact('user'));
    }

    public function download()
    {
        $user = Auth::user();
        // Load all relationships needed for the CV
        $user->load(['profile', 'workExperiences', 'education', 'skills']);

        $pdf = Pdf::loadView('cv.pdf-template', compact('user'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled'  => true,
                'isRemoteEnabled'       => false,
                'defaultFont'           => 'DejaVu Sans',
                'dpi'                   => 96,
                'fontHeightRatio'       => 1.0, // Reduces line height spacing
                'isPhpEnabled'          => true,
                'debugKeepTemp'         => false,
                'debugCss'              => false,
                'debugLayout'           => false,
                'debugLayoutLines'      => false,
                'debugLayoutBlocks'     => false,
                'debugLayoutInline'     => false,
                'debugLayoutPaddingBox' => false,
            ]);

        $fileName = 'CV-' . Str::slug($user->name) . '.pdf';

        // Download the PDF
        return $pdf->download($fileName);
    }
}
