<?php
namespace Justinhilles\Cms\Models;

use Baum\Node;

/**
* Page
*/
class Page extends Node {

    protected $guarded = array('id', 'lft', 'rgt', 'depth');

    public static $rules = array(
        'title' => 'Required',
    );

    public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
        'unique' => false
    );

    protected $table = 'pages';

    public function menus()
    {
        return $this->belongsToMany('Menu', 'menus_pages');
    }

    public function tree()
    {
      return $this->orderby('lft');
    }

    public function getNestedTitle($sep = " - ")
    {
      return str_repeat($sep, abs($this->getLevel())).$this -> title;
    }

    public function isPublished()
    {
      return $this->status == 'published';
    }

    public function doPath($between = "/", $pages = array())
    { 
      if($this->isRoot())
      {
        $path = "";
      }
      else
      {
        $page = $this;

        while($parent = Page::find($page->getParentId()))
        {
          if(!$parent->isRoot())
          {
            $pages[] = (string) $parent->slug;
          }
          $page = $parent;
        }
        
        $pages[] = $this->slug;

        $path = implode($between, $pages);

      }
      return $path;      
    }

    public function doPathUnique($separator ="-", $first = 1)
    {
      $path = $this->path;
      $paths = $this->whereRaw("path REGEXP '^{$path}(-[0-9]*)?$'")->orderBy('path','desc')->lists('path');
      $count = count($paths);
      if($count > 0) {
          preg_match('/(.+)'.$separator.'([0-9]+)$/', $paths[0], $match);

          $path = isset($match[2]) ? $match[1].$separator.$count : $path.$separator.$first;
      } 
      return $path;
    }

    public function doMove($page_id, $method)
    {
        if(method_exists($this, $method) AND $scope_page = self::find($page_id)) {
            $this->$method($scope_page);
        }
    }

    public function makePath()
    {
      $this->path = (string) $this->doPath();
      $this->path = (string) $this->doPathUnique();
      $this->save();      
    }
}