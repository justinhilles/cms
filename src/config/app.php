<?php

return array(
	'aliases' => array(
		'Page' 					=> 'Justinhilles\Cms\Models\Page',
		'Menu' 					=> 'Justinhilles\Cms\Models\Menu',
		'PageObserver' 			=> 'Justinhilles\Cms\Observers\PageObserver',
		'Sluggable' 			=> 'Cviebrock\EloquentSluggable\Facades\Sluggable',
		'PagesAdminController' 	=> 'Justinhilles\Cms\Controllers\admin\PagesAdminController',
		'MenusAdminController' 	=> 'Justinhilles\Cms\Controllers\admin\MenusAdminController',
		'MenuRenderer' 			=> 'Justinhilles\Cms\Menus\MenuRenderer',
		'NestedSetRenderer' 	=> 'Justinhilles\Cms\Menus\NestedSetRenderer',
	),
	'providers' => array(
		'Cviebrock\EloquentSluggable\SluggableServiceProvider',
		'Baum\BaumServiceProvider'
	),
	'observers' => array(
		'Page' 					=> 'PageObserver'
	),
	'commands' => array(
		'command.cms.install' 	=> 'Justinhilles\Cms\CmsInstallCommand'
	),
	'files'			=> array(
		__DIR__.'/../routes.php',
		__DIR__.'/../macros.php'
	),
);