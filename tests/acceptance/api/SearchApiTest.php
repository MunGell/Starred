<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Repository;
use Starred\Tag;
use Starred\User;

class SearchApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = User::create([
            'id' => 10,
            'login' => 'testuser',
            'avatar' => 'http://ya.com'
        ]);
        $this->be($this->user);

        $repository = Repository::create([
            'id' => 1000,
            'name' => 'Tango Foxtrot',
            'full_name' => 'Wisky Tango Foxtrot',
            'url' => 'http://yandex.ru',
            'description' => 'New way of coding',
        ]);

        $this->user->repositories()->attach($repository);

        $tag1 = Tag::create([
            'title' => 'Fox Google'
        ]);
        $tag2 = Tag::create([
            'title' => 'Gone wild'
        ]);

        $repository->allTags()->attach($tag1);
        $repository->allTags()->attach($tag2);

    }

    /**
     * @test
     */
    public function getIndex()
    {
        $response = $this->call('GET', action('SearchController@index', 'go'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('tags', $json);
        $this->assertObjectHasAttribute('repositories', $json);

        $this->assertCount(2, $json->tags);

        $this->assertObjectHasAttribute('data', $json->repositories);
        $this->assertCount(1, $json->repositories->data);

        $response = $this->call('GET', action('SearchController@index', 'Terra Incognito'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('tags', $json);
        $this->assertObjectHasAttribute('repositories', $json);
        $this->assertCount(0, $json->tags);
        $this->assertCount(0, $json->repositories->data);


        $response = $this->call('GET', action('SearchController@index', '1'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('tags', $json);
        $this->assertObjectHasAttribute('repositories', $json);
        $this->assertCount(0, $json->tags);
        $this->assertCount(0, $json->repositories);
    }
}
