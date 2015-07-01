<?php namespace App\Http\Controllers;

use App\Repository;
use App\Tag;
use Auth;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($keyword)
    {
        return [
            'tags' => Auth::user()->searchTags($keyword),
            'repositories' => Auth::user()->searchRepositories($keyword)
        ];
    }

}
