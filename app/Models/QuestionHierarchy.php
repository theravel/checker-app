<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;

class QuestionHierarchy extends BaseModel {

	protected $table = 'question_hierarchy';
	public $timestamps = false;

	/*** getters ***/
	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getQuestionId()
	{
		return $this->attributes['question_id'];
	}

	public function getParentId()
	{
		return $this->attributes['parent_id'];
	}

	public function getChildrenIds()
	{
		return $this->attributes['children_ids'];
	}

	/*** setters ***/
	public function setQuestionId($questionId)
	{
		$this->attributes['question_id'] = $questionId;
	}

	public function setParentId($parentId)
	{
		$this->attributes['parent_id'] = $parentId;
	}

	public function setChildrenIds($childrenIds)
	{
		$this->attributes['children_ids'] = $childrenIds;
	}

}

