<?php namespace Forestest\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use Forestest\Models\Text;
use Forestest\Models\Question;
use Forestest\Models\ProgramLanguage;

class QuestionsController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$uri = static::getRouter()->getCurrentRoute()->getUri();
		list($controller, $action) = explode('/', $uri);
		app('Illuminate\Contracts\View\Factory')
			->share('pageCss', [
				'/vendor/components/codemirror-5.0/lib/codemirror.css',
				'/vendor/components/highlight-8.4/styles/default.css',
				'/vendor/components/jquery-ui-1.11.3/jquery-ui.min.css',
				'/vendor/components/tagit-2.0/jquery.tagit.css',
				'/components/markdown-editor/markdown-editor.css',
				'/components/markdown-view/markdown-view.css',
			]);
		app('Illuminate\Contracts\View\Factory')
			->share('pageJs', "$controller/$action");
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getSuggest()
	{
		return view('questions/suggest', [
			'programLanguages' => ProgramLanguage::allOrdered()->get(),
			'questionTypes' => Question::getTypes(),
			'activeQuestionType' => Question::TYPE_RADIOS,
		]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function postSuggest(Request $request)
	{
		$question = new Question();
		$question->setType($request->get('questionType'));
		$question->setProgramLanguageId($request->get('programLanguage'));
		$question->setText('ru', $request->get('text'));
		$question->save();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getCategories(Request $request)
	{
		$language = $request->get('language');
		if ('php' === $language) {
			$categories = [
				'LAMP',
				'Apache',
				'Nginx',
				'None',
				'NoSQL',
			];
		} else {
			$categories = [
				'Math',
				'Patterns',
				'Programming',
				'Perl',
				'Other',
			];
		}
		return response()->json($categories);
	}

}
