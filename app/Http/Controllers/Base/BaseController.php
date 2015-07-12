<?php namespace Forestest\Http\Controllers\Base;

use Auth;
use Session;

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

	protected function getUser()
	{
		return Auth::user();
	}

	protected function hasUser()
	{
		return null !== $this->getUser();
	}

	protected function setFlashMessage($flashMessageKey)
	{
		Session::flash("flash.$flashMessageKey", true);
	}

	protected function setJsPath($path)
	{
		view()->share('pageJs', $path);
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
		$this->setJsPath("$controller/$action");
	}

}
