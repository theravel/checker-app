<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;
use Forestest\Models\Enum\EntityType;
use Forestest\Models\Enum\QuestionType;
use Forestest\Models\Traits\ModerationAwareTrait;
use Forestest\Models\Traits\TranslationAwareTrait;

class Question extends BaseModel {

	use TranslationAwareTrait,
		ModerationAwareTrait;

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
			QuestionType::TYPE_SINGLE_LINE => 'Single line text',
			QuestionType::TYPE_MULTI_LINE => 'Multi-line text',
			QuestionType::TYPE_RADIOS => 'Pick one',
			QuestionType::TYPE_CHECKBOXES => 'Check all that apply',
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

	public function getUserId()
	{
		return $this->attributes['user_id'];
	}

	public function getParentQuestionIds()
	{
		return $this->attributes['parent_question_ids'];
	}

	public function getProgramLanguageId()
	{
		return $this->attributes['p_language_id'];
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

	public function setUserId($userId)
	{
		$this->attributes['user_id'] = $userId;
	}

	public function setParentQuestionIds(array $questionIds)
	{
		$this->attributes['parent_question_ids'] = $questionIds;
	}

	/**
	 * @param string $type
	 * @throws \Forestest\Exceptions\ValidationException
	 */
	public function setType($type)
	{
		QuestionType::validate($type);
		$this->attributes['type'] = $type;
	}

	public function setProgramLanguageId($id)
	{
		$this->attributes['p_language_id'] = $id;
	}

}
