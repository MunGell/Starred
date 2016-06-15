<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Repository;
use Starred\Tag;
use Starred\User;

class AuthenticatedJourneyTest extends TestCase
{
    use DatabaseMigrations;

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

        $this->actingAs($this->user);
    }

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
    public function repositoryApi()
    {
        $this->get(action('RepositoryController@index'))
            ->seeStatusCode(200);
        $this->get(action('RepositoryController@show', ['id' => $this->repositories[0]->id]))
            ->seeStatusCode(200);
    }

    /**
     * @test
     */
    public function syncApi()
    {
        $this->get(action('SyncController@index'))
            ->seeStatusCode(302);
        $this->get(action('SyncController@checkQueue'))
            ->seeStatusCode(200)
            ->see('queue');
    }

    /**
     * @test
     */
    public function tagsApi()
    {
        $this->get(action('TagController@index'))
            ->seeStatusCode(200);
        $this->get(action('TagController@show', ['id' => $this->tags[0]->id]))
            ->seeStatusCode(200);
        $this->post(action('TagController@store', [
            'title' => 'testTag',
            'repository_id' => $this->repositories[0]->id
        ]))->seeStatusCode(200);
        $this->delete(action('TagController@destroy', [
            'tag_id' => $this->tags[1]->id,
            'repository_id' => $this->repositories[0]->id
        ]))->seeStatusCode(200);
    }
}
