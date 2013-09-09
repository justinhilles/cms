<?php namespace Justinhilles\Cms\Menus;

use Menu\Menu;

class NestableRenderer extends \ListRenderer {

	protected $handler;
	protected $slug = null;

	public function __construct($slug = null, array $nodes = array())
	{
		$this->slug = $slug;
		
		$attributes = array('class' => 'dd-list');
		
		$this->handler = !is_null($slug) ? Menu::handler($slug, $attributes, 'ol') : Menu::items(null, array(), 'ol');

		parent::__construct($nodes);

		$this->process();
	}

	public function getPath()
	{
		return $this->current('path');
	}

	public function getTitle()
	{
		return $this->current('title');
	}

	public function getContent()
	{
		return sprintf('%s <small><em>%s</em></small>', $this->getTitle(), $this->getPath());
	}

	public function getId()
	{
		return $this->current('id');
	}

	public function getChildren()
	{
		return $this->current('children');
	}

	public function getLinkAttributes()
	{
		return array('class' => 'dd-handle');
	}

	public function getItemAttributes()
	{
		return array(
			'class' 		=> 'dd-item',
			'data-id' 		=> $this->getId(),
			'data-title' 	=> $this->getTitle(),
			'data-path' 	=> $this->getPath()
		);
	}

	public function handleChildren()
	{
		return $this->has('children') ? self::create(null, $this->getChildren())->handler : null;
	}

	public function process()
	{
		foreach($this as $node) {
			$this->handler->add(
				//Add Url
				$this->getPath(),
				//Add Title
				$this->getContent(),
				//Add Children
				$this->handleChildren(),
				//Add Link Attributes
				$this->getLinkAttributes(),
				//Add Item Attributes
				$this->getItemAttributes(),
				//Add Item Tag
				'li'
			);
		}
	}

	public static function create($slug = null, $nodes = array())
	{
		return new self($slug, $nodes);
	}

	public function __toString()
	{
		return (string) $this->wrap((string) $this->handler, 'div', array('class' => 'dd', 'id' => $this->slug));
	}
}