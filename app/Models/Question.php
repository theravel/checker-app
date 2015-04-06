<?php namespace Forestest\Models;

use Forestest\Models\Answer;
use Forestest\Models\Translation;
use Forestest\Models\Base\TranslationAwareModel;
use Forestest\Exceptions\ValidationException;

class Question extends TranslationAwareModel {

	const TYPE_SINGLE_LINE = 1;
	const TYPE_MULTI_LINE = 2;
	const TYPE_RADIOS = 3;
	const TYPE_CHECKBOXES = 4;

	/**
	 * @var \Forestest\Models\Answer[] 
	 */
	private $answers = [];

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

	public function addAnswer(Answer $answer)
	{
		$this->answers[] = $answer;
	}

	public function save(array $options = array())
	{
		parent::save($options);
		$this->answers()->saveMany($this->answers);
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
