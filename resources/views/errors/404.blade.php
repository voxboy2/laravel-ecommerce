@extends('layouts.frontLayout.front_design')

@section('content')

<div class="container text center">
<div class="content-404">


<h1><b>OOPS!</b>We could'nt find this page<h1>
<p>uh... So it looks like you broke something.The page you are looking for does not exits
</p>

<h2><a href="{{ asset('./') }}">Bring me back home</a></h2>

<br>

</div>

</div>










@endsection
