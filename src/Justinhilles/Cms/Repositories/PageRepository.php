<?php namespace Justinhilles\Cms\Repositories;

use Justinhilles\Cms\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageRepository 
{
    protected $table = 'pages';

    /**
     * Find the Full Tree
     * 
     * @param  integer $max [description]
     * 
     * @return [type]       [description]
     */
    public function findTree()
    {
        return Page::tree();
    }

    public function findAll()
    {
        $pages = Page::all();

        return $pages;
    }

    public function find($id)
    {
        $page = Page::find($id);

        if (!$page) {
            throw new NotFoundException('Post Not Found');
        }

        return $page;
    }

    public function store($data)
    {
        $this->validate($data);

        return Page::create($data);
    }

    public function update($id, $data)
    {
        $page = $this->find($id);

        $this->validate($data);

        $page->update($data);

        return $page;
    }

    public function validate($data)
    {
        $validator = Validator::make($data, Page::$rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        return true;
    }

    public function delete($id)
    {
        $page = $this->find($id);

        return $page->delete();
    }
}