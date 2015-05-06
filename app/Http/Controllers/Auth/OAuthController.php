<?php namespace Forestest\Http\Controllers\Auth;

use Auth;
use OAuth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Forestest\Models\User;
use Forestest\Http\Controllers\Controller;

class OAuthController extends Controller {

	/**
	 * @var \Illuminate\Contracts\Auth\Guard
	 */
	private $auth;

	/**
	 * @param  \Illuminate\Contracts\Auth\Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		parent::__construct();
		$this->auth = $auth;
	}

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
				$user->setName($details->nickname);
				$user->setEmail($details->email);
				$user->setImageUrl($details->imageUrl);
			}
		});
		// $user = Auth::user();
		// @TODO redirect
	}

	public function getLogout()
	{
		$this->auth->logout();
		return redirect('/');
	}

}
