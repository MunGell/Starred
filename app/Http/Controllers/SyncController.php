<?php

namespace Starred\Http\Controllers;

use Starred\Jobs\GithubSync;
use Illuminate\Support\Facades\Auth;

/**
 * Class SyncController
 * @package Starred\Http\Controllers
 */
class SyncController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user();

        if (count($user->jobs()) === 0) {
            $job = new GithubSync($user);
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
