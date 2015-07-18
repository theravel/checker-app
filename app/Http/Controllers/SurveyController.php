<?php namespace Forestest\Http\Controllers;

use Forestest\Http\Controllers\Base\BaseController;

class SurveyController extends BaseController {

	public function getAnswer()
	{
		return view('survey/answer');
	}

}
