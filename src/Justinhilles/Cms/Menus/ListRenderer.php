<?php

abstract class ListRenderer implements Iterator, ListRendererInterface {

	protected $_attributes = array();
	protected $_options = array();
	protected $_nodes = array();
	protected $_position = 0;
	protected $_level = 0;

	public function __construct($nodes, array $options = array(), array $attributes = array(), $level = 0)
	{
		$this->mergeOptions($options);
		$this->mergeAttributes($attributes);
		$this->_nodes = $nodes;
		$this->_attributes = (array) $attributes;
	}

	protected function mergeOptions($options)
	{
		$this->_options = (array) array_merge($this->_options, $options);
	}

	protected function mergeAttributes($attributes)
	{
		$this->_attributes = (array) array_merge($this->_attributes, $attributes);
	}

	protected function nodes()
	{
		return $this->_nodes;
	}

	public function has($key) 
	{
		return isset($this->current()[$key]);
	}

	public function current($key = null) 
	{
		if(is_null($key)) {
			return current($this->_nodes);
		}

		if(!is_null($key) AND $this->has($key)){
			return $this->current()[$key];
		}

		return null;
	}

	public function rewind()
	{
		return reset($this->_nodes);
	}

	public function key()
	{
		return key($this->_nodes);
	}

	public function next() 
	{
		return next($this->_nodes);
	}
	public function valid() 
	{
		return !is_null(key($this->_nodes));
	}

	protected function wrap($content, $element, $attributes = array(), $open = "<%s%s>", $close = "</%s>")
	{
		if(is_array($content)) {
			$content = (string) implode("\r",array_filter($content));
		}

		foreach($attributes as $key => $value) {
			if(is_array($value)){
				$value = implode(' ', $value);
			}
			
			$attributes[$key] = $value;
		}

		if(!empty($attributes)) {
			$attributes = ' '. http_build_query($attributes, '', ' ');
		} else {
			$attributes = null;
		}

		return (string) sprintf($open, $element, $attributes).$content.sprintf($close, $element);
	}
}