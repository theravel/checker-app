<?php namespace Forestest\Models\Enum;

use Forestest\Exceptions\ValidationException;

final class EntityType {

	const ENTITY_QUESTION = 'QUESTION';
	const ENTITY_ANSWER = 'ANSWER';

	public static function getAllTypes()
	{
		return [
			self::ENTITY_ANSWER,
			self::ENTITY_QUESTION,
		];
	}

	public static function validateType($type)
	{
		if (!in_array($type, self::getAllTypes())) {
			throw new ValidationException("'$type' is not a valid entity type value");
		}
	}

}
