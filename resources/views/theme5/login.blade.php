@extends('theme5.layouts.main')

{{-- @yield('modals') --}}


@section('content')
    <div class="p-70" style="background: #f2f1f1;">

        <div class="container">
            <div class="row p-70">


                <div class="offset-lg-3 col-lg-6 col-sm-12 mb-3">

                    @include('errors.errors')

                    <div class="signup-form" style="border: 2px solid #d3cece;padding: 15px;"><!--sign up form-->
                        <h2 class="text-center">User Login</h2>
                        <hr class="chk_title_bar">
                        {{-- <small>Fields marked with are required*</small> --}}
                        <form method="POST" id="checkout-form" class="clearfix p-4" action="{{ route('login.custom') }}" aria-label="{{ __('Login') }}">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <label for="">Username/Email: <span>*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username or Email" />
                                </div>
                                <div class="col-md-12 col-sm-12 mt-3">
                                    <label for="pwd">
                                        Password <span>*</span>
                                        <input id="show-pwd" style="margin-left: 2rem" type="checkbox" name="show_password">&nbsp; Show password
                                    </label>
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" />
                                </div>
                                <div class="col-md-12 col-12 mt-3">
                                    <span>
                                        <input type="checkbox" class="checkbox">
                                        Keep me signed in
                                    </span>
                                </div>

                                <div class="col-md-12 col-12">
                                    <p class="text-right">
                                        <a href="{{ route('resetpass.new5') }}">Forget Password?</a>
                                    </p>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-info">Login</button>
                        </form>

                        <hr class="break_hr">
                        <div class="col-md-12">
                            <a href="{{ route('facebook.login') }}"><button class="review-btn btn btn-primary">Login with FACEBOOK</button></a>

                            <a href="{{ route('facebook.google') }}"><button class="review-btn btn btn-danger">Login with Google</button></a>
                        </div>
                        <div class="col-12">
                        <p>Not yet a User ?  <a href="{{ route('register.new5') }}">Register Here</a> </p>
                        </div>
                    </div><!--/sign up form-->
                </div>
            </div>
            </div>
        </div>

@endsection

@section('scripts')
<script>
    $('#show-pwd').change(function(){

        let checked = $(this).prop('checked');
        if ( checked ) {
            $('input[name=password]').prop({type:"text"});
        }else{
            $('input[name=password]').prop({type:"password"});
        }

    });
</script>
@endsection
