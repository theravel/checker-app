<?php namespace Forestest\Models;

use DB;

use Forestest\Models\Translation;
use Forestest\Models\Base\TranslationAwareModel;
use Forestest\Exceptions\ValidationException;

class Question extends TranslationAwareModel {

	const TYPE_SINGLE_LINE = 1;
	const TYPE_MULTI_LINE = 2;
	const TYPE_RADIOS = 3;
	const TYPE_CHECKBOXES = 4;

	/*** relations ***/
	public function programLanguage()
	{
		return $this->hasOne('Forestest\Models\ProgramLanguage', 'id', 'p_language_id');
	}

	public function answers()
	{
		return $this->hasMany('Forestest\Models\Answer', 'question_id', 'id');
	}

	/*** methods ***/
	public function getTranslationType() {
		return Translation::ENTITY_TYPE_QUESTION;
	}

	/**
	 * @param Forestest\Models\Answer[] $answers
	 */
	public function saveWithAnswers(array $answers)
	{
		$this->validateAnswers($answers);
		$self = $this;
		DB::transaction(function() use ($self, $answers) {
			$self->save();
			$self->answers()->saveMany($answers);
		});
	}

	public static function getTypes()
	{
		// @TODO refactor, add languages support
		return [
			self::TYPE_SINGLE_LINE => 'Single line text',
			self::TYPE_MULTI_LINE => 'Multi-line text',
			self::TYPE_RADIOS => 'Pick one',
			self::TYPE_CHECKBOXES => 'Check all that apply',
		];
	}

	/**
	 * Such question types cannot have answers
	 *
	 * @return array
	 */
	public static function getTypesWithoutAnswers()
	{
		return [
			self::TYPE_SINGLE_LINE,
			self::TYPE_MULTI_LINE,
		];
	}

	/**
	 * @return Forestest\Models\Answer[] $answers
	 */
	private function validateAnswers(array $answers)
	{
		if (in_array($this->getType(), self::getTypesWithoutAnswers())) {
			return;
		}
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

	/*** getters ***/
	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getType()
	{
		return $this->attributes['type'];
	}

	public function getProgramLanguage()
	{
		return $this->programLanguage;
	}

	/*** setters ***/

	public function setId($id)
	{
		$this->attributes['id'] = $id;
	}

	/**
	 * @param int $id
	 * @throws \Forestest\Exceptions\ValidationException
	 */
	public function setType($type)
	{
		if (!in_array($type, array_keys(self::getTypes()))) {
			throw new ValidationException('Question type is invalid');
		}
		$this->attributes['type'] = $type;
	}

	public function setProgramLanguageId($id)
	{
		$this->attributes['p_language_id'] = $id;
	}

}
