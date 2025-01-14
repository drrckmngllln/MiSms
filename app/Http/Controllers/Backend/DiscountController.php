<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DiscountDataTable;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Files\Disk;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DiscountDataTable $dataTable)
    {
        //

        return $dataTable->render('Roles.Super_Administrator.discount.index');
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
        $request->validate(Discount::$rules);

        $discount = new Discount([
            ...$request->only([
                'code', 'discount_target', 'description', 'discount_percentage'
            ])
        ]);

        $discount->save();
        $request->session()->flash('success', 'Discount Added Successfully');
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
        // dd($request->all());
        $request->validate(Discount::$rules);
        $discount = Discount::findOrFail($id);
        $discount->update(
            $request->only(['code', 'discount_target', 'description', 'discount_percentage'])
        );
        $discount->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $discount = Discount::findOrFail($id);
        $discount->delete();
        return response(['status' => 'success', 'message', 'Discount Deleted Successfully']);
    }
}
