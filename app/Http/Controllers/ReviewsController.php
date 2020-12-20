<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reviews;
use App\ProductReviews;
use DB;
use Auth;

class ReviewsController extends Controller
{   
    public function index(){
        return view('pages.messages')->with('reviews', Auth::user()->reviews()->get());
    }

}
