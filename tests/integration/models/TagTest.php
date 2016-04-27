<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Repository;
use Starred\Tag;

class TagTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @covers Starred\Tag::repositories
     */
    public function repositories()
    {
        $tag = factory(Tag::class)->create();
        $repositories = factory(Repository::class, 3)->create();

        foreach ($repositories as $repository) {
            $tag->repositories()->attach($repository);
        }

        $this->assertInstanceOf('Starred\\Repository', $tag->repositories()->first());
        $this->assertEquals($tag->repositories()->first()->id, $repositories[0]->id);
    }

    /**
     * @test
     * @covers Starred\Tag::findOrCreate
     */
    public function findOrCreate()
    {
        $tagTitle = 'test-tag';

        $tag = Tag::findOrCreate($tagTitle);
        $sameTag = Tag::findOrCreate($tagTitle);

        $this->assertInstanceOf('Starred\\Tag', $tag);
        $this->assertEquals($tagTitle, $tag->title);

        $this->assertEquals($sameTag->id, $tag->id);
    }
}
