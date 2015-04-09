<?php namespace Forestest\Repositories\Base;

use DB;

use Forestest\Models\Base\BaseModel;

abstract class FluentRelationsRepository {

	private $relationTo;
	private $relationAttached = [];

	abstract public function save();

	public function __construct() {
		$this->resetRelations();
	}

	/**
	 * @param \Forestest\Models\Base\BaseModel $object
	 * @return \Forestest\Repositories\Base\FluentRelationsRepository
	 */
	public function to(BaseModel $object)
	{
		$this->resetRelations();
		$this->relationTo = $object;
		return $this;
	}

	/**
	 * @param string $key
	 * @param mixed $relation
	 * @return \Forestest\Repositories\Base\FluentRelationsRepository
	 */
	public function attach($key, $relation)
	{
		$this->relationAttached[$key] = $relation;
		return $this;
	}

	/**
	 * @return \Forestest\Models\Base\BaseModel
	 */
	protected function getObject()
	{
		return $this->relationTo;
	}

	protected function getAttached($key, $default = null)
	{
		return isset($this->relationAttached[$key])
			? $this->relationAttached[$key]
			: $default;
	}

	protected function saveRelated(Callable $transaction)
	{
		DB::transaction($transaction);
		$this->resetRelations();
	}

	private function resetRelations()
	{
		$this->relationTo = null;
		$this->relationAttached = [];
	}

}