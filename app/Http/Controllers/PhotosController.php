<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photos;
use Auth;

class PhotosController extends Controller
{
    public function index(){
    	$photos = Photos::where('user_id', Auth::id())->get();
    	return view('user.photos.index')->with('photos', $photos);
    }

    public function create(){
    	return view('user.photos.create');
    }

    public function store(Request $request){

    	$this->validateWith([
    		'image' => 'required|image|max:4999',
    	]);


    	$file = $request->file('image');
    	$filename = time() . $file->getSize().'.'.$file->getClientOriginalExtension();
    	$uid = Auth::id();
    	$file->move('uploads/photos/'.$uid , $filename);

    	$photo = new Photos;

    	$photo->user_id = $uid;
    	$photo->title = $request->title;
    	$photo->image = 'uploads/photos/'.$uid.'/'.$filename;

    	$photo->save();

    	return redirect()->route('photos.index');


    }

    public function destroy($id){
    	
    	$photo = Photos::find($id);
    	
    	unlink($photo->image);

    	$photo->delete();
    }
}
