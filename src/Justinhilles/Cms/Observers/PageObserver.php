<?php namespace Justinhilles\Cms\Observers;

use Illuminate\Support\Facades\Input;

class PageObserver 
{
    public function saved($page)
    {
        if (Input::has('position')) {
            $position = Input::get('position');

            if (!empty($position['node_id']) AND !empty($position['method'])) {
                $page->doMove($position['node_id'], $position['method']);
            }

        } elseif (is_null(Page::root())) {
            $page->makeRoot();
        }

        if (empty($page->slug)) {
            \Sluggable::make($page, true);
            $page->path = null;
            $page->save();
        }

        if (empty($page->path) AND !$page->isRoot()) {
            $page->makePath();
        }

        $page->menus()->sync((array) Input::get('menu_id'));
    }

    public function moving($page)
    {
        $page->makePath();
    }
}