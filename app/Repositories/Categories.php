<?php namespace Forestest\Repositories;

use DB;

use Forestest\Models\Category;

class Categories {

	public function getOrCreateIds(array $categoryNames)
	{
		$items = $this->findCaseInsensitive($categoryNames);
		$ids = [];
		foreach ($categoryNames as $name) {
			$id = null;
			foreach ($items as $item) {
				if (0 === strcasecmp($item->getName(), $name)) {
					$id = $item->getId();
					break;
				}
			}
			if ($id) {
				$ids[] = $id;
			} else {
				$ids[] = $this->createNew($name);
			}
		}
		return $ids;
	}

	private function findCaseInsensitive(array $names)
	{
		$lowerNames = array_map(function($name) {
			return strtolower($name);
		}, $names);
		return Category::whereIn(DB::raw('LOWER(name)'), $lowerNames)->get();
	}

	private function createNew($name)
	{
		$category = new Category();
		$category->setName($name);
		$category->save();
		return $category->getId();
	}

}