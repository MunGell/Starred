<?php

namespace Starred\Contracts\Http\Controllers;

/**
 * Interface RestControllerInterface
 * @package Starred\Contracts\Http\Controllers
 */
interface RestControllerInterface
{
    /**
     * Show list of all items
     * @return mixed
     */
    public function index();

    /**
     * Show creation form
     * @return mixed
     */
    public function create();

    /**
     * Save new item to storage
     * @return mixed
     */
    public function store();

    /**
     * Show single item
     * @param $model
     *
     * @return mixed
     */
    public function show($model);

    /**
     * Show edit form
     * @param $model
     *
     * @return mixed
     */
    public function edit($model);

    /**
     * Save new version of item to storage
     * @return mixed
     */
    public function update();

    /**
     * Show deletion page
     * @param $model
     *
     * @return mixed
     */
    public function delete($model);

    /**
     * Remove item from storage
     * @return mixed
     */
    public function destroy();
}
