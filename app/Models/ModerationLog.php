<?php namespace Forestest\Models;

use Forestest\Models\Base\BaseModel;
use Forestest\Models\Enum\EntityType;
use Forestest\Models\Enum\ModerationStatus;

class ModerationLog extends BaseModel {

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

	public function getModerationStatus()
	{
		return $this->attributes['moderation_status'];
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
		EntityType::validate($entityType);
		$this->attributes['entity_type'] = $entityType;
	}

	public function setModerationStatus($moderationStatus)
	{
		ModerationStatus::validate($moderationStatus);
		$this->attributes['moderation_status'] = $moderationStatus;
	}

}

