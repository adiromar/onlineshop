@extends('theme5.layouts.main')

@section('content')
    <div class="p-70" style="background: #f2f1f1;">

        <div class="container">
            <div class="row p-70">


                <div class="offset-3 col-lg-6 col-sm-12 offset-3 mb-3">

                    @include('errors.errors')

                    <div class="signup-form" style="border: 2px solid #d3cece;padding: 15px;"><!--sign up form-->
                        <h2 class="text-center">New User Signup!</h2>
                        <hr class="chk_title_bar">
                        <p class="text-center mt-3">Fields marked with are required*</p>

                        <p class="text-center">Sign Up as a Delivery User! <a href="{{ url('user/delivery/signup') }}">Follow here</a>  </p>

                        <form method="POST" id="signin-form" class="clearfix mt-5" action="{{ route('register.user') }}" aria-label="{{ __('Register') }}">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="firstName" class="form-control mb-4{{ $errors->has('firstName') ? ' is-invalid' : '' }}" value="{{ old('firstName') }}" placeholder="First Name*" required />
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="middleName" class="form-control mb-4" value="{{ old('middleName') }}" placeholder="Middle Name"/>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="lastName" class="form-control mb-4" value="{{ old('lastName') }}" placeholder="Last Name*" required />
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
                                    <input type="text" name="streetAddress" class="form-control mb-4" value="{{ old('streetAddress') }}" placeholder="Street Address*" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    {{-- previous     ^[0-9]{10}$ --}}
                                    <input type="number" name="phoneNumber" pattern="[9]{1}[0-9]{9}" title="Only 10 digits accepted." class="form-control mb-4" value="{{ old('phoneNumber') }}" placeholder="Phone Number*" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control mb-4" value="{{ old('city') }}" placeholder="City*" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row" style="padding: 20px;">
                                    <div class="col-md-12 col-sm-12 terms">
                                        @component('components.terms')
                                        @endcomponent
                                    </div>
                                </div>
                            </div>

                            <div class="form-group conditions">
                                <label><input type="checkbox" name="terms" required>&nbsp;&nbsp;I accept the above Terms and Conditions</label>
                            </div>

                            <button type="submit" class="btn btn-info">Signup</button>
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
