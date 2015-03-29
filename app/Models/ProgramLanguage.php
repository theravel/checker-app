<?php namespace Forestest\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramLanguage extends Model {

	const DEFAULT_SELECTED = 7;

	public $timestamps = false;

	/*** methods ***/
	public function isDefaultSelected()
	{
		return $this->getId() === self::DEFAULT_SELECTED;
	}

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

