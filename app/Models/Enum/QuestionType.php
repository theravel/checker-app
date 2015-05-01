<?php namespace Forestest\Models\Enum;

final class QuestionType extends BaseEnum {

	const TYPE_SINGLE_LINE = 1;
	const TYPE_MULTI_LINE = 2;
	const TYPE_RADIOS = 3;
	const TYPE_CHECKBOXES = 4;

	public function getAll()
	{
		return [
			self::TYPE_SINGLE_LINE,
			self::TYPE_MULTI_LINE,
			self::TYPE_RADIOS,
			self::TYPE_CHECKBOXES,
		];
	}

	public static function getTypesWithoutAnswers()
	{
		return [
			self::TYPE_SINGLE_LINE,
			self::TYPE_MULTI_LINE,
		];
	}

}
