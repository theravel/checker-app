<?php namespace Forestest\Models\Base;

use DB;
use Forestest\Models\Translation;
use Illuminate\Database\Eloquent\Model;

abstract class TranslationAwareModel extends Model {

	/**
	 * @var \Forestest\Models\Translation
	 */
	protected $translation;

	public function setTranslation($language, $text)
	{
		if (null === $this->translation) {
			$this->translation = new Translation();
		}
		$this->translation->setEntityType($this->getTranslationType());
		$this->translation->setLanguage($language);
		$this->translation->setText($text);
	}

	public function save(array $options = array()) {
		DB::transaction(function() use ($options) {
			parent::save($options);
			$this->translation->setEntityId($this->getId());
			$this->translation->save();
		});
	}

	abstract protected function getId();
	abstract protected function getTranslationType();

}

