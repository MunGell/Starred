<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Repository;
use Starred\Tag;
use Starred\User;

class RepositoryApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * @var array
     */
    protected $repositories;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $tags;

    public function setUp()
    {
        parent::setUp();

        $this->repositories = factory(Repository::class, 10)->create();
        $this->tags = factory(Tag::class, 5)->create()->sortBy('title');

        $this->user = User::create([
            'id' => 10,
            'login' => 'testuser',
            'avatar' => 'http://ya.com'
        ]);

        $this->be($this->user);

        foreach ($this->repositories as $repository) {
            $this->user->repositories()->attach($repository);
        }

        foreach ($this->tags as $tag) {
            $this->repositories[0]->allTags()->attach($tag);
        }
    }

    /**
     * @test
     */
    public function getIndex()
    {
        $response = $this->call('GET', action('RepositoryController@index'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('total', $json);
        $this->assertEquals(10, $json->total);
        $this->assertObjectHasAttribute('per_page', $json);
        $this->assertObjectHasAttribute('last_page', $json);
        $this->assertObjectHasAttribute('next_page_url', $json);
        $this->assertObjectHasAttribute('prev_page_url', $json);
        $this->assertObjectHasAttribute('from', $json);
        $this->assertObjectHasAttribute('to', $json);
        $this->assertObjectHasAttribute('data', $json);
        $this->assertCount(10, $json->data);

        $this->assertEquals(array_pluck($this->repositories, 'id'), array_pluck($json->data, 'id'));

        foreach ($json->data as $r) {
            $this->assertObjectHasAttribute('id', $r);
            $this->assertObjectHasAttribute('name', $r);
            $this->assertObjectHasAttribute('full_name', $r);
            $this->assertObjectHasAttribute('url', $r);
            $this->assertObjectHasAttribute('description', $r);
            $this->assertObjectHasAttribute('pivot', $r);
            $this->assertObjectHasAttribute('user_id', $r->pivot);
            $this->assertObjectHasAttribute('repository_id', $r->pivot);
            $this->assertUrl($r->url);
        }
    }

    /**
     * @test
     */
    public function getOne()
    {
        $response = $this->call('GET', action('RepositoryController@show', $this->repositories[0]->id));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('id', $json);
        $this->assertObjectHasAttribute('name', $json);
        $this->assertObjectHasAttribute('full_name', $json);
        $this->assertObjectHasAttribute('url', $json);
        $this->assertObjectHasAttribute('description', $json);
        $this->assertObjectHasAttribute('tags', $json);
        $this->assertUrl($json->url);

        $this->assertCount(5, $json->tags);

        $this->assertEquals(array_pluck($this->tags, 'id'), array_pluck($json->tags, 'id'));

        foreach ($json->tags as $t) {
            $this->assertObjectHasAttribute('id', $t);
            $this->assertObjectHasAttribute('title', $t);
        }
    }
}
