<?php

namespace App\Http\Controllers;

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

        if (count($user->jobs()) === 0) {
            $job = new SyncRepos($user);
            $user->attachJob($this->dispatch($job));
        }

        return redirect('/#/repositories');
    }

    public function checkQueue()
    {
        $user = \Auth::user();

        return [
            'queue' => count($user->jobs())
        ];
    }

}
