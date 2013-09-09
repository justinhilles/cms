<?php

namespace Justinhilles\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    
    protected $guarded = array();

    public static $rules = array();

    public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    protected $table = 'menus';

	public function pages()
    {
        return $this->belongsToMany('Page', 'menus_pages');
    }

    public function update(array $attributes = array())
    {
        if(isset($attributes['pages'])) {
    	   $this->pages()->sync($attributes['pages']);
    	   unset($attributes['pages']);
        }
    	parent::update($attributes);
	}
}