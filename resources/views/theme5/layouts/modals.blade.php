
<!-- Modal -->
<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sign In Chaiyo.shop</h5>
          {{-- <hr class="chk_title_bar"> --}}

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="checkout-form" class="clearfix" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                {{csrf_field()}}
                <div class="row">
                <div class="col-lg-12 col-12">
                    <label for=""><b>Email </b><span>*</span></label>
                    <div class="input-group-modal">
                        <span class="input-group-addon" style="padding: 5px 0;">
                            <div>
                                <span class="add-on-set">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </span>
                        <input type="email" name="email" class="form-control" placeholer="Enter Email">
                    </div>
                </div>

                <div class="col-lg-12 col-12 mt-3">
                    <label for=""><b>Password </b><span>*</span></label>
                    <div class="input-group-modal">
                        <span class="input-group-addon" style="padding: 5px 5px;">
                            <div>
                                <span class="add-on-set">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </span>
                        <input type="password" name="password" class="form-control" placeholer="Enter Password">
                    </div>                    
                </div>

              </div>

              <div class="row ml-1 mr-3 mt-3">
                {{-- <div class="mt-3 float-right"> --}}
                  <button type="submit" name="login"  class="btn btn-secondary float-right">Sign In</button>
                {{-- </div> --}}
              </div>
              

              <div class="mt-4" style="border-top: 2px dashed #bcbcbc;">
                <div class="row">
                  <div class="col-lg-6 col-sm-12">
                  <span>Not Signed in Yet?<a href="{{ url('user/register') }}">Register</a></span>
                  </div>
                  <div class="col-lg-6 col-sm-12">
                    <span class="float-right">Forgot Password</span>
                  </div>
                </div>
              </div>

          </form>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
          {{-- <button type="submit" name="login"  class="btn btn-primary">Sign In</button> --}}
        </div>
      </div>
    </div>
  </div>
<!-- modal ends -->
