<?php

namespace Justinhilles\Cms\Menus;

abstract class ListRenderer implements \Iterator, ListRendererInterface {

	protected $attributes = array();
	protected $options = array();
	protected $nodes = array();
	protected $position = 0;
	protected $level = 0;

	public function __construct($nodes, array $options = array(), array $attributes = array(), $level = 0)
	{   
		//Set Options
		$this->mergeOptions($options);

		//Set Attributes
		$this->mergeAttributes($attributes);
		
		$this->nodes = $nodes;
		
		$this->attributes = (array) $attributes;
	}

	protected function mergeOptions($options)
	{
		$this->options = (array) array_merge($this->options, $options);
	}

	protected function mergeAttributes($attributes)
	{
		$this->attributes = (array) array_merge($this->attributes, $attributes);
	}

	protected function nodes()
	{
		return $this->nodes;
	}

	public function has($key) 
	{
		return isset($this->current()[$key]);
	}

	public function current($key = null) 
	{
		if(is_null($key)) {
			return current($this->nodes);
		}

		if(!is_null($key) AND $this->has($key)){
			return $this->current()[$key];
		}

		return null;
	}

	public function rewind()
	{
		return reset($this->nodes);
	}

	public function key()
	{
		return key($this->nodes);
	}

	public function next() 
	{
		return next($this->nodes);
	}
	public function valid() 
	{
		return !is_null(key($this->nodes));
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