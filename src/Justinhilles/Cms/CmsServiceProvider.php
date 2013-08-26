<?php namespace Justinhilles\Cms;

use Illuminate\Support\ServiceProvider; 

class CmsServiceProvider extends ServiceProvider {

	use \Justinhilles\Admin\Providers\BaseServiceProvider;

	const PACKAGE = 'justinhilles/cms';
	
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
		$this->package(self::PACKAGE);

		$this->registerFromConfig('cms');

		
	}

	public function registerCollection()
	{
		$this->app['basset']->package('justinhilles/cms');

		$this->app['basset']->collection(\Config::get('cms::config.collection', 'cms'), function($collection) {

			if($stylesheets = \Config::get('cms::config.stylesheets')) {
				foreach($stylesheets as $stylesheet) {
					$collection->stylesheet($stylesheet);
				}
			}

			if($javascripts = \Config::get('cms::config.javascripts')) {
				foreach($javascripts as $javascript) {
					$collection->javascript($javascript);
				}
			}
		});
	}

	public function boot()
	{
		$this->bootFromConfig('cms');

		$this->registerCollection();
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
}