<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\TestingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Testing;
use Illuminate\Http\Request;
use File;
use App\Traits\ImageUploadTrait as ImageUploadTraitAlias;



class TestController extends Controller
{
    use ImageUploadTraitAlias;
    /**
     * Display a listing of the resource.
     */
    public function index(TestingDataTable $dataTable)
    {
        //
        return $dataTable->render('Roles.Super_Administrator.testing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
            'banner' => ['required', 'image', 'max:5000'],
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'starting_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        // Create a new Testing model instance and populate its attributes
        $testingData = $request->only([
            'banner', 'type', 'title', 'starting_price', 'btn_url', 'serial', 'status',
        ]);

        $testing = new Testing($testingData);

        // Upload the banner image
        $testing->banner = $this->uploadImage($request, 'banner', 'sliderpicture');
        $testing->save();
        $request->session()->flash('success', 'User data successfully saved!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $curriculum = Testing::findOrfail($id);

        $curriculum->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
}
