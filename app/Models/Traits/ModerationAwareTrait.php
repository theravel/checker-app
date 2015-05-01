<?php namespace Forestest\Models\Traits;

use Forestest\Models\ModerationLog;
use Forestest\Models\Enum\ModerationStatus;
use Forestest\Models\Traits\EntityDependentTrait;

trait ModerationAwareTrait {

	use EntityDependentTrait;

	/*** methods ***/
	protected function saveModerationLog()
	{
		if (null === $this->getModerationStatus()) {
			$this->setModerationStatus(ModerationStatus::STATUS_DEFAULT);
		}
		$this->createLogEntry();
	}

	private function createLogEntry()
	{
		$logEntry = new ModerationLog();
		$logEntry->setEntityId($this->getId());
		$logEntry->setEntityType($this->getEntityType());
		$logEntry->setModerationStatus($this->getModerationStatus());
		$logEntry->save();
	}

	/*** getters ***/
	public function getModerationStatus()
	{
		return $this->attributes['moderation_status'];
	}

	/*** setters ***/
	public function setModerationStatus($moderationStatus)
	{
		ModerationStatus::validate($moderationStatus);
		$this->attributes['moderation_status'] = $moderationStatus;
	}

}