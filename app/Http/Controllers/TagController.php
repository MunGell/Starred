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
     * @param $id
     *
     * @todo: change return type to object or 204
     * @return array|\Illuminate\Database\Eloquent\Model|null
     */
    public function store($id)
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
     * @todo: refactor
     * @return array
     */
    public function destroy($id)
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
