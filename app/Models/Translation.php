<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;

class Translation extends BaseModel {

	const ENTITY_TYPE_QUESTION = 'QUESTION';
	const ENTITY_TYPE_ANSWER = 'ANSWER';

	const LANGUAGE_DEFAULT = 'ru';

	public $timestamps = false;

	/*** scopes ***/
	/**/

	/*** getters ***/
	public function getId()
	{
		return $this->attributes['id'];
	}

	public function getEntityId()
	{
		return $this->attributes['entity_id'];
	}

	public function getEntityType()
	{
		return $this->attributes['entity_type'];
	}

	public function getLanguage()
	{
		return $this->attributes['language'];
	}

	public function getText()
	{
		return $this->attributes['text'];
	}

	/*** setters ***/
	public function setId($id)
	{
		$this->attributes['id'] = $id;
	}

	public function setEntityId($entityId)
	{
		$this->attributes['entity_id'] = $entityId;
	}

	public function setEntityType($entityType)
	{
		$this->attributes['entity_type'] = $entityType;
	}

	public function setLanguage($language)
	{
		$this->attributes['language'] = $language;
	}

	public function setText($text)
	{
		$this->attributes['text'] = $text;
	}

}

