<?php

namespace Starred\Http\Controllers;

use Starred\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

/**
 * Class RepositoryController
 * @package Starred\Http\Controllers
 */
class RepositoryController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return Auth::user()->repositories()->orderBy('repository_user.starred_at', 'desc')->paginate();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $repo = Repository::find($id);
        $repo->tags = array_values($repo->tags(Auth::user()->id)->toArray());

        return $repo;
    }
}
