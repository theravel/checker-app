<?php namespace Forestest\Console\Migrations;

use Illuminate\Database\Migrations\MigrationCreator;

class Generator extends MigrationCreator {
	
	public function create($name, $path, $table = null, $create = false)
	{
		$dirPath = $this->getPath($name, $path);
		$filePath = $dirPath . '.php';
		$stub = $this->getStub($table, $create);
		$this->files->makeDirectory($dirPath);
		$this->files->put($dirPath . '/up.sql', '');
		$this->files->put($dirPath . '/down.sql', '');
		$this->files->put($filePath, $this->populateStub($name, $stub, $table));
		return $filePath;
	}

	protected function getPath($name, $path)
	{
		return $path.'/'.$this->getDatePrefix().'_'.$name;
	}

	public function getStubPath()
	{
		return __DIR__.'/stubs';
	}

}
