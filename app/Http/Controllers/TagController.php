<?php namespace App\Http\Controllers;


use App\Tag;
use Auth;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Auth::user()->tags();
    }

    public function show($id)
    {
        $tag = Tag::find($id);
        $repos = $tag->repositories()->getResults();

        return view('repositories.list', ['repos' => $repos, 'title' => 'Tag ' . $tag->title]);
    }

}
