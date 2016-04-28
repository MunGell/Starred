<?php

namespace Starred\Http\Controllers;

use Starred\Repository;
use Starred\Tag;
use \Auth;
use \Input;

/**
 * Class RepositoryController
 * @package Starred\Http\Controllers
 */
class RepositoryController extends Controller
{
    /**
     * RepositoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    /**
     * @param $id
     *
     * @todo: move to tags controller
     * @return array|\Illuminate\Database\Eloquent\Model|null
     */
    public function addTag($id)
    {
        $title = Input::get('title');
        $tag = Tag::findOrCreate($title);

        if (!$tag->repositories()->getRelatedIds()->contains($id)) {
            $tag->repositories()->attach($id);
            $tag = [$tag];
        } else {
            $tag = [];
        }

        return $tag;
    }

    /**
     * @param $id
     *
     * @todo: move to tags controller
     * @return array
     */
    public function removeTag($id)
    {
        $tag_id = Input::get('tag');
        $tag = Tag::find($tag_id);

        $tag->repositories()->detach($id);

        return [
            'id' => $tag_id,
            'removed' => true
        ];
    }
}
