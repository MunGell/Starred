<?php

namespace App\Http\Controllers;

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
        return Tag::find($id)->repositories()->paginate();
    }

}
