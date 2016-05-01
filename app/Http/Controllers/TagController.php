<?php

namespace Starred\Http\Controllers;

use Starred\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class TagController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return Auth::user()->tags();
    }

    /**
     * @param $id
     *
     * @todo: add tag id and title to the output
     * @return mixed
     */
    public function show($id)
    {
        return Tag::find($id)->repositories()->paginate();
    }

    /**
     * @todo: change return type to object or 204
     * @return array|\Illuminate\Database\Eloquent\Model|null
     */
    public function store()
    {
        $title = Input::get('title');
        $repository_id = Input::get('repository_id');
        $tag = Tag::findOrCreate($title);

        if (!$tag->repositories()->getRelatedIds()->contains($repository_id)) {
            $tag->repositories()->attach($repository_id);
            $tag = [$tag];
        } else {
            $tag = [];
        }

        return $tag;
    }

    /**
     * @todo: refactor
     * @return array
     */
    public function destroy()
    {
        $tag_id = Input::get('tag_id');
        $repository_id = Input::get('repository_id');

        $tag = Tag::find($tag_id);

        $tag->repositories()->detach($repository_id);

        return [
            'id' => $tag_id,
            'removed' => true
        ];
    }

}
