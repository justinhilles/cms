<?php 

namespace Justinhilles\Cms\Controllers;

use Justinhilles\Cms\Models\Page;
use Justinhilles\Admin\Controllers\BaseController;

class PagesController extends BaseController {

	public $layout = 'layouts.default';

	public $view = 'pages.show';

	public function show($path)
	{
		if(!$page = Page::wherepath($path)->first()) {
			throw new \NotFoundException;
		}

		if(!isset($this->view)) {
			$this->view = \Config::get('cms::front.view');
		}

		if(!empty($page->view)) {
			$this->view = $page->view;
		}

		if(!empty($page->forward_to)) {
			$forward_to = Page::find($page->forward_to);
			return \Redirect::to($page->path);
		}

		return \View::make($this->view, array('page' => $page));
	}
}