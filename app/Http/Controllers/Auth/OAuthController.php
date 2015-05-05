<?php namespace Forestest\Http\Controllers\Auth;

use Auth;
use OAuth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Forestest\User;
use Forestest\Http\Controllers\Controller;

class OAuthController extends Controller {

	public function getAuth($provider)
	{
		return OAuth::authorize($provider);
	}

	public function getLogin($provider)
	{
		OAuth::login($provider, function(User &$user, $details) {
			try {
				$user = User::where('email', '=', $details->email)->firstOrFail();
			} catch (ModelNotFoundException $e) {
				$user->name = $details->nickname;
				$user->email = $details->email;
				$user->image_url = $details->imageUrl;
			}
		});
		// $user = Auth::user();
		// @TODO redirect
	}

}
