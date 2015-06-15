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
        $repos = \Auth::user()->repositories()->orderBy('repository_user.starred_at', 'desc')->paginate();

        return view('repositories.list', ['repos' => $repos, 'title' => 'Repositories']);
    }

    public function show($id)
    {
        $repo = Repository::find($id);
        $tags = $repo->tags(Auth::user()->id);

        return view('repositories.show', ['repo' => $repo, 'tags' => $tags]);
    }

    public function addTag($id)
    {
        $title = Input::get('title');
        $tag = Tag::findOrCreate($title);

        if (!in_array($id, $tag->repositories()->getRelatedIds())) {
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

        return 'true';
    }
}
