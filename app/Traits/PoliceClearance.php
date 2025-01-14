<?php

namespace App\Traits;

use Illuminate\Http\Request;

use File;

trait PoliceClearance
{


    //add method
    //nag lagay lang ako ng variable $inputName tas variable $path
    public function uploadPoliceClearance(Request $request, $inputName, $path)
    {

        if ($request->hasFile($inputName)) {


            $image = $request->{$inputName};
            //create a new name and attached nalang yung extension para hindi ito mahaba sa database
            //gagamit tayu ng extension
            $ext = $image->getClientOriginalExtension();

            //instead na gamitin natin yung rand function gagamit tayu ng uniqid() function
            //unique name every time when the user upload the image
            $imageName = 'StudentPoliceClearance_' . uniqid() . '.' . $ext;
            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }
    public function deletePoliceClearance(string $path)
    {
        //para pag nag delete tayu pati yung image samay storage matatanggal
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
