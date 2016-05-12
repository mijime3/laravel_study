<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HelloTest extends TestCase
{
    public function test_hello_world()
    {
        $this->visit('/hello')
            ->see('Hello world!');
    }

    public function test_hello_world_2()
    {
        $response = $this->call('GET', '/hello');

        $this->assertEquals(200, $response->status());
        $this->assertContains('Hello world!', $response->getContent());
    }
}
