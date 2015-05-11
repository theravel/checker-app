<?php namespace Forestest\Http\Controllers\Auth;

use OAuth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Forestest\Models\User;
use Forestest\Http\Controllers\Controller;

class AuthController extends Controller {

	// #19 this functionality is temporary disabled
	// use AuthenticatesAndRegistersUsers;

	/**
	 * @var \Illuminate\Contracts\Auth\Guard
	 */
	private $auth;

	/**
	 * @var \Illuminate\Contracts\Auth\Registrar
	 */
	private $registrar;

	/**
	 * @param \Illuminate\Contracts\Auth\Guard $auth
	 * @param \Illuminate\Contracts\Auth\Registrar $registrar
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		parent::__construct();
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function getOauthRedirect($provider)
	{
		return OAuth::authorize($provider);
	}

	public function getLogin()
	{
		return view('auth/login');
	}

	public function getOauthLogin($provider)
	{
		OAuth::login($provider, function(User &$user, $details) {
			try {
				/**
				 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
				 */
				$user = User::where('email', '=', $details->email)->firstOrFail();
			} finally {
				$user->setName($details->nickname);
				$user->setEmail($details->email);
				$user->setImageUrl($details->imageUrl);
			}
		});
		return redirect('/');
	}

	public function getLogout()
	{
		$this->auth->logout();
		return redirect('/');
	}

}
