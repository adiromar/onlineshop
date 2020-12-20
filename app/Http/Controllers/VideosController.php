<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Videos;
use Auth;
class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('user.videos.index')->with('videos', Videos::take(6)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            'title' => 'min:6',
            'url' => 'required'

      ]);

      if(preg_match('/https:\/\/(www\.)*youtube\.com\/watch.*/',$request->url)){
        $video = new Videos;
        $video->user_id = Auth::id();
        $video->title = $request->title;
        $video->url =
        preg_replace(
          "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
          "<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
          $request->url
          );
        $video->save();
        session()->flash('success', 'Succesfully Added url, thanks.');
      }else{
        session()->flash('info', 'Please insert correct youtube url. Thanks.');
      }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vid = Videos::find($id);

        $vid->delete();
        session()->flash('success', 'Success');
        return redirect()->back();
    }
}
