<?php

namespace Starred\Http\Controllers;

/**
 * Class AppController
 * @package Starred\Http\Controllers
 */
class AppController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('app');
    }
}
