@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin-top:20px;"><!--form-->
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="#">Home</a></li>
			  <li class="active">Check Out</li>
			</ol>
		</div>
	
		<form action="{{ url('/checkout') }}" method="post">{{ csrf_field() }}
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->zzz
						<h2>Bill To</h2>
							<div class="form-group">
								<input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif type="text" placeholder="Your First Name" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_address" id="billing_address" @if(!empty($userDetails->address)) value="{{ $userDetails->address }}" @endif type="text" placeholder="Billing Address" class="form-control" />
							</div>
							<div class="form-group">	
								<input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif type="text" placeholder="Billing City" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif type="text" placeholder="Billing State" class="form-control" />
							</div>
							<div class="form-group">
								<select id="billing_country" name="billing_country" class="form-control">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif>{{ $country->country_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->postal_code)) value="{{ $userDetails->postal_code }}" @endif type="text" placeholder="Billing postal_code" class="form-control" />
							</div>
							<div class="form-group">
								<input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif type="text" placeholder="Billing Mobile" class="form-control" />
							</div>
							<div class="form-check">
							    <input type="checkbox" class="form-check-input" id="copyAddress">
							    <label class="form-check-label" for="copyAddress">Shipping Address same as Billing Address</label>
							</div>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Ship To</h2>
							<div class="form-group">
								<input name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif type="text" placeholder="Shipping First Name" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif type="text" placeholder="Shipping Address" class="form-control" />
							</div>
							<div class="form-group">	
								<input name="shipping_city" id="shipping_city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif type="text" placeholder="Shipping City" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_state" id="shipping_state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif type="text" placeholder="Shipping State" class="form-control" />
							</div>
							<div class="form-group">
								<select id="shipping_country" name="shipping_country" class="form-control">
									<option value="">Select Country</option>
									@foreach($countries as $country)
										<option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>{{ $country->country_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input name="shipping_postalcode" id="shipping_postalcode" @if(!empty($shippingDetails->postal_code)) value="{{ $shippingDetails->postal_code }}" @endif type="text" placeholder="Shipping Postal_code" class="form-control" />
							</div>
							<div class="form-group">
								<input name="shipping_mobile" id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif type="text" placeholder="Shipping Mobile" class="form-control" />
							</div>
							<button type="submit" class="btn btn-warning">Check Out</button>
					</div><!--/sign up form-->
				</div>
			</div>
		</form>
	</div>
</section><!--/form-->

@endsection