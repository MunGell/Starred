<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Repository;
use Starred\Tag;
use Starred\User;

class RepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @covers Starred\Repository::users
     */
    public function users()
    {
        $repository = factory(Repository::class)->create();
        $users = factory(User::class, 3)->create();

        foreach ($users as $user) {
            $repository->users()->attach($user);
        }

        $this->assertInstanceOf('Starred\\User', $repository->users()->getResults()->first());
        $this->assertEquals($repository->users()->first()->id, $users[0]->id);
    }

    /**
     * @test
     * @covers Starred\Repository::allTags
     */
    public function allTags()
    {
        $repository = factory(Repository::class)->create();
        $tags = factory(Tag::class, 3)->create();

        foreach ($tags as $tag) {
            $repository->allTags()->attach($tag);
        }

        $this->assertInstanceOf('Starred\\Tag', $repository->allTags()->getResults()->first());
        $this->assertEquals($repository->allTags()->first()->id, $tags[0]->id);
    }

    /**
     * @test
     * @covers Starred\Repository::tags
     */
    public function tags()
    {
        $user = factory(User::class)->create();
        $repository = factory(Repository::class)->create();
        $tag = factory(Tag::class)->create();

        $repository->users()->attach($user);
        $repository->allTags()->attach($tag);

        $this->assertEquals($repository->tags($user->id)->first()->id, $tag->id);
    }
}
