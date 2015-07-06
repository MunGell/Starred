<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($keyword = '')
    {
        $user = Auth::user();
        $tags = new Paginator($user->searchTags($keyword, Paginator::resolveCurrentPage()), $user->getPerPage());
        $repositories = new Paginator($user->searchRepositories($keyword, Paginator::resolveCurrentPage()), $user->getPerPage());

        if (strlen($keyword) > 1) {
            return [
                'tags' => $tags->toArray(),
                'repositories' => $repositories->toArray()
            ];
        }

        return [
            'tags' => [],
            'repositories' => []
        ];
    }

}
