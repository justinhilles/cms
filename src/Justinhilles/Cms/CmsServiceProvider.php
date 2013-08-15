<?php namespace Justinhilles\Cms;

use Illuminate\Support\ServiceProvider; 

class CmsServiceProvider extends ServiceProvider {

	use \Justinhilles\Admin\Providers\BaseServiceProvider;
	
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
		$this->package('justinhilles/cms');

		$this->registerFromConfig('cms');
	}

	public function boot()
	{
		$this->bootFromConfig('cms');
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