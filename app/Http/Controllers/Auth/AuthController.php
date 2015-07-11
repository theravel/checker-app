<?php namespace Forestest\Http\Controllers\Auth;

use Log;
use OAuth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Forestest\Models\User;
use Forestest\Http\Controllers\Base\BaseController;

class AuthController extends BaseController {

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
		try {
			$this->performOauthLogin($provider);
			$this->setFlashMessage('oauthSuccess');
		} catch (\Exception $e) {
			$this->setFlashMessage('oauthError');
			Log::error('Cannot perform OAuth login', ['ex' => $e]);
		}
		return redirect('/');
	}

	public function getLogout()
	{
		$this->auth->logout();
		return redirect('/');
	}

	private function performOauthLogin($provider)
	{
		OAuth::login($provider, function(User &$user, $details) {
			try {
				$user = User::where('email', '=', $details->email)->firstOrFail();
			} catch (ModelNotFoundException $e) {
				// user does not exists, nothing to merge, just move on
			} finally {
				$user->setName($details->nickname);
				$user->setEmail($details->email);
				$user->setImageUrl($details->imageUrl);
			}
		});
	}

}
