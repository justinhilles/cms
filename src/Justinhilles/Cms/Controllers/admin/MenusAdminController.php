<?php

use Justinhilles\Cms\Models\Menu;

class MenusAdminController extends AdminController {

    protected $layout = 'admin.layouts.default';

    protected $views = 'cms::admin.menus';
    /**
     * Menus Repository
     *
     * @var Menus
     */
    protected $menus;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $menus = $this->menu->paginate('10');

        return View::make($this->view('index'), compact('menus'));
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
        $input = Input::all();
        $validation = Validator::make($input, Menu::$rules);

        if ($validation->passes())
        {
            $this->menu->create($input);

            return Redirect::route('admin.menus.index');
        }

        return Redirect::route('admin.menus.create')
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
        $menu = $this->menu->find($id);
        if (is_null($menu))
        {
            return Redirect::route('admin.menus.index');
        }

        return View::make($this->view('edit'), compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Menu::$rules);

        if ($validation->passes())
        {
            $menus = $this->menu->find($id);
            $menus->update($input);

            return Redirect::route('admin.menus.edit', $id);
        }

        return Redirect::route('admin.menus.edit', $id)
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
        $this->menu->find($id)->delete();

        return Redirect::route('admin.menus.index');
    }

}