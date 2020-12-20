<?php

namespace App\Http\Controllers;

use App\ThemesList;
use Session;
use Image;
use Auth;
use Illuminate\Http\Request;
use DB;

class ThemesListController extends Controller
{
    public function index()
    {
        $themesList = ThemesList::latest()->get();
        return view('themesList.index', compact('themesList'));
    }

    public function create()
    {
        
        return view('themesList.create');
    }

    public function store(Request $request)
    {

        $this->validateWith([
            'themeName' => 'required',
            'themeNumber' => 'required|unique:themesList',
            'themeImage' => 'required|image'
        ]);

        $file = $request->file('themeImage');
        if ( $file ) {
            $filename = 'th_list-' . str_slug( $request->theme_name ) . '-' . str_random(10) . '.' . $file->getClientOriginalExtension();

            Image::make($file)->resize(600, 450)->save('uploads/themesList/resized/'. $filename);
            Image::make($file)->save('uploads/themesList/' . $filename);
        }

        $themesList = new ThemesList;

        $themesList->themeName = $request->themeName;
        $themesList->themeNumber = $request->themeNumber;
        $themesList->themeImage = $filename;
        $themesList->display = 1;

        $themesList->save();

        Session::flash('success', 'Succesfully added a slider.');

        return redirect()->back();

    }

    public function destroy($themeId)
    {
        $list = ThemesList::find($themeId);
        if($list){
            // $destroy = ThemesList::destroy($themeId);
            $destroy = ThemesList::Where('themeId','=',$list->themeId)->delete();

        }

        session()->flash('success', 'Succesfully removed the Themes List.');

        return redirect()->back();
    }
}
