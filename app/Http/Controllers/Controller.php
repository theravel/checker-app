<?php namespace Forestest\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected $pageCss = [];

	public function __construct()
	{
		$this->setStaticAssets();
	}

	private function setStaticAssets()
	{
		$uri = static::getRouter()->getCurrentRoute()->getUri();
		list($controller, $action) = explode('/', $uri);
		view()->share('pageCss', $this->pageCss);
		view()->share('pageJs', "$controller/$action");
	}

}
