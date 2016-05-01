<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Starred\User;

class SyncApiTest extends TestCase
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
    }

    /**
     * @test
     */
    public function getIndex()
    {
        $this->notSeeInDatabase('user_job', [
            'user_id' => $this->user->id
        ]);
        $this->call('GET', action('SyncController@index'));
        $this->assertRedirectedTo('/#/repositories');
        $this->seeInDatabase('user_job', [
            'user_id' => $this->user->id
        ]);
    }

    /**
     * @test
     */
    public function getCheckQueue()
    {
        $response = $this->call('GET', action('SyncController@checkQueue'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('queue', $json);
        $this->assertEquals(0, $json->queue);

        DB::table('jobs')->insert([
            'id' => 1,
            'queue' => 'default',
            'payload' => 'json',
            'attempts' => 0,
            'reserved' => 0,
            'reserved_at' => null,
            'available_at' => 1461796672,
            'created_at' => 1461796672,
        ]);
        DB::table('user_job')->insert([
            'user_id' => 10,
            'job_id' => 1
        ]);

        $response = $this->call('GET', action('SyncController@checkQueue'));
        $json = json_decode($response->getContent());

        $this->assertObjectHasAttribute('queue', $json);
        $this->assertEquals(1, $json->queue);
    }
}
