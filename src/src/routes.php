<?php

Route::group(array('prefix' => 'admin', 'before' => 'auth'), function() {
	Route::resource('menus', 'MenusAdminController');
	Route::resource('pages', 'PagesAdminController');
});

// Catch All
//Route::any('{path}', 'PagesController@show')->where('path', '.*');