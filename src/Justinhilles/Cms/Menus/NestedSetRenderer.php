<?php 

use Illuminate\Database\Eloquent\Collection;
use \Baum\Node;

class NestedSetRenderer implements \RecursiveIterator {

	private 	$_nodes = array();
	private 	$_position = 0;
	private 	$_level = 0;
	protected 	$_options = array('children' => true, 'link_closure' => null);
	protected 	$_attributes = array();

	public function __construct(Collection $nodes, array $options = array(), array $attributes = array(), $level = 0)
	{
		$this->_attributes = (array) $attributes;
		$this->_options = (array) array_merge($this->_options, $options);
		$this->_nodes = $nodes;
		$this->_level = (int) ($nodes->first() ? $nodes->first()->getLevel() : $level);
	}

	public static function create($nodes, $options = array(), $attributes = array(), $level = 0)
	{
		return new self(self::convert($nodes), $options, $attributes, $level);
	}

	public  static function convert($nodes)
	{
		return is_array($nodes) ? new Collection($nodes) : $nodes;
	}

	public function nodes()
	{
		return $this->_nodes;
	}

	public function current()
	{
		return $this->nodes()->get($this->_position);
	}

	public function hasChildren()
	{

	}

	public function getChildren()
	{
		$current = $this->current();

		$children = array();

		foreach($this->nodes() as $i => $node) {
			if($node->isDescendantof($current)) {
				$children[] = $node;
			}
		}

		return $this->convert(array_filter($children));
	}

	public function next()
	{
		return $this->_position++;
	}

	public function key()
	{
		return $this->_position;
	}

	public function valid()
	{
		return (boolean) ($this->current() instanceof Node AND  $this->_level === (int) $this->current()->getLevel());
	}

	public function render()
	{
		$buf = null;

		foreach($this->nodes() as $i => $node) {
			$this->_position = $i;
			if($this->valid()) {	
				$content = array();
				$content[] = $this->renderNode();
				$content[] = $this->renderChildren();
				$buf .= $this->wrap(array_filter($content), 'li');		
			}
		}

		return (string) $buf;
	}

	public function renderNode()
	{
		if(isset($this->_options['link_closure'])) {
			return $this->_options['link_closure']($this->current()); 
		}
		return trim($this->current()->title);
	}

	public function renderChildren()
	{
		$children = (string) self::create($this->getChildren(), $this->_options, $this->_attributes, $this->_level + 1);
		
		if(!empty($children)) {
			return $this->wrap($children, 'ul');
		}

		return null;
	}

	public function rewind()
	{
	 	return $this->nodes()->getIterator()->rewind();
	}

	public function __toString()
	{
		return (string) $this->render();
	}

	public function wrap($content, $element, $attributes = array(), $open = "<%s%s>", $close = "</%s>")
	{
		if(is_array($content)) {
			$content = (string) implode("\r",array_filter($content));
		}

		if(!empty($attributes)) {
			$attributes = ' '. http_build_query($attributes, '', ' ');
		} else {
			$attributes = null;
		}

		return (string) sprintf($open, $element, $attributes).$content.sprintf($close, $element);
	}
}