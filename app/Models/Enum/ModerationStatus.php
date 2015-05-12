<?php namespace Forestest\Models\Enum;

final class ModerationStatus extends BaseEnum {

	const STATUS_PENDING = 'PENDING';
	const STATUS_APPROVED = 'APPROVED';
	const STATUS_REJECTED = 'REJECTED';
	const STATUS_WITHDRAWN = 'WITHDRAWN';

	const STATUS_DEFAULT = 'PENDING';

	public function getAll()
	{
		return [
			self::STATUS_PENDING,
			self::STATUS_APPROVED,
			self::STATUS_REJECTED,
			self::STATUS_WITHDRAWN,
		];
	}

}
