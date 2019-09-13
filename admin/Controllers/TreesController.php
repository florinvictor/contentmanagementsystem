<?php

namespace Admin\Controllers;

use Common\File;
use Common\Controller;
use Common\Models\Tree;
use \Exception;

class TreesController extends Controller
{
    protected static $auth_methods = [
        'index',
        'create',
        'edit',
        'store',
        'update',
        'destroy'
    ];

    protected function index()
    {
        $trees = Tree::get();
        $tree = isset($trees[0]) ? $trees[0] : [];

        return view('admin/trees/index', compact('trees', 'tree'));
    }

    protected function create()
    {
        return view('admin/trees/create');
    }

    protected function edit($id)
    {
        $tree = Tree::find($id);

        return view('admin/trees/edit', compact('tree'));
    }

    protected function store()
    {
        $picture_location = File::storeImage('picture');

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':has_fruits' => request('has_fruits'),
            ':has_flowers' => request('has_flowers'),
            ':introduction' => request('introduction'),
            ':description' => request('description'),
            ':fruit_title' => request('fruit_title'),
            ':colour' => request('colour'),
            ':growth_location' => request('growth_location'),
            ':ripe_season' => request('ripe_season'),
            ':average_years' => request('average_years'),
            ':average_height' => request('average_height'),
            ':average_width' => request('average_width'),
            ':user_id' => $_SESSION['user']['id']
        ];

        if (file_error_ok('picture')) {
            $data[':picture'] = $picture_location;
        }

        try {
            Tree::store($data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }

    protected function update()
    {
        $picture_location = File::storeImage('picture');

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':has_fruits' => request('has_fruits'),
            ':has_flowers' => request('has_flowers'),
            ':introduction' => request('introduction'),
            ':description' => request('description'),
            ':fruit_title' => request('fruit_title'),
            ':colour' => request('colour'),
            ':growth_location' => request('growth_location'),
            ':ripe_season' => request('ripe_season'),
            ':average_years' => request('average_years'),
            ':average_height' => request('average_height'),
            ':average_width' => request('average_width'),
            ':user_id' => $_SESSION['user']['id']
        ];

        if (file_error_ok('picture')) {
            $data[':picture'] = $picture_location;
        }

        try {
            Tree::update((int) request('tree_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }

    protected function destroy(int $id)
    {
        try {
            Tree::destroy($id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }
}
