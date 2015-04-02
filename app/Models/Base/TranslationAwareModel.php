<?php namespace Forestest\Models\Base;

use DB;
use Forestest\Models\Translation;
use Illuminate\Database\Eloquent\Model;

abstract class TranslationAwareModel extends Model {

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

	public function save(array $options = array()) {
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

