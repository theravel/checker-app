<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;
use Forestest\Models\Enum\EntityType;
use Forestest\Models\Traits\ModerationAwareTrait;

class Category extends BaseModel {

	use ModerationAwareTrait;

	/*** methods ***/
	public function save(array $options = array())
	{
		parent::save($options);
		$this->saveModerationLog();
	}

	protected function getEntityType() {
		return EntityType::ENTITY_CATEGORY;
	}

	/*** getters ***/
	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getName()
	{
		return $this->attributes['name'];
	}

	/*** setters ***/
	public function setId($id)
	{
		$this->attributes['id'] = $id;
	}

	public function setName($name)
	{
		$this->attributes['name'] = $name;
	}

}
