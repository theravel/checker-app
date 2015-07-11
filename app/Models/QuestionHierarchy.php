<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;

class QuestionHierarchy extends BaseModel {

	protected $table = 'question_hierarchy';
	public $timestamps = false;

	/*** internal properties ***/
	private $childrenIds = [];

	/*** internal methods ***/
	private function parseChildrenIds()
	{
		$numbers = trim(substr($this->attributes['children_ids'], 1, -1));
		if (!empty($numbers)) {
			$this->childrenIds = explode(',', $numbers);
		}
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

	public function getParentId()
	{
		return $this->attributes['parent_id'];
	}

	public function getChildrenIds()
	{
		if (empty($this->childrenIds)) {
			$this->parseChildrenIds();
		}
		return $this->childrenIds;
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

	public function addChildId($childId)
	{
		if (empty($this->childrenIds)) {
			$this->parseChildrenIds();
		}
		$this->childrenIds[] = $childId;
		$this->setChildrenIds($this->childrenIds);
	}

	public function setChildrenIds($childrenIds)
	{
		$this->attributes['children_ids'] = '{' . implode(',', $childrenIds) . '}';
	}

}

