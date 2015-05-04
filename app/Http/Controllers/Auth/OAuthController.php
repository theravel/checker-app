<?php namespace Forestest\Http\Controllers\Auth;

use Auth;
use OAuth;

use Forestest\Http\Controllers\Controller;

class OAuthController extends Controller {

	public function getAuth($provider)
	{
		return OAuth::authorize('github');
	}

	public function getLogin($provider)
	{
		OAuth::login($provider, function(&$user, $details) {
			$user->name = '';
			$user->email = '';
			$user->password = '';
		});

		// Current user is now available via Auth facade
		$user = Auth::user();
		//return Redirect::intended();
	}

}
