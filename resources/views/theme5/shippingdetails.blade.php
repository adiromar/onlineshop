@extends('theme5.layouts.main')

@section("styles")

<style media="screen">
    .p-70 { background-color: whitesmoke; }
    .order-wrapper { background-color: white;padding: 2rem 2rem;border-radius: 12px; margin-top: 1rem; }
    tfoot { border-bottom: 1 px solid rgb(168, 168, 228); }
    .btn-edit { color: maroon; }
    .form_cont { display: block; width: 100%;padding-left: 10px; }
    .btn:hover { cursor: pointer; }
    .add-detail-btn { color: #1d4f82; border: 2px solid #232d37; padding: 4px 8px; font-weight: 600; border-radius: 3px; font-size: 13px;}
    #default { padding: 5px;    height: 44px;    width: 44px; }
    #default:hover{ cursor: pointer; }
</style>

@endsection

@section('content')
<div class="p-70">
    <div class="container pt-4 pb-4">
      <div class="row">
        <div class="col-md-12 main-title">
          <h2>My Shipping Details</h2>
          <small>Manage all your Shipping Details.</small>
        </div>
      </div>
      @include('errors.errors')
      @if( isset($toedit) )
      <section class="order-wrapper table-responsive">
        <div class="row">
          <div class="col-md-12">
          <form action="{{ route('update.shipping.detail') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="fullnm">Full Name*:</label>
                  <input type="text" name="fullName" class="form_cont" value="{{ $details->client_name }}">
                </div>
                <div class="col-md-2">
                  <label for="">Make Default:</label><br>
                  <input type="checkbox" id="default" name="makeDefault" value="1">
                </div>
                <div class="col-md-4">
                  <label for="ph">Phone No*:</label>
                  <input type="text" name="phoneNo" class="form_cont" value="{{ $details->phone }}">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="add">Shipping Address*:</label>
                  <input type="text" name="shippingAddress" class="form_cont" value="{{ $details->address }}">
                </div>
                <div class="col-md-6">
                  <label for="alias">Alias (nearby place)*:</label>
                  <input type="text" name="alias" class="form_cont" value="{{ $details->near_by_places }}">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <label for="province">State/Province*:</label>
                  <select name="state" id="state" class="form_cont">
                    <option value="">Select Province</option>
                    <option value="1" {{ $details->state == 1 ? 'selected' : '' }}>Province 1</option>
                    <option value="2" {{ $details->state == 2 ? 'selected' : '' }}>Province 2</option>
                    <option value="3" {{ $details->state == 3 ? 'selected' : '' }}>Bagmati Province</option>
                    <option value="4" {{ $details->state == 4 ? 'selected' : '' }}>Gandaki</option>
                    <option value="5" {{ $details->state == 5 ? 'selected' : '' }}>Province 5</option>
                    <option value="6" {{ $details->state == 6 ? 'selected' : '' }}>Karnali</option>
                    <option value="7" {{ $details->state == 7 ? 'selected' : '' }}>Sudurpaschim</option>
                </select>
                </div>
                <div class="col-md-2">
                  <label for="city">City*:</label>
                  <input type="text" name="city" class="form_cont" value="{{ $details->city }}">
                </div>
                <div class="col-md-3">
                  <label for="alt">Alternate Phone No.</label>
                  <input type="text" name="phoneNumber" class="form_cont" value="{{ $details->alternatePhone }}">
                </div>
                <div class="col-md-2">
                  <label for="zip">Zip Code:</label>
                  <input type="number" name="zipCode" class="form_cont" value="{{ $details->zipcode }}">
                  <input type="hidden" name="shippingId" value="{{ $details->shipping_details_id }}">
                  <input type="hidden" name="email" class="form_cont" value="{{ $details->email }}">
                </div>
                <div class="col-md-2">
                  <label for=".">&nbsp;</label>
                  <input type="submit" name="update" value="Update" class="btn btn-block btn-info btn-lg">
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
      @endif

      @if( isset(request()->toadd) )
      <section class="order-wrapper table-responsive">
        <div class="row">
          <div class="col-md-12">
            <form action="{{ route('update.shipping.detail') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group row">
                <div class="col-md-4">
                  <label for="fullnm">Full Name*:</label>
                  <input type="text" name="fullName" class="form_cont">
                </div>
                <div class="col-md-4">
                  <label for="email">Email*:</label>
                  <input type="email" name="email" class="form_cont">
                </div>
                <div class="col-md-4">
                  <label for="ph">Phone No*:</label>
                  <input type="text" name="phoneNo" class="form_cont">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="add">Shipping Address*:</label>
                  <input type="text" name="shippingAddress" class="form_cont">
                </div>
                <div class="col-md-6">
                  <label for="alias">Alias (nearby place)*:</label>
                  <input type="text" name="alias" class="form_cont">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <label for="province">State/Province:</label>
                  <select name="state" id="state" class="form_cont">
                    <option value="">Select Province</option>
                    <option value="1">Province 1</option>
                    <option value="2">Province 2</option>
                    <option value="3">Bagmati Province</option>
                    <option value="4">Gandaki</option>
                    <option value="5">Province 5</option>
                    <option value="6">Karnali</option>
                    <option value="7">Sudurpaschim</option>
                </select>
                </div>
                <div class="col-md-2">
                  <label for="city">City*:</label>
                  <input type="text" name="city" class="form_cont">
                </div>
                <div class="col-md-3">
                  <label for="alt">Alternate Phone No.</label>
                  <input type="text" name="phoneNumber" class="form_cont">
                </div>
                <div class="col-md-2">
                  <label for="zip">Zip Code:</label>
                  <input type="number" name="zipCode" class="form_cont">
                </div>
                <div class="col-md-2">
                  <label for=".">&nbsp;</label>
                  <input type="submit" name="update" value="Add" class="btn btn-block btn-info btn-lg">
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>
      @endif


      <section class="order-wrapper table-responsive">

        <table class="table table-striped table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Address</th>
              <th>Alias</th>
              <th>City</th>
              <th>Phone</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          @if( count($shippingdetails) > 0 )
          @foreach ($shippingdetails as $detail)
            <tr>
              <td> {{ $detail->client_name }} </td>
              <td> {{ $detail->email }} </td>
              <td> {{ $detail->address }} </td>
              <td> {{ $detail->near_by_places }} </td>
              <td> {{ $detail->city }} </td>
              <td> {{ $detail->phone }} </td>
              <td> {{ $detail->active == 1 ? 'Default' : 'Inactive' }} </td>
              <td>
              <a href="{{ route('user.shipping.edit', $detail->shipping_details_id ) }}" class="btn-edit">Edit</a>
              </td>
            </tr>
          @endforeach
          @else
            <tr>
              <td colspan="8">Not previously saved.</td>
            </tr>
          @endif
          </tbody>
          @if ( count($shippingdetails) < 3 )
          <tfoot>
            <tr>
            <td colspan="8"><a href="{{ route('user.shipping.details', Auth::id()) }}?toadd=first" class="add-detail-btn">+ Add New Detail</a></td>
            </tr>
          </tfoot>
          @endif
        </table>

      </section>
    </div>
</div>
@endsection
