<?php

return array(
	'views' => array(
		'pages.show' 	=> 'Default', 
		'pages.home' 	=> 'Home'
	),
	'front' => array(
		'layout' 		=> 'layouts.default',
		'view' 			=> 'pages.show'
	),
	'collection'		=> 'cms',
	'stylesheets' 		=> array(
		__DIR__.'/../../public/assets/stylesheets/admin.css'
	),
	'javascripts' 		=> array(
		'//raw.github.com/dbushell/Nestable/master/jquery.nestable.js',
		__DIR__.'/../../public/assets/javascripts/admin.js'
	)
);