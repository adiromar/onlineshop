@extends('theme5.layouts.main')

{{-- @yield('modals') --}}


@section('content')
    <div class="p-70" style="background: #f2f1f1;">

        <div class="container">
            <div class="row p-70">


                <div class="offset-lg-3 col-lg-6 col-sm-12 mb-3">

                    @include('errors.errors')

                    <div class="signup-form" style="border: 2px solid #d3cece;padding: 15px;"><!--sign up form-->
                        <h2 class="text-center">New Merchant Signup!</h2>
                        <hr class="chk_title_bar">
                        <p class="text-center mt-3">Fields marked with are required*</p>



                        <form method="POST" id="signin-form" class="clearfix mt-5" action="{{ route('merchant.store') }}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <input type="text" name="firstName" class="form-control mb-4{{ $errors->has('firstName') ? ' is-invalid' : '' }}" value="{{ old('firstName') }}" placeholder="First Name*" required />
                                    <input type="text" name="lastName" class="form-control mb-4" value="{{ old('lastName') }}" placeholder="Last Name*" required />
                                    <input type="password" name="password" pattern="^(?=(.*[a-zA-Z].*){2,})(?=.*\d.*)(?=.*\W.*)[a-zA-Z0-9\S]{4,15}$" title="The password must have at least one number, one symbol and one uppercase letter." class="form-control mb-4 {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" placeholder="Password*" required />
                                    <input type="email" name="email" class="form-control mb-4 {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Email*" required />
                                    <input type="text" name="city" class="form-control mb-4" value="{{ old('city') }}" placeholder="City"/>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="text" name="middleName" class="form-control mb-4" value="{{ old('middleName') }}" placeholder="Middle Name"/>
                                    <input type="text" name="username" class="form-control mb-4 {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}" placeholder="User Name*" required />
                                    <input type="password" name="password_confirmation" class="form-control mb-4 {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" value="" placeholder="Confirm Password*" required/>
                                    <input type="text" name="streetAddress" class="form-control mb-4" value="{{ old('streetAddress') }}" placeholder="Address*"/ required>
                                    <input type="text" name="phoneNumber" class="form-control mb-4" pattern="^[0-9]{10}$" title="Only 10 digits accepted." value="{{ old('phoneNumber') }}" placeholder="Phone Number*"/ required>
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

                            <div class="form-group">
                                <label><input type="checkbox" name="is_merchant" value="1" id="is_merchant">&nbsp; I am a Wholeseller</label>
                                <small>( Check this only if you are the whole-seller personnel. )</small>
                            </div>

                            <div class="docs" style="display: none;">
                                <div class="form-group">
                                <!-- VAT/PAN -->
                                    <label>PAN Card:</label>
                                    <input type="file" name="panCard" class="form-control">
                                </div>
                                <div class="form group">
                                    <label for=""><strong>OR</strong></label>
                                </div>
                                <div class="form-group">
                                    <label for="VAT">VAT Registration Certificate:</label>
                                    <input type="file" name="vatRegistration" class="form-control">
                                </div>
                            </div>

                            <div class="form-group conditions">
                                <label><input type="checkbox" name="terms" required>&nbsp;&nbsp;I accept the above Terms and Conditions</label>
                            </div>

                            {{-- <div class="form-group conditions"> --}}
                                {{-- <label> --}}
                                    <input type="hidden" name="supplier" value="1" checked>
                                    {{-- &nbsp;I am a Whole Seller --}}
                                {{-- </label> --}}
                                {{-- <small>Check this only if you are the whole-seller personnel.</small> --}}
                            {{-- </div> --}}

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

@section('scripts')

    <script>
        $('#is_merchant').change(function(){

            if ( $(this).is(':checked') ) {

                $('.docs').fadeIn();

            }else{

                $('.docs').fadeOut();

            }

        });

        @if (Session::has('info'))
        Swal.fire({
            text: '{{ Session::get("info") }}',
            icon: 'info',
            confirmButtonText: 'Ok'
        })
        @endif
    </script>

@endsection
