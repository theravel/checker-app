<?php namespace Forestest\Providers;

use Illuminate\Support\ServiceProvider;

use Forestest\Console\Migrations\Generator;
use Forestest\Console\Commands\Artisan\MigrateCreate;

class ArtisanExtensionProvider extends ServiceProvider {

	public function register() {
		$this->app['migrate:create'] = $this->app->share(function($app) {
			$generator = new Generator($app['files']);
			return new MigrateCreate($generator);
		});
		$this->commands('migrate:create');
	}

}