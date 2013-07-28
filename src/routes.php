<?php

Route::group(array('prefix' => 'admin', 'before' => 'auth|permission'), function() {
	Route::resource('menus', 'MenusAdminController');
	Route::resource('pages', 'PagesAdminController');
});

// Catch All, Place at end of your routes file
//Route::any('{path}', 'PagesController@show')->where('path', '.*');