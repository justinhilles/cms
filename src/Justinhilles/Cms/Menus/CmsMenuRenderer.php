<?php 

namespace Justinhilles\Cms\Menus;

use Menu\Menu as BaseMenu;

class CmsMenuRenderer extends ListRenderer
{

    protected $handler;
    protected $slug = null;

    public function __construct($slug = null, array $nodes = array())
    {
        $this->handler = !is_null($slug) 
                    ? BaseMenu::handler($slug) 
                    : BaseMenu::items();

        parent::__construct($nodes);

        $this->process();
    }

    public static function create($slug = null, $nodes = array())
    {
        $menu = \Justinhilles\Cms\Models\Menu::whereslug($slug)->first();

        if (is_object($menu) ){
            $nodes = json_decode($menu->nodes, true);
        }

        return new self($slug, $nodes);
    }

    public function getPath()
    {
        return $this->current('path');
    }

    public function getTitle()
    {
        return $this->current('title');
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
        return array();
    }

    public function getItemAttributes()
    {
        return array();
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
                $this->getTitle(),
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



    public function __toString()
    {
        return (string) $this->handler;
    }
}