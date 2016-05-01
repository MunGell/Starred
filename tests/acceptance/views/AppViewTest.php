<?php

class AppViewTest extends TestCase
{
    /**
     * @test
     */
    public function getIndex()
    {
        $this->visit('/')->seeElement('#app');
    }
}
