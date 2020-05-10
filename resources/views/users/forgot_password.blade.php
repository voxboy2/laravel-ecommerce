@extends('layouts.frontLayout.front_design')

@section('content')

<section id="form" style="margin-top:20px"><!--form-->
		<div class="container">
			<div class="row">
                @include('flash_message')
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form id="forgotPasswordForm" name="forgotPasswordForm" action="{{ ('forgot-password') }}" method="post">

						@csrf
							<input id="email" name="email" type="email" placeholder="Email Address" required=""/>
						
							<button type="submit" class="btn btn-default">Submit</button>
						</form>
					</div><!--/login form-->
				</div>
			</div>
		</div>
	</section><!--/form-->








@endsection