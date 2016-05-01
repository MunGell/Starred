<?php

namespace Starred\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{
    /**
     * @param string $keyword
     *
     * @todo: makes no sense, optimise performance
     * @return array
     */
    public function index($keyword = '')
    {
        $user = Auth::user();
        $tags = $user->searchTags($keyword);
        $repositories = new Paginator($user->searchRepositories($keyword, Paginator::resolveCurrentPage()),
            $user->getPerPage());

        if (strlen($keyword) > 1) {
            return [
                'tags' => $tags,
                'repositories' => $repositories->toArray()
            ];
        }

        return [
            'tags' => [],
            'repositories' => []
        ];
    }
}
