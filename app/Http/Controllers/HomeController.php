<?php namespace Forestest\Http\Controllers;

use Forestest\Http\Controllers\Base\BaseController;

class HomeController extends BaseController {

	public function getHome()
	{
		return view('home/home');
	}

}
