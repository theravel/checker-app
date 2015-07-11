@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			@if (Session::has('flash.oauthSuccess') && !Auth::guest())
				<div class="alert alert-success">
					Welcome, {{ Auth::user()->name }}!
				</div>
			@endif
			@if (Session::has('flash.oauthError'))
				<div class="alert alert-danger">
					Login failed
				</div>
			@endif
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					Main page here
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
