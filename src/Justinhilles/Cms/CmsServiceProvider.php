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

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cms');
	}

	public function boot()
	{

		$this->package('justinhilles/cms');

		$this->app['config']->package('justinhilles/cms', __DIR__.'/../../config');

		$this->registerProviders(Config::get('cms::app.providers'));

		$this->registerAliases(Config::get('cms::app.aliases'));

		$this->registerObservers(Config::get('cms::app.observers'));

		include __DIR__.'/../../routes.php';
		include __DIR__.'/../../macros.php';

		\App::missing(function($exception)
		{
		    $content = \View::make('cms::errors.404');
		    return \Response::make($content, 404);
		});
	}


	public function registerObservers($observers = array())
	{
		if(!empty($observers)) {
			foreach($observers as $model => $observer) {
				$model::observe(new $observer);
			}
		}
	}

	public function registerAliases($aliases = array())
	{
		if(!empty($aliases)) {
			foreach($aliases as $alias => $original) {
				class_alias($original, $alias);
			}
		}		
	}

	public function registerProviders($providers = array()) 
	{
		if(!empty($providers)) {
			foreach($providers as $provider) {
				$this->app->register($provider);
			}	
		}
	}

	/** register the custom commands **/
	public function registerCommands($commands = array())
	{
		if(!empty($commands)) {
			foreach($commands as $alias => $class) {
				$this->app[$alias] = $this->app->share(function($app) use ($class) {
					return new $class;
				});

				$this->commands($alias);				
			}
		}
	}
}