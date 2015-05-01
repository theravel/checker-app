<?php namespace Forestest\Repositories;

use Forestest\Models\Enum\QuestionType;
use Forestest\Exceptions\ValidationException;
use Forestest\Repositories\Base\FluentRelationsRepository;

class QuestionsRepository extends FluentRelationsRepository {

	public function save()
	{
		$question = $this->getObject();
		$answers = $this->getAttached('answers', []);
		$categoriesIds = $this->getAttached('categoriesIds', []);
		if (!in_array($question->getType(), QuestionType::getTypesWithoutAnswers())) {
			$this->validateAnswers($answers);
		}
		$this->saveRelated(function() use ($question, $answers, $categoriesIds) {
			$question->save();
			$question->answers()->saveMany($answers);
			if (!empty($categoriesIds)) {
				$question->categories()->attach($categoriesIds);
			}
		});
	}

	/**
	 * @param \Forestest\Models\Answer[] $answers
	 */
	private function validateAnswers(array $answers)
	{
		if (count($answers) < 2) {
			throw new ValidationException('At least two answers must exist');
		}
		$correctAnswerExist = false;
		foreach ($answers as $answer) {
			if ($answer->getIsCorrect()) {
				$correctAnswerExist = true;
				break;
			}
		}
		if (!$correctAnswerExist) {
			throw new ValidationException('At least one answer must be flagged as correct');
		}
	}

}