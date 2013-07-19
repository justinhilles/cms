<?php

use Justinhilles\Cms\Models\Page;

class PagesController extends BaseController {

	public $layout = "cms::layouts.default";

	public $view = 'pages.show';

	public function show($path)
	{
		if(!$page = Page::where('path', '=', $path)->first()) {
			throw new NotFoundException;
		}

		if(!empty($page->view)) {
			$this->view = $page->view;
		}

		return View::make($this->view, array('page' => $page));
	}
}