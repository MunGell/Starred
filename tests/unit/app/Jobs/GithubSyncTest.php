<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Jobs\GithubSync;
use Starred\User;

class GithubSyncTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Starred\Jobs\GithubSync
     */
    protected $githubSync;

    public function setUp()
    {
        parent::setUp();

        $user = new User([
            'id' => 10,
            'login' => 'TestAccount',
            'avatar' => 'http://ya.ru'
        ]);
        $user->token()->create(['id' => 10, 'token' => 'hello']);
        $this->githubSync = new GithubSync($user);
    }

    /**
     * @test
     * @covers Starred\Jobs\GithubSync
     */
    public function getClient()
    {
        $method = new ReflectionMethod('Starred\Jobs\GithubSync', 'getClient');
        $method->setAccessible(true);
        $client = $method->invoke($this->githubSync);

        $this->assertInstanceOf('\\Github\\Client', $client);
    }
}
