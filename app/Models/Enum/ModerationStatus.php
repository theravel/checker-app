<?php namespace Forestest\Models\Enum;

use Forestest\Exceptions\ValidationException;

final class ModerationStatus {

	const STATUS_PENDING = 'PENDING';
	const STATUS_APPROVED = 'APPROVED';
	const STATUS_REJECTED = 'REJECTED';

	const STATUS_DEFAULT = 'PENDING';

	public static function getAllStatuses()
	{
		return [
			self::STATUS_PENDING,
			self::STATUS_APPROVED,
			self::STATUS_REJECTED,
		];
	}

	public static function validateStatus($status)
	{
		if (!in_array($status, self::getAllStatuses())) {
			throw new ValidationException("'$status' is not a valid moderation status value");
		}
	}

}
