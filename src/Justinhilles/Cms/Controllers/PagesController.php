<?php namespace Justinhilles\Cms\Controllers;

use Justinhilles\Cms\Models\Page;
use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\View;

class PagesController extends Controller {

	public $layout = "cms::layouts.default";

	public function show($path)
	{
		if(!$page = Page::where('path', '=', $path)->first()) {
			throw new NotFoundException;
		}

		if(!empty($page->view)) {
			$this->view = $page->view;
		}

		return View::make('cms::pages.show', array('page' => $page));
	}
}