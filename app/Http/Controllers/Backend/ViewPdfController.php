<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ViewPdfController extends Controller
{


    //



    public function __invoke()
    {
    }
    public function viewPdf()
    {
        // Get the path to the PDF file in the public directory
        $pdfPath = public_path('Student137_64fe6c87c4b3a.pdf');

        // Return a view with the PDF URL
        return view('Roles.Super_Administrator.studentapplicant.viewform137', compact('pdfPath'));
    }
}
