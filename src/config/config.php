<?php

return array(
	'views' => array(
		'pages.show' => 'Default', 
		'pages.home' => 'Home'
	),
	'front' => array(
		'layout' => 'layouts.default'
	),
	'admin' => array(
		'per_page' => 10,
		'layout' => 'layouts.default'
	),
	'aliases' => array(
		'Page' => 'Justinhilles\Cms\Models\Page',
		'Menu' => 'Justinhilles\Cms\Models\Menu',
		'PageObserver' => 'Justinhilles\Cms\Observers\PageObserver',
		'Sluggable' => 'Cviebrock\EloquentSluggable\Facades\Sluggable',
		'PagesAdminController' => 'Justinhilles\Cms\Controllers\admin\PagesAdminController',
		'MenusAdminController' => 'Justinhilles\Cms\Controllers\admin\MenusAdminController',
		'MenuRenderer' => 'Justinhilles\Cms\Menus\MenuRenderer',
		'NestedSetRenderer' => 'Justinhilles\Cms\Menus\NestedSetRenderer',
		'PagesController' => 'Justinhilles\Cms\Controllers\PagesController'
	),
	'observers' => array(
		'Page' => 'PageObserver'
	)
);