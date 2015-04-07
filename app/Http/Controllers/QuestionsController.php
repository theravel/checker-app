<?php namespace Forestest\Http\Controllers;

use Illuminate\Http\Request;
use Input;

use Forestest\Models\Answer;
use Forestest\Models\Question;
use Forestest\Models\Category;
use Forestest\Models\Translation;
use Forestest\Models\ProgramLanguage;
use Forestest\Repositories\Categories;
use Forestest\Exceptions\ValidationException;

class QuestionsController extends Controller {

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

	public function getSuggest()
	{
		return view('questions/suggest', [
			'programLanguages' => ProgramLanguage::allOrdered()->get(),
			'questionTypes' => Question::getTypes(),
			'activeQuestionType' => Question::TYPE_RADIOS,
		]);
	}

	public function postSuggest(Request $request)
	{
		$question = new Question();
		$question->setType($request->get('questionType'));
		$question->setProgramLanguageId($request->get('programLanguage'));
		$question->setTranslation(Translation::LANGUAGE_DEFAULT, $request->get('text'));
		$question->saveWithAnswers($this->getAnswerModels($question));
		$this->attachCategories($question);
	}

	public function getCategories(Request $request)
	{
		// @TODO later return categories related to selected language
		$language = $request->get('language');
		$categories = iterator_to_array(Category::all());
		$categoryNames = array_map(function(Category $category) {
			return $category->getName();
		}, $categories);
		return response()->json($categoryNames);
	}

	private function getAnswerModels(Question $question)
	{
		$result = [];
		if (in_array($question->getType(), Question::getTypesWithoutAnswers())) {
			return $result;
		}
		foreach ($this->getAnswersInput($question) as $index => $answerText) {
			$answer = new Answer();
			$answer->setIsCorrect($this->getAnswersFlagsInput($question, $index));
			$answer->setTranslation(Translation::LANGUAGE_DEFAULT, $answerText);
			$result[] = $answer;
		}
		return $result;
	}

	private function getAnswersInput(Question $question)
	{
		$answers = Input::get('answers');
		$questionType = $question->getType();
		if (!isset($answers[$questionType]) || !is_array($answers[$questionType])) {
			throw new ValidationException('Answers data is invalid');
		}
		return $answers[$questionType];
	}

	private function getAnswersFlagsInput(Question $question, $answerIndex)
	{
		$answersCorrect = Input::get('answersCorrect');
		$questionType = $question->getType();
		if (!isset($answersCorrect[$questionType][$answerIndex])) {
			throw new ValidationException('Answer is flagged neither correct nor incorrect');
		}
		return $answersCorrect[$questionType][$answerIndex];
	}

	private function attachCategories(Question $question)
	{
		$categoryNames = Input::get('categories', []);
		if (!is_array($categoryNames)) {
			throw new ValidationException('Categories have invalid format');
		}
		$repository = new Categories();
		$categoriesIds = $repository->getOrCreateIds($categoryNames);
		if (!empty($categoriesIds)) {
			$question->categories()->attach($categoriesIds);
		}
	}

}
