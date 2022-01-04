<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccessTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAccessTest_fail()
    {
        $response = $this->get('/admin/home');

        $response->assertStatus(302);
    }

    public function testAccessTest_success()
    {
        $response = $this->withSession(['login_token' => 'hogehoge'])
                         ->get('/admin/home');

        $response->assertStatus(200);
    }
}
