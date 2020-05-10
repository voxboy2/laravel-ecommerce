@extends('layouts.frontLayout.front_design')
@section('content')

<?php use App\Order; ?>

<section id="cart_items">

		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{ route('home') }}">Home</a></li>
				  <li class="active">Thanks</li>
				</ol>
			</div>
		</div>
	</section> 

	<section id="do_action">
		<div class="container">
			<div class="heading" align="center">
				<h3>YOUR ORDER HAS BEEN PLACED</h3>
				<p>Your order number is {{ session::get('order_id') }} and total payable about is {{ session::get('grand_total') }} </p>

                <P>Please make payment by clicking Payment method</p>
                <?php 
                $orderDetails = Order::getOrderDetails(Session::get('order_id'));


                ?>
                <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-md-8 col-md-offset-2">
            <p>
                
            </p>
            <input type="hidden" name="email" value="efewebdev@gmail.com"> {{-- required --}}
            <input type="hidden" name="orderID" value="{{ Session::get('grand_total') }}">
            <input type="hidden" name="amount" value="{{ Session::get('order_id') }}"> {{-- required in kobo --}}
            <input type="hidden" name="name" value="{{ $orderDetails->name }}">
            <input type="hidden" name="address" value="{{ $orderDetails->address }}">
            <input type="hidden" name="city" value="{{ $orderDetails->city }}">
            <input type="hidden" name="state" value="{{ $orderDetails->state }}">
            <input type="hidden" name="country" value="{{ $orderDetails->country }}">
            <input type="hidden" name="mobile" value="{{ $orderDetails->mobile }}">
            <input type="hidden" name="pincode" value="{{ $orderDetails->pincode }}">
            <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
            <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
            {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

             <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}


            <p>
              <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>
            </p>
          </div>
        </div>
</form>

			</div>
		</div>
	</section>

@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>