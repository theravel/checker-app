<?php namespace Forestest\Models\Enum;

use Forestest\Exceptions\ValidationException;

abstract class BaseEnum {

	abstract public function getAll();

	public static function validate($value)
	{
		$instance = new static();
		if (!in_array($value, $instance->getAll())) {
			throw new ValidationException("'$value' is not a valid enum value");
		}
	}

}
