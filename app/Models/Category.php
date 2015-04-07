<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;

class Category extends BaseModel {

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
