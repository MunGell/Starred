<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Repository;
use Starred\Tag;
use Starred\User;

class TagApiTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * @const number of entities
     */
    const COUNT = 5;

    /**
     * @var array
     */
    protected $repository;

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

        $this->repository = factory(Repository::class)->create();
        $this->tags = factory(Tag::class, self::COUNT)->create()->sortBy('title');

        $this->user = User::create([
            'id' => 10,
            'login' => 'testuser',
            'avatar' => 'http://ya.com'
        ]);

        $this->be($this->user);

        $this->user->repositories()->attach($this->repository);

        foreach ($this->tags as $tag) {
            $this->repository->allTags()->attach($tag);
        }
    }

    /**
     * @test
     */
    public function getIndex()
    {
        $response = $this->call('GET', action('TagController@index'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('total', $json);
        $this->assertEquals(self::COUNT, $json->total);
        $this->assertObjectHasAttribute('per_page', $json);
        $this->assertObjectHasAttribute('last_page', $json);
        $this->assertObjectHasAttribute('next_page_url', $json);
        $this->assertObjectHasAttribute('prev_page_url', $json);
        $this->assertObjectHasAttribute('from', $json);
        $this->assertObjectHasAttribute('to', $json);
        $this->assertObjectHasAttribute('data', $json);
        $this->assertCount(self::COUNT, $json->data);

        $this->assertEquals(array_pluck($this->tags, 'id'), array_pluck($json->data, 'id'));

        foreach ($json->data as $t) {
            $this->assertObjectHasAttribute('id', $t);
            $this->assertObjectHasAttribute('title', $t);
        }
    }

    /**
     * @test
     */
    public function getShow()
    {
        $response = $this->call('GET', action('TagController@show', $this->tags[0]->id));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('total', $json);
        $this->assertEquals(1, $json->total);
        $this->assertObjectHasAttribute('per_page', $json);
        $this->assertObjectHasAttribute('last_page', $json);
        $this->assertObjectHasAttribute('next_page_url', $json);
        $this->assertObjectHasAttribute('prev_page_url', $json);
        $this->assertObjectHasAttribute('from', $json);
        $this->assertObjectHasAttribute('to', $json);
        $this->assertObjectHasAttribute('data', $json);
        $this->assertCount(1, $json->data);

        $this->assertEquals($this->repository->id, $json->data[0]->id);

        foreach ($json->data as $r) {
            $this->assertObjectHasAttribute('id', $r);
            $this->assertObjectHasAttribute('name', $r);
            $this->assertObjectHasAttribute('full_name', $r);
            $this->assertObjectHasAttribute('url', $r);
            $this->assertObjectHasAttribute('description', $r);
            $this->assertObjectHasAttribute('pivot', $r);
            $this->assertUrl($r->url);
        }
    }

    /**
     * @test
     */
    public function postStore()
    {
        $response = $this->call('POST', action('TagController@store', $this->repository->id), [
            'title' => 'Testing Title'
        ]);
        $json = json_decode($response->getContent());

        $this->assertInternalType('array', $json);
        $this->assertCount(1, $json);

        foreach ($json as $t) {
            $this->assertObjectHasAttribute('id', $t);
            $this->assertObjectHasAttribute('title', $t);
        }

        $response = $this->call('POST', action('TagController@store', $this->repository->id),
            ['title' => 'Testing Title']);
        $json = json_decode($response->getContent());

        $this->assertInternalType('array', $json);
        $this->assertCount(0, $json);
    }

    /**
     * @test
     */
    public function deleteDestroy()
    {
        $response = $this->call('POST', action('TagController@destroy', $this->repository->id), [
            'tag' => $this->tags[0]->id
        ]);
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('id', $json);
        $this->assertObjectHasAttribute('removed', $json);
        $this->assertEquals($this->tags[0]->id, $json->id);
        $this->assertTrue($json->removed);
    }
}
