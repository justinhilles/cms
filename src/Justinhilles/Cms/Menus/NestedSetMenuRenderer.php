<?php namespace Justinhilles\Cms\Menus;

use Menu\Menu;

class NestedSetMenuRenderer {

	protected $handler;

	public function __construct($slug = null, $nodes = array())
	{
		$this->handler = !is_null($slug) ? Menu::handler($slug, array('class' => 'dd-list'), 'ol') : Menu::items(null, array('class' => 'dd-list'), 'ol');

		$this->process($nodes);
	}

	public function process($nodes)
	{
		foreach($nodes as $path => $node) {
			$this->handler->add(isset($node['path']) ? $node['path'] : $path, 
								$node['title'], 
								isset($node['children']) ? self::create(null, $node['children'])->handler : null,
								array(
									'class' => 'dd-handle'
									)
								,
								array(
									'class' => 'dd-item',
									'data-id' => isset($node['id']) ? $node['id'] : null,
									'data-title' => $node['title'],
									'data-path' => isset($node['path']) ? $node['path'] : null
								),
								'li');
		}
	}

	public static function create($slug = null, $nodes = array())
	{
		return new self($slug, $nodes);
	}

	public function __toString()
	{
		return (string) $this->handler;
	}
}