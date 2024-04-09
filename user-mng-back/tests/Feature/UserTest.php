<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * User tries to login but inputs the credentials wrong
     */
    public function test_user_fails_to_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'manager@test.com',
            'password' => 'wrong1235'
        ]);
        $response -> assertStatus(403);
    }

    /**
     * User tries to login and logins successfully
     */
    public function test_user_succeeds_to_login(): void
    {
        $response = $this -> post('/login', [
            'email' => 'manager@test.com',
            'password' => 'test12345'
        ]);
        $response -> assertStatus(200);
    }
}
