<?php

namespace Starred\Http\Controllers;

use Starred\Jobs\SyncRepos;
use Illuminate\Support\Facades\Auth;

class SyncController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();

        if (count($user->jobs()) === 0) {
            $job = new SyncRepos($user);
            $user->attachJob($this->dispatch($job));
        }

        return redirect('/#/repositories');
    }

    /**
     * @return array
     */
    public function checkQueue()
    {
        $user = Auth::user();

        return [
            'queue' => count($user->jobs())
        ];
    }
}
