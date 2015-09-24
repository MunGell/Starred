<?php namespace App\Http\Controllers;

use App\Jobs\SyncRepos;


class SyncController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        $job = new SyncRepos($user);
        $this->dispatch($job);

        return redirect('/#/repositories');
    }

}
