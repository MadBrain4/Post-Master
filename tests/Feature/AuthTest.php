<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_set_database_config (): void
    {
        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('db:seed');

        $this->assertTrue(true);
    }

    public function test_register_user(): void
    {
        $user = [
            'name' => 'Sally',
            'email' => 'sally@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson('/api/register', $user);
        
        $response->assertStatus(201);
        $response->assertJsonIsObject();
        $response->assertJsonStructure([
            'data', 'success', 'message'
        ]);
        $response->assertExactJson([
            'data' => [
                'id' => 51,
                'name' => 'Sally',
                'email' => 'sally@gmail.com'
            ],
            'success' => true,  
            'message' => 'User created successfully' 
        ]);
    }

    public function test_login_user () : void 
    {
        $user = [
            'email' => 'sally@gmail.com',
            'password' => 'password'
        ];

        $response = $this->postJson('/api/login', $user);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonStructure([
            'data', 'success', 'message', 'access_token'
        ]);
    }
}
