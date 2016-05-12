<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    public function test_index()
    {
        DB::table('tasks')->insert([
            ['name'=>'111', 'created_at'=>'2016-5-11 00:00:00'],
            ['name'=>'222', 'created_at'=>'2016-5-11 00:00:01'],
            ['name'=>'333', 'created_at'=>'2016-5-11 00:00:02'],
            ['name'=>'444', 'created_at'=>'2016-5-11 00:00:03'],
        ]);

        $response = $this->call('GET', '/');
        $content = $response->getContent();

        $this->visit('/')->seeInElement('.task-table tbody tr:nth-child(1) div', '111');
        $this->visit('/')->seeInElement('.task-table tbody tr:nth-child(2) div', '222');
        $this->visit('/')->seeInElement('.task-table tbody tr:nth-child(3) div', '333');
        $this->visit('/')->seeInElement('.task-table tbody tr:nth-child(4) div', '444');
    }
}
