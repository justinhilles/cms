<?php

Route::group(array('prefix' => 'admin', 'before' => 'auth'), function() {
	Route::resource('menus', 'Justinhilles\Cms\Controllers\Admin\MenusAdminController');
	Route::resource('pages', 'Justinhilles\Cms\Controllers\Admin\PagesAdminController');
});

// Catch All, Place at end of your routes file
//Route::any('{path}', 'Justinhilles\Cms\Controllers\PagesController@show')->where('path', '.*');