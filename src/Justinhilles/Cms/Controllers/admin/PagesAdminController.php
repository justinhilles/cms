<?php namespace Justinhilles\Cms\Controllers\Admin;

use Justinhilles\Admin\Controllers\Admin\AdminController;
use Justinhilles\Cms\Models\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;

class PagesAdminController extends AdminController {

    protected $views = 'cms::admin.pages';

    protected $route = 'admin.pages';


    public function __construct()
    {
        $this->repository = App::make('PageRepository');;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($template = 'cms::admin.pages.index', $max = 10)
    {
        $pages = $this->getRepository()->findTree()->paginate($max);

        return View::make($template, compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($template = 'cms::admin.pages.create')
    {
        return View::make($template);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Redirect
     */
    public function store()
    {
        $data = $this->getFormData(array('position'));

        if ($page = $this->getRepository()->store($data)) {   
            return Redirect::route('admin.pages.edit', $page->id);
        }

        return Redirect::route('admin.pages.create')
            ->with('message', 'There were validation errors.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, $template = 'cms::admin.pages.edit')
    {
        $page = $this->getRepository()->find($id);

        return View::make($template, compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $data = $this->getFormData(array('_method', 'position', 'menu_id'));

        if ($this->getRepository()->update($id, $data)) {
            return Redirect::route('admin.pages.edit', $id);
        }

        return Redirect::route('admin.pages.edit', $id)
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
        $this->getRepository()->find($id)->delete();

        return Redirect::route('admin.pages.index');
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getFormData($except = array())
    {
        return array_except(Input::all(), $except);
    }
}