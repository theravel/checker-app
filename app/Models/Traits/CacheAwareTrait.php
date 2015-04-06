<?php namespace Forestest\Models\Traits;

use Cache;

trait CacheAwareTrait {

	protected $expires = [
		'minute' => 60,
		'hour'   => 60 * 60,
		'day'    => 60 * 60 * 24,
		'week'   => 60 * 60 * 24 * 7,
	];

	protected function setCache($key, $value, $expires)
	{
		Cache::put($key, $value, $expires);
	}

	protected function getCache($key, $default = null)
	{
		return Cache::get($key, $default);
	}

}