@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="login-social">
				<p>Sign in using any of the following services:</p>
				<ul>
					<li>
						<a href="/auth/oauth-redirect/facebook">
							<span class="fa fa-facebook"></span>
							<span class="social-title">Facebook</span>
						</a>
					</li>
					<li>
						<a href="/auth/oauth-redirect/google">
							<span class="fa fa-google"></span>
							<span class="social-title">Google</span>
						</a>
					</li>
					<li>
						<a href="/auth/oauth-redirect/github">
							<span class="fa fa-github"></span>
							<span class="social-title">Github</span>
						</a>
					</li>
					<li>
						<a href="/auth/oauth-redirect/vk">
							<span class="fa fa-vk"></span>
							<span class="social-title">Vkontakte</span>
						</a>
					</li>
				</ul>
			</div>

			{{-- @include('auth/login_form') --}}
		</div>
	</div>
</div>
@endsection
