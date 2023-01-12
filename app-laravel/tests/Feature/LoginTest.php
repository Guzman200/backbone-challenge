<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_login()
    {
        $data = [
            'email' => 'admin@wisat.com',
            'password' => 'wisat2022@',
            'device_name' => 'Testing APP'
        ];

        $response = $this->postJson('/api/v1/auth/login', $data);

        $response->assertStatus(200);
    }

    public function test_user_can_login_email_incorrect()
    {
        $data = [
            'email' => 'incorrect@wisat.com',
            'password' => 'wisat2022@',
            'device_name' => 'Testing APP'
        ];

        $response = $this->postJson('/api/v1/auth/login', $data);

        $response->assertStatus(401);
    }

    public function test_user_can_login_without_data()
    {
        $data = [];

        $response = $this->postJson('/api/v1/auth/login', $data);

        $response->assertStatus(422);
    }
}
