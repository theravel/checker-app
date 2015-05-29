<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;

class ProgramLanguage extends BaseModel {

	const DEFAULT_SELECTED = 7;

	public $timestamps = false;

	/*** scopes ***/
	public function scopeAllOrdered($query)
	{
		return $query->orderBy('position');
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

	public function getHighlightAlias()
	{
		return $this->attributes['highlight_alias'];
	}

	public function getPosition()
	{
		return $this->attributes['position'];
	}

}

