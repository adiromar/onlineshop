@extends('theme5.layouts.main')

{{-- @yield('modals') --}}


@section('content')
    <div class="p-70" style="background: #f2f1f1;">

        <div class="container">
            <div class="row p-70">
                

                <div class="offset-lg-3 col-lg-6 col-sm-12 mb-3">

                    @include('errors.errors')
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="signup-form" style="border: 2px solid #d3cece;padding: 15px;"><!--sign up form-->
                        <h2 class="text-center">Reset Your Password</h2>
                        <hr class="chk_title_bar">
                        {{-- <small>Fields marked with are required*</small> --}}
                        <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}" class="p-4">
                            {{ csrf_field() }}
        
                            <div class="row mb-3">
                                <div class="col-md-12 col-sm-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail Address" required>
                                </div>
                            </div>
        
                            <button type="submit" class="btn btn-info">Reset</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
            </div>
        </div>
        
@endsection