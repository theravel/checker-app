<?php namespace Forestest\Models;

use Forestest\Models\Translation;
use Forestest\Models\Base\BaseModel;
use Forestest\Models\Enum\EntityType;
use Forestest\Models\Traits\ModerationAwareTrait;
use Forestest\Models\Traits\TranslationAwareTrait;
use Forestest\Exceptions\ValidationException;

class Question extends BaseModel {

	use TranslationAwareTrait,
		ModerationAwareTrait;

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

	public function categories()
	{
		return $this->belongsToMany('Forestest\Models\Category', 'question_category');
	}

	/*** methods ***/
	public function save(array $options = array())
	{
		parent::save($options);
		$this->saveTranslations();
		$this->saveModerationLog();
	}

	public function getEntityType() {
		return EntityType::ENTITY_QUESTION;
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

	public function getCategories()
	{
		return $this->categories;
	}

	public function getAnswers()
	{
		return $this->answers;
	}

	/*** setters ***/

	public function setId($id)
	{
		$this->attributes['id'] = $id;
	}

	/**
	 * @param string $type
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
