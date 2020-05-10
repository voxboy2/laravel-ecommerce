@extends('layouts.frontLayout.front_design')

@section('content')

<section id="form" style="margin-top:20px"><!--form-->
		<div class="container">
			<div class="row">
                @include('flash_message')
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form id="loginForm" name="loginForm" action="{{ route('user_login') }}" method="post">

						@csrf
							<input id="email" name="email" type="email" placeholder="Email Address" required="" />
							<input id="password" name="password" type="password" placeholder="Password" required="" />
							<!-- <span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span> -->
							<button type="submit" class="btn btn-default">Login</button><br>
                            <a href = "{{ url('forgot-password') }}">Forgot Password?</a>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form id="registerForm" name="registerForm" action="{{ route('user_register') }}" method="post">
                            @csrf
							<input id="name" name="name" type="text" placeholder="First Name"/>
							<input id="email" name="email" type="email" placeholder="Email Address"/>
							<input id="myPassword" name="password" type="password" placeholder="Password"/>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->








@endsection