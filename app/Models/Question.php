<?php namespace Forestest\Models;

use Forestest\Models\Translation;
use Forestest\Models\Base\TranslationAwareModel;

class Question extends TranslationAwareModel {

	const TYPE_SINGLE_LINE = 1;
	const TYPE_MULTI_LINE = 2;
	const TYPE_RADIOS = 3;
	const TYPE_CHECKBOXES = 4;

	/*** relations ***/
	public function programLanguage()
	{
		return $this->hasOne('Forestest\Models\ProgramLanguage', 'id', 'p_language_id');
	}

	/*** methods ***/
	public function getTranslationType() {
		return Translation::ENTITY_TYPE_QUESTION;
	}

	public static function getTypes()
	{
		// @TODO refactor
		return [
			self::TYPE_SINGLE_LINE => 'Single line text',
			self::TYPE_MULTI_LINE => 'Multi-line text',
			self::TYPE_RADIOS => 'Pick one',
			self::TYPE_CHECKBOXES => 'Check all that apply',
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

	public function getProgramLanguage()
	{
		return $this->programLanguage;
	}

	/*** setters ***/
	public function setId($id)
	{
		$this->attributes['id'] = $id;
	}

	public function setType($type)
	{
		$this->attributes['type'] = $type;
	}

	public function setProgramLanguageId($id)
	{
		$this->attributes['p_language_id'] = $id;
	}

}
