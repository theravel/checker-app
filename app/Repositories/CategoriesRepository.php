<?php namespace Forestest\Repositories;

use DB;

use Forestest\Models\Category;
use Forestest\Models\Enum\ModerationStatus;

class CategoriesRepository {

	public function getAutocompleteValues($language)
	{
		// @TODO later return categories related to selected language
		// @TODO allow PENDING categories for myself?
		return Category::where('moderation_status', ModerationStatus::STATUS_APPROVED)->get();
	}

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
		$category->setModerationStatus(ModerationStatus::STATUS_PENDING);
		$category->save();
		return $category->getId();
	}

}