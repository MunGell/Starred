<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Starred\Token;
use Starred\User;

class TokenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @covers Starred\Token::user
     */
    public function user()
    {
        $token = factory(Token::class)->create();
        $user = factory(User::class)->create();

        $token->user()->associate($user);

        $this->assertInstanceOf('Starred\\User', $token->user()->getResults());
        $this->assertEquals($user->id, $token->user()->getResults()->id);
    }
}
