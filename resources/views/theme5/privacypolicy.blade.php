@extends('theme5.layouts.main')


@section('content')


<div class="p-70" style="background: #f2f1f1;">

    <div class="container" style="min-height: 400px;">
        <div class="row p-70">
            <div class="col-12">
                <h2 class="text-center">Privacy Policy</h2>
                <hr class="chk_title_bar">
            </div>
			<div class="col-12 pt-4">
	
				{!! App\Setting::first() ? App\Setting::first()->privacyPolicy : '' !!}

			</div>
		</div>
	</div>
</div>


@endsection