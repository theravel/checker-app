<?php namespace Forestest\Models\Traits;

use Forestest\Models\Translation;
use Forestest\Models\Traits\CacheAwareTrait;
use Forestest\Models\Traits\EntityDependentTrait;
use Forestest\Exceptions\ValidationException;

trait TranslationAwareTrait {

	use CacheAwareTrait,
		EntityDependentTrait;

	/**
	 * @var \Forestest\Models\Translation[]
	 */
	protected $translations = [];

	public function setTranslation($language, $text)
	{
		if (!strlen(trim($text))) {
			throw new ValidationException(sprintf(
				'Translation text is empty [%s] [%s]',
				$this->getEntityType(), $language
			));
		}
		if (!isset($this->translations[$language])) {
			$this->translations[$language] = new Translation();
		}
		$translation = $this->translations[$language];
		$translation->setEntityType($this->getEntityType());
		$translation->setLanguage($language);
		$translation->setText($text);
	}

	public function getTranslation($language)
	{
		$key = $this->getCacheKey($language);
		$text = $this->getCache($key);
		if (null === $text) {
			$translation = Translation::where('entity_id', '=', $this->getId())
				->where('entity_type', $this->getEntityType())
				->where('language', '=', $language)
				->firstOrFail();
			$text = $translation->getText();
			$this->setCache($key, $text, $this->expires['day']);
		}
		return $text;
	}

	public function saveTranslations()
	{
		foreach ($this->translations as $translation) {
			$translation->setEntityId($this->getId());
			$translation->save();
			$key = $this->getCacheKey($translation->getLanguage());
			$this->setCache($key, $translation->getText(), $this->expires['day']);
		}
	}

	private function getCacheKey($language)
	{
		return sprintf(
			'translation_%s_%s_%s',
			$this->getId(),
			$this->getEntityType(),
			$language
		);
	}

}

