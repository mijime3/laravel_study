<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTaskTest extends TestCase
{
    use DatabaseMigrations;

    public function test_task_all()
    {
        DB::table('tasks')->insert([
            ['name'=>'111', 'created_at'=>'2016-05-11 00:00:00', 'updated_at'=>'2016-05-11 00:00:10'],
            ['name'=>'222', 'created_at'=>'2016-05-11 00:00:01', 'updated_at'=>'2016-05-11 00:00:11'],
            ['name'=>'333', 'created_at'=>'2016-05-11 00:00:02', 'updated_at'=>'2016-05-11 00:00:12'],
            ['name'=>'444', 'created_at'=>'2016-05-11 00:00:03', 'updated_at'=>'2016-05-11 00:00:13'],
        ]);

        $response = $this->call('GET', '/api/tasks');
        $api_response = json_decode($response->getContent(), true);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($api_response, [
            'result' => true,
            'data' => [
                ['id' => 4, 'name'=>'444', 'created_at'=>'2016-05-11 00:00:03', 'updated_at'=>'2016-05-11 00:00:13'],
                ['id' => 3, 'name'=>'333', 'created_at'=>'2016-05-11 00:00:02', 'updated_at'=>'2016-05-11 00:00:12'],
                ['id' => 2, 'name'=>'222', 'created_at'=>'2016-05-11 00:00:01', 'updated_at'=>'2016-05-11 00:00:11'],
                ['id' => 1, 'name'=>'111', 'created_at'=>'2016-05-11 00:00:00', 'updated_at'=>'2016-05-11 00:00:10'],
            ]
        ]);
    }

    public function test_task_limit()
    {
        DB::table('tasks')->insert([
            ['name'=>'111', 'created_at'=>'2016-05-11 00:00:00', 'updated_at'=>'2016-05-11 00:00:10'],
            ['name'=>'222', 'created_at'=>'2016-05-11 00:00:01', 'updated_at'=>'2016-05-11 00:00:11'],
            ['name'=>'333', 'created_at'=>'2016-05-11 00:00:02', 'updated_at'=>'2016-05-11 00:00:12'],
            ['name'=>'444', 'created_at'=>'2016-05-11 00:00:03', 'updated_at'=>'2016-05-11 00:00:13'],
        ]);

        $response = $this->call('GET', '/api/tasks?limit=2');
        $api_response = json_decode($response->getContent(), true);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($api_response, [
            'result' => true,
            'data' => [
                ['id' => 4, 'name'=>'444', 'created_at'=>'2016-05-11 00:00:03', 'updated_at'=>'2016-05-11 00:00:13'],
                ['id' => 3, 'name'=>'333', 'created_at'=>'2016-05-11 00:00:02', 'updated_at'=>'2016-05-11 00:00:12'],
            ]
        ]);
    }

    /**
     * @dataProvider limitErrorParamsProvider
     */
    public function test_task_limit_error($limit)
    {
        $response = $this->call('GET', '/api/tasks?limit='.$limit);
        $api_response = json_decode($response->getContent(), true);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals($api_response, [
            'result' => false,
            'error' => '"limit" parameter is invalid.',
        ]);
    }

    public function limitErrorParamsProvider()
    {
        return [
            [0],
            [-1],
            ['aaa'],
        ];
    }
}
