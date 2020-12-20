<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::latest()->get();
        
        return view('brands.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $this->validateWith([
            'name' => 'required',
            'status' => 'required'
    ]);

    $brand = new Brand;

    $brand->brandName = $request->name;
    $brand->slug = str_slug($request->name);
    $brand->status = $request->status;

    // $cat->theme_no = $request->theme_no;
    $brand->save();

    Session::flash('success', 'Succesfully created a Brand.');
    return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::where('brandId', $id)->first();

        // dd($brand);
        return view('brands.edit')->with('brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateWith([
            'name' => 'required',
            'status' => 'required'
        ]);

        $brand = Brand::where('brandId', $id)
                        ->update(['brandName'=> $request->name, 'slug' => str_slug($request->name), 'status'=> $request->status]);

        $brands = Brand::latest()->get();

        Session::flash('success', 'Succesfully Updated a Brand.');
        return view('brands.index')->with('brands', $brands);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::where('brandId', $id);
        $brand->delete();

        Session::flash('success', 'Succesfully removed.');

        return redirect()->back();
    }
}
