<?php namespace Justinhilles\Cms;

use Illuminate\Support\ServiceProvider; 
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\App;

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

        App::bind('PageRepository', 'Justinhilles\Cms\Repositories\PageRepository');
        
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