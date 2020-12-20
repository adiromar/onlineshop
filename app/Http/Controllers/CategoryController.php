<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Helpers\UserRole;
use Auth;
use Session;
use Image;

class CategoryController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if ( Auth::user()->hasRoles('Admin') ) {
            $categories = Category::orderBy('name')->get();
            return view('categories.index', compact('categories'));
        }
        if ( Auth::user()->hasRoles('Supplier') ) {
            $categories = Category::orderBy('name')->get();
            return view('categories.index', compact('categories'));
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name')->where('parentId', "0")->get();
        if ( Auth::user()->hasRoles(['Admin','Supplier']) ) {
            return view('categories.create', compact('categories'));
        }

        return redirect()->back();
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
                'name' => 'required|unique:categories',
                'image' => 'image'
        ]);

        $fileurl = '';
        if ( $featured = $request->file('image') ) {
            $filename = 'featured-' . str_slug( $request->name ) . '-' . str_random(10) . '.' . $featured->getClientOriginalExtension();

            Image::make($featured)->resize(250,270)->save('uploads/categories/'. $filename);

            $fileurl = 'uploads/categories/' . $filename;

        }
        $bannerurl = '';
        if ( $banner = $request->file('bannerImage') ) {
            $filename2 = 'banner-' . str_slug( $request->name ) . '-' . str_random(10) . '.' . $banner->getClientOriginalExtension();

            Image::make($banner)->resize(1320,450)->save('uploads/categories/banner/'. $filename2);

            $bannerurl = 'uploads/categories/banner/' . $filename2;

        }

        $cat = new Category;

        $cat->name = $request->name;
        $cat->slug = str_slug($request->name);
        $cat->image = $fileurl;
        $cat->banner = $bannerurl;
        if ( $request->parentId ) {
            $cat->parentId = $request->parentId;
        }
        $cat->featured = $request->featured;
        // $cat->theme_no = $request->theme_no;
        $cat->save();

        Session::flash('success', 'Succesfully created a category.');

        return redirect()->route('categories.index');
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
    public function edit(Category $category)
    {
        $categories = Category::orderBy('name')->where('parentId', "0")->get();
        if ( Auth::user()->hasRoles(['Admin','Supplier']) ) {
            return view('categories.edit', compact('categories', 'category'));
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validateWith([
                'name' => 'required',
                'image' => 'image'
        ]);

        $fileurl = $category->image;
        if ( $featured = $request->file('image') ) {
            $filename = 'featured-' . str_slug( $request->name ) . '-' . str_random(10) . '.' . $featured->getClientOriginalExtension();

            try {
                if ( file_exists($category->image) ) {
                    unlink( $category->image );
                }
            } catch (Exception $e) {

            }


            Image::make($featured)->resize(250,270)->save('uploads/categories/'. $filename);

            $fileurl = 'uploads/categories/' . $filename;

        }

        $bannerurl = $category->bannerImage;
        if ( $featured2 = $request->file('bannerImage') ) {
            $filename2 = 'banner-' . str_slug( $request->name ) . '-' . str_random(10) . '.' . $featured2->getClientOriginalExtension();

            try {
                if ( file_exists($category->bannerImage) ) {
                    unlink( $category->bannerImage );
                }
            } catch (Exception $e) {

            }

            Image::make($featured2)->resize(1320,450)->save('uploads/categories/banner/'. $filename2);

            $bannerurl = 'uploads/categories/banner/' . $filename2;
        }


        $category->name = $request->name;
        $category->slug = str_slug($request->name);
        $category->image = $fileurl;
        $category->banner = $bannerurl;
        if ( $request->parentId ) {
            $category->parentId = $request->parentId;
        }else{
            $category->parentId = 0;
        }
        $category->featured = $request->featured;
        // $category->theme_no = $request->theme_no;
        $category->save();

        Session::flash('success', 'Succesfully updated.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        if ( file_exists($category->featured) ) {
            unlink( $category->featured );
        }

        $category->delete();

        Session::flash('success', 'Succesfully removed.');

        return redirect()->back();
    }
}
