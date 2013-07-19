<?php

return array(
	'views' => array(
		'pages.show' => 'Default', 
		'pages.home' => 'Home'
	),
	'admin' => array(
		'per_page' => 10
	),
	'aliases' => array(
		'Page' => 'Justinhilles\Cms\Models\Page',
		'Menu' => 'Justinhilles\Cms\Models\Menu',
		'PageObserver' => 'Justinhilles\Cms\Observers\PageObserver',
		'Sluggable' => 'Cviebrock\EloquentSluggable\Facades\Sluggable',
		'PagesAdminController' => 'Justinhilles\Cms\Controllers\admin\PagesAdminController',
		'MenuRenderer' => 'Justinhilles\Cms\Menus\MenuRenderer',
		'PagesController' => 'Justinhilles\Cms\Controllers\PagesController'
	),
	'observers' => array(
		'Page' => 'PageObserver'
	)
);