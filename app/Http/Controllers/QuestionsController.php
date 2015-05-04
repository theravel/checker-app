<?php namespace Forestest\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Session;

use Forestest\Models\Answer;
use Forestest\Models\Question;
use Forestest\Models\Category;
use Forestest\Models\Translation;
use Forestest\Models\ProgramLanguage;
use Forestest\Models\Enum\QuestionType;
use Forestest\Models\Enum\ModerationStatus;
use Forestest\Repositories\QuestionsRepository;
use Forestest\Repositories\CategoriesRepository;
use Forestest\Exceptions\ValidationException;

class QuestionsController extends Controller {

	protected $pageCss = [
		'/vendor/components/codemirror-5.0/lib/codemirror.css',
		'/vendor/components/highlight-8.4/styles/default.css',
		'/vendor/components/jquery-ui-1.11.3/jquery-ui.min.css',
		'/vendor/components/tagit-2.0/jquery.tagit.css',
		'/components/markdown-editor/markdown-editor.css',
		'/components/markdown-view/markdown-view.css',
	];

	public function getPreview($id)
	{
		$question = Question::findOrFail($id);
		return view('questions/preview', [
			'language' => Translation::LANGUAGE_DEFAULT,
			'question' => $question,
		]);
	}

	public function getSuggest()
	{
		return view('questions/suggest', [
			'programLanguages' => ProgramLanguage::allOrdered()->get(),
			'questionTypes' => Question::getTypes(),
			'activeQuestionType' => QuestionType::TYPE_RADIOS,
		]);
	}

	public function postSuggest(Request $request)
	{
		$question = new Question();
		$question->setType($request->get('questionType'));
		$question->setProgramLanguageId($request->get('programLanguage'));
		$question->setModerationStatus(ModerationStatus::STATUS_PENDING);
		$question->setTranslation(Translation::LANGUAGE_DEFAULT, $request->get('text'));
		$repository = new QuestionsRepository();
		$repository->to($question)
			->attach('answers', $this->getAnswerModels($question))
			->attach('categories', $this->getCategoriesIds($question))
			->save();
		Session::flash('suggestSuccess', true);
		return response()->json(['id' => $question->getId()]);
	}

	public function getCategories(Request $request)
	{
		$repository = new CategoriesRepository();
		$categories = $repository->getAutocompleteValues($request->get('language'));
		$categoryNames = array_map(function(Category $category) {
			return $category->getName();
		}, iterator_to_array($categories));
		return response()->json($categoryNames);
	}

	private function getAnswerModels(Question $question)
	{
		$result = [];
		if (in_array($question->getType(), QuestionType::getTypesWithoutAnswers())) {
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

	private function getCategoriesIds(Question $question)
	{
		$categoryNames = Input::get('categories', []);
		if (!is_array($categoryNames)) {
			throw new ValidationException('Categories have invalid format');
		}
		$repository = new CategoriesRepository();
		return $repository->getOrCreateIds($categoryNames);
	}

}
