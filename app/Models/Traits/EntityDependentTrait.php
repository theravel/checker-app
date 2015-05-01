<?php namespace Forestest\Models\Traits;

trait EntityDependentTrait {
	abstract protected function getId();
	abstract protected function getEntityType();
}
