@extends('theme5.layouts.main')

@section('content')
    <div class="p-70" style="background: #f2f1f1;">

        <div class="container">
            <div class="row p-70">


                <div class="offset-3 col-lg-6 col-sm-12 offset-3 mb-3">

                    @include('errors.errors')

                    <div class="signup-form" style="border: 2px solid #d3cece;padding: 15px;"><!--sign up form-->
                        <h2 class="text-center">Delivery User Signup!</h2>
                        <hr class="chk_title_bar">
                        <p class="text-center mt-3">Fields marked with * are required</p>

                        <p class="text-center">Sign Up as a Customer! <a href="{{ url('user/register') }}">Follow here</a>  </p>

                        <form method="POST" id="signin-form" class="clearfix mt-5" action="{{ route('register.delivery.user') }}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="fullName" class="form-control mb-4{{ $errors->has('fullName') ? ' is-invalid' : '' }}" value="{{ old('fullName') }}" placeholder="Full Name*" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="phoneNumber" pattern="^[0-9]{10}$" title="Only 10 digits accepted." class="form-control mb-4" value="{{ old('phoneNumber') }}" placeholder="Phone Number*"/ required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="username" class="form-control mb-4 {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}" placeholder="User Name*" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control mb-4 {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Email*" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" name="password" pattern="^(?=(.*[a-zA-Z].*){2,})(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{4,15}$" title="The password must have at least one number, one symbol and one uppercase letter." class="form-control mb-4 {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" placeholder="Password*" required />
                                </div>
                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" class="form-control mb-4 {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" value="{{ old('password_confirmation') }}" placeholder="Confirm Password*" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="streetAddress" class="form-control mb-4" value="{{ old('streetAddress') }}" placeholder="Address*"/ required>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control mb-4" value="{{ old('city') }}" placeholder="City"/>
                                </div>
                                <div class="col-md-6">
                                  <input type="text" name="vehicleNumber" placeholder="Number of your Vehicle*" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <label>Upload your License Copy (image/pdf)*:</label>
                                <input type="file" name="licenceCopy" class="form-control mb-4">
                              </div>
                            </div>
                            <div class="form-group">
                              <button type="submit" class="btn btn-info">Signup</button>
                            </div>

                        </form>

                        <hr class="break_hr">

                        <div class="col-12 text-center">
                        <p>Already Have An Account ?  <a href="{{ route('login.new5') }}">Login Here</a> </p>
                        </div>

                    </div><!--/sign up form-->
                </div>
            </div>
            </div>
        </div>

@endsection
