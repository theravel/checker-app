<?php namespace Forestest\Console\Migrations;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

abstract class AbstractMigration extends Migration {

	private $delimiter = ';';
	private $extension = '.sql';

	private function getFilePath($action)
	{
		$ds = DIRECTORY_SEPARATOR;
		$reflector = new \ReflectionClass(get_class($this));
		$filename = $reflector->getFileName();
		$pathInfo = pathinfo($filename);
		return $pathInfo['dirname'] . $ds . $pathInfo['filename'] . $ds . $action . $this->extension;
	}

	protected function exec($action)
	{
		$path = $this->getFilePath($action);
		if (!file_exists($path)) {
			// TODO
		}
		$sqlStatements = explode($this->delimiter, file_get_contents($path));
		foreach ($sqlStatements as $sqlStatement) {
			$sql = trim($sqlStatement);
			if (!empty($sql)) {
				DB::statement($sql);
			}
		}
	}

	protected function setDelimiter($delimiter)
	{
		$this->delimiter = $delimiter;
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->exec('up');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$this->exec('down');
	}
}