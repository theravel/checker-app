<?php namespace Forestest\Models\Enum;

final class EntityType extends BaseEnum {

	const ENTITY_QUESTION = 'QUESTION';
	const ENTITY_ANSWER = 'ANSWER';
	const ENTITY_CATEGORY = 'CATEGORY';

	public function getAll()
	{
		return [
			self::ENTITY_ANSWER,
			self::ENTITY_QUESTION,
			self::ENTITY_CATEGORY,
		];
	}

}
