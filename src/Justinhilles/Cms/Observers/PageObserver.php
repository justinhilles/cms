<?php namespace Justinhilles\Cms\Observers;

use Illuminate\Support\Facades\Input;

class PageObserver {

	public function saved($page)
	{
		if(Input::has('position')) {
			$position = Input::get('position');

			if(!empty($position['node_id']) && !empty($position['method'])) {
				$page->doMove($position['node_id'], $position['method']);
			}
		}elseif(is_null(Page::root())) {
			$page->makeRoot();
		}

		if(empty($page->path) && !$page->isRoot()) {
			$page->makePath();
		}
		
	}

	public function moving($page)
	{
		$page->makePath();
	}
}