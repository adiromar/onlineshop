@extends('theme5.layouts.main')

@section('content')
<div class="p-70s">

    <div class="containers">
        <div class="row p-70s">


            <div class="fancy-breadcumb-area bg-img" style="background-color: #f3f3f3;padding: 75px 0px;min-height: 650px;height: auto;">
                <div class="h-100 bg-img" style="">
                    <div class="container mt-5">
                        <div class="row">

                            {{-- @if (Session::has('success'))
                            <img src="{{ asset('themes/5/cart-check.png') }}" height="" width="">
                            <div class="btn btn-primary alert alert-success alert-dismissible show" role="alert">
                                <strong>{{ Session::get("success") }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif --}}

                            @if (Session::has('info'))
                            <div class="col-md-12 col-sm-12 text-center">
                                <img src="{{ asset('themes/5/cart-check.png') }}" height="200" width="" style="height: 200px;">
                            </div>
                            
                            <div class="col-12 col-md-12 text-center mt-4">
                                <strong>{{ Session::get("info") }}</strong>
                                <p>Continue Shopping <a href="{{ url('/') }}">Here</a></p>
                            </div>

                            @endif


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>







@endsection