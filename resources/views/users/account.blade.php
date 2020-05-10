@extends('layouts.frontLayout.front_design')

@section('content')

<section id="form" style="margin-top:20px"><!--form-->
		<div class="container">
			<div class="row">
                @include('flash_message')
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Update Account</h2>
                        <form id="accountForm" name="accountForm" action="{{ route('account') }}" method="post">
                            @csrf
							<input value="{{ $userDetails->name }}" id="name" name="name" type="text" placeholder="Enter First Name"/>
							<input value="{{ $userDetails->address }}" id="address" name="address" type="text" placeholder="address Address"/>
							<input value="{{ $userDetails->city }}" id="city" name="city" type="text" placeholder="city"/>
                            <input value="{{ $userDetails->state }}" id="state" name="state" type="text" placeholder="state"/>
                            <select id="country" name="country">
                              <option value="">Select Country</option>
                              @foreach($countries as $country)
                                 <option value="{{ $country->country_name }}" @if($country->country_name == $userDetails->country)
                                 selected @endif>
                                 {{ $country->country_name }}</option>                                
                              @endforeach
                            </select>
                            <input style="margin-top: 10px;" value="{{ $userDetails->postal_code }}" id="postal_code" name="postal_code" type="text" placeholder="postalcode"/>
                            <input value="{{ $userDetails->mobile }}" id="mobile" name="mobile" type="text" placeholder="mobile"/>

							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Update Password</h2> 
                        <form id="passwordForm" name="passwordForm" action="{{ url('/update-user-pwd') }}" method="POST">
                        @csrf
						<input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password">
						<span id="chkPwd"></span>
                        <input type="password" name="new_pwd" id="new_pwd" placeholder="New Password">
                        <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">
                         <button type="submit" class="btn btn-default">Update</button>

					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->








@endsection