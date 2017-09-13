<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestApplication extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample1()
    {
        $response = $this->call('GET', '/posts');
        $this->assertEquals(200, $response->status());
    }

    public function testExample2()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /*test api*/
    public function testExample3()
    {
        $response = $this->json('GET', '/api/get/posts');
        $response->assertStatus(200)
            ->assertJson([
                'posts' => true,
            ]);
    }
}
