<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class GuestJourneyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function landingPage()
    {
        $this->visit('/')
            ->seeStatusCode(200)
            ->seeElement('#app');
    }

    /**
     * @test
     */
    public function login()
    {
        $this->get(action('AuthController@getLogin'))
            ->seeStatusCode(302);
    }

    /**
     * @test
     */
    public function repositoryApi()
    {
        $this->get(action('RepositoryController@index'))
            ->assertRedirectedToAction('AuthController@getLogin');
        $this->get(action('RepositoryController@show', ['id' => 1000]))
            ->assertRedirectedToAction('AuthController@getLogin');
    }

    /**
     * @test
     */
    public function syncApi()
    {
        $this->get(action('SyncController@index'))
            ->assertRedirectedToAction('AuthController@getLogin');
        $this->get(action('SyncController@checkQueue'))
            ->assertRedirectedToAction('AuthController@getLogin');
    }

    /**
     * @test
     */
    public function tagsApi()
    {
        $this->get(action('TagController@index'))
            ->assertRedirectedToAction('AuthController@getLogin');
        $this->post(action('TagController@store'))
            ->assertRedirectedToAction('AuthController@getLogin');
        $this->delete(action('TagController@destroy'))
            ->assertRedirectedToAction('AuthController@getLogin');
        $this->get(action('TagController@show', ['id' => 1000]))
            ->assertRedirectedToAction('AuthController@getLogin');
    }
}
