<?php namespace Forestest\Models;

use Forestest\Models\Translation;
use Forestest\Models\Base\BaseModel;
use Forestest\Models\Enum\EntityType;
use Forestest\Models\Traits\TranslationAwareTrait;

class Answer extends BaseModel {

	use TranslationAwareTrait;

	public $timestamps = false;

	/*** methods ***/
	public function save(array $options = array())
	{
		parent::save($options);
		$this->saveTranslations();
	}

	public function getEntityType()
	{
		return EntityType::ENTITY_ANSWER;
	}

	/*** getters ***/
	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getQuestionId()
	{
		return $this->attributes['question_id'];
	}

	public function getIsCorrect()
	{
		return $this->attributes['is_correct'];
	}

	/*** setters ***/
	public function setId($id)
	{
		$this->attributes['id'] = $id;
	}

	public function setQuestionId($questionId)
	{
		$this->attributes['question_id'] = $questionId;
	}

	public function setIsCorrect($isCorrect)
	{
		$this->attributes['is_correct'] = (boolean)$isCorrect;
	}

}
