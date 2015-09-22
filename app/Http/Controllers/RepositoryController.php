<?php namespace App\Http\Controllers;

use App\Repository;
use App\Tag;
use \Auth;
use \Input;

class RepositoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Auth::user()->repositories()->orderBy('repository_user.starred_at', 'desc')->paginate();
    }

    public function show($id)
    {
        $repo = Repository::find($id);
        $repo->tags = array_values($repo->tags(Auth::user()->id)->toArray());

        return $repo;
    }

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
