<?php namespace Forestest\Models;

use Forestest\Models\Translation;
use Forestest\Models\Base\TranslationAwareModel;

class Answer extends TranslationAwareModel {

	public $timestamps = false;

	/*** methods ***/
	public function getTranslationType() {
		return Translation::ENTITY_TYPE_ANSWER;
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
