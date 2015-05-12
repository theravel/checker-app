<?php namespace Forestest\Http\Controllers\Base;

use Auth;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class BaseController extends Controller {

	use DispatchesCommands, ValidatesRequests;

	protected $pageCss = [];

	public function __construct()
	{
		$this->setStaticAssets();
	}

	public function getUser()
	{
		return Auth::user();
	}

	public function hasUser()
	{
		return null !== $this->getUser();
	}

	private function setStaticAssets()
	{
		$uri = static::getRouter()->getCurrentRoute()->getUri();
		$uriComponents = explode('/', $uri);
		$controller = $uriComponents[0];
		if (count($uriComponents) > 1) {
			$action = $uriComponents[1];
		} else {
			$action = 'index';
		}
		view()->share('pageCss', $this->pageCss);
		view()->share('pageJs', "$controller/$action");
	}

}
