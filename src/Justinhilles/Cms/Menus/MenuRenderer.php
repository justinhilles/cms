<?php namespace Justinhilles\Cms\Menus;

use Justinhilles\Cms\Models\Menu;

class MenuRenderer extends NestedSetRenderer {

	public static function find($slug, $options = array(), $attributes = array())
	{
		$menu = Menu::whereslug($slug)->first();

		$options['link_closure'] = function($page){
			return link_to($page->path, $page->title);
		};

		if(!is_null($menu)) {
			$nodes = $menu->pages()->orderBy('lft')->get();
		}	

		if(count($nodes) > 0) {
			return self::create($nodes, $options, $attributes);
		}	
	}
}