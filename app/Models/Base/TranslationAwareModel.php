<?php namespace Forestest\Models\Base;

use Forestest\Models\Translation;
use Forestest\Models\Traits\CacheAwareTrait;

use DB;
use Illuminate\Database\Eloquent\Model;

abstract class TranslationAwareModel extends Model {

	use CacheAwareTrait;

	/**
	 * @var \Forestest\Models\Translation[]
	 */
	protected $translations = array();

	public function setTranslation($language, $text)
	{
		if (!isset($this->translations[$language])) {
			$this->translations[$language] = new Translation();
		}
		$translation = $this->translations[$language];
		$translation->setEntityType($this->getTranslationType());
		$translation->setLanguage($language);
		$translation->setText($text);
	}

	public function getTranslation($language)
	{
		$key = sprintf(
			'translation_%s_%s_%s',
			$this->getId(),
			$this->getTranslationType(),
			$language
		);
		$text = $this->getCache($key);
		if (null === $text) {
			$translation = Translation::where('entity_id', '=', $this->getId())
				->where('entity_type', $this->getTranslationType())
				->where('language', '=', $language)
				->firstOrFail();
			$text = $translation->getText();
			$this->setCache($key, $text, $this->expires['day']);
		}
		return $text;
	}

	public function save(array $options = array())
	{
		$translations = $this->translations;
		DB::transaction(function() use ($options, $translations) {
			parent::save($options);
			foreach ($translations as $translation) {
				$translation->setEntityId($this->getId());
				$translation->save();
			}
		});
	}

	abstract protected function getId();
	abstract protected function getTranslationType();

}

