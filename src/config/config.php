<?php

return array(
	'views' => array(
		'pages.show' 	=> 'Default', 
		'pages.home' 	=> 'Home'
	),
	'front' => array(
		'layout' 		=> 'admin::layouts.default',
		'view' 			=> 'cms::pages.show'
	),
	'collection'		=> 'cms',
	'stylesheets' 		=> array(
		__DIR__.'/../../public/assets/stylesheets/admin.css'
	),
	'javascripts' 		=> array(
		__DIR__.'/../../public/assets/javascripts/jquery.nestable.js',
		__DIR__.'/../../public/assets/javascripts/admin.js'
	)
);