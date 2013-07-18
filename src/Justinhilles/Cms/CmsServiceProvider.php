<?php namespace Justinhilles\Cms;

use Illuminate\Support\ServiceProvider; 
use Illuminate\Support\Facades\Config;

class CmsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerCommands();
	}

	public function boot()
	{
		$this->app['config']->package('justinhilles/cms', __DIR__.'/../../config');

		$this->app->register('Cviebrock\EloquentSluggable\SluggableServiceProvider');
		$this->app->register('Baum\BaumServiceProvider');

		$aliases = Config::get('cms::config.aliases');

		if(!empty($aliases)) {
			foreach($aliases as $alias => $original) {
				class_alias($original, $alias);
			}
		}

		$observers = Config::get('cms::config.observers');

		if(!empty($observers)) {
			foreach($observers as $model => $observer) {
				$model::observe(new $observer);
			}
		}

		$this->package('justinhilles/cms');

		include __DIR__.'/../../routes.php';
		include __DIR__.'/../../macros.php';
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cms');
	}

		/** register the custom commands **/
	public function registerCommands()
	{
		$commands = array('CmsInstall');

		$this->app['command.cms.install'] = $this->app->share(function($app)
		{
			return new CmsInstallCommand();
		});

		$this->commands(
			'command.cms.install'
		);
	}

}