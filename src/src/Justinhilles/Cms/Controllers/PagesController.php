<?php 

namespace Justinhilles\Cms\Controllers;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

use Justinhilles\Cms\Models\Page;

class PagesController extends Controller {

	public $layout = "cms::layouts.default";

	public $view = 'pages.show';

	public function show($path)
	{
		if(!$page = Page::wherepath($path)->first()) {
			throw new NotFoundException;
		}

		if(!isset($this->view)) {
			$this->view = Config::get('cms::front.view');
		}

		if(!empty($page->view)) {
			$this->view = $page->view;
		}

		return View::make($this->view, array('page' => $page));
	}
}