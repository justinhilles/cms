<?php namespace Justinhilles\Cms\Controllers\Admin;

use Justinhilles\Admin\Controllers\Admin\AdminController;
use Justinhilles\Cms\Models\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class PagesAdminController extends AdminController {

    protected $views = 'cms::admin.pages';

    protected $route = 'admin.pages';
    /**
     * Page Repository
     *
     * @var Page
     */
    protected $page;

    public function __construct(Page $page)
    {
        $this->max = Config::get('cms::config.admin.per_page');
        
        parent::__construct($page);

        $this->page = $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = $this->page->tree()->paginate($this->max);

        return View::make($this->view('index'), compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make($this->view('create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = array_except(Input::all(), 'position');
        $validation = Validator::make($input, Page::$rules);

        if ($validation->passes()) {   
            $page = $this->page->create($input);

            return Redirect::route('admin.pages.edit', $page->id);
        }

        return Redirect::route('admin.pages.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->page->find($id);

        if (is_null($page)) {
            return Redirect::route('admin.pages.index');
        }

        return View::make($this->view('edit'), compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), array('_method', 'position', 'menu_id'));
        $validation = Validator::make($input, Page::$rules);

        if ($validation->passes()) {
            $page = $this->page->find($id);
            $page->update($input);

            return Redirect::route('admin.pages.edit', array($page->id));
        }

        return Redirect::route('admin.pages.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->page->find($id)->delete();

        return Redirect::route('admin.pages.index');
    }

}