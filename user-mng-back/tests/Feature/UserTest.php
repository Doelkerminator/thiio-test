<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

define('JWT', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJVc2VyIE1hbmFnZXIiLCJhdWQiOiJodHRwOi8vbG9jYWxob3N0IiwiaWF0IjoxNzEyODY4NDkyLCJzdWIiOm51bGwsImVtYWlsIjoiZHJ5ZHVkZUB0ZXN0LmNvbSIsImlkIjozLCJleHAiOjE3MTI4NzIwOTJ9.H9w7W4hYrBqCpyH9-cQCLpB_joryHl-g-kO2E31x8wI');

class UserTest extends TestCase
{


    // ? Login tests

    /**
     * User tries to login but inputs the credentials wrong
     */
    public function test_user_fails_to_login(): void
    {
        $response = $this->post('/api/login', [
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
        $response = $this -> post('/api/login', [
            'email' => 'manager@test.com',
            'password' => 'test12345'
        ]);
        $response -> assertStatus(200);
    }

    /**
     * User tries to login and receives his session token
     */
    public function test_user_succeeds_to_login_and_receives_token(): void
    {
        $response = $this -> post('/api/login', [
            'email' => 'manager@test.com',
            'password' => 'test12345'
        ]);
        $response -> assertJsonStructure([
            'jwt' 
        ]);
    }

    /**
     * User tries to logout from the session but token is not sent
     */
    public function test_logged_in_user_tries_to_logout_without_token(): void
    {
        $response = $this -> delete('/api/logout');
        $response -> assertStatus(403);
    }
    
    public function test_logged_in_user_tries_to_logout(): void
    {
        $response = $this -> delete('/api/logout',[], [
            'jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJVc2VyIE1hbmFnZXIiLCJhdWQiOiJodHRwOi8vbG9jYWxob3N0IiwiaWF0IjoxNzEyODcxNDk1LCJzdWIiOm51bGwsImVtYWlsIjoiZHJ5ZHVkZSAyQHRlc3QuY29tIiwiaWQiOjQsImV4cCI6MTcxMjg3NTA5NX0.JBlBxnmxQds00GHLbQmrSSPUry1TYJjem1tT9I1iWW4'
        ]);
        $response -> assertStatus(204);
    }


    // ? User creation tests

    /**
     * User tries to create an account and succeeds
     */
    public function test_user_creates_account_successfully(): void
    {
        $response = $this -> post('/api/signup', [
            'name' => 'Dry Dude 5',
            'email' => 'drydude5@test.com',
            'password' => 'drydude12345'
        ]);
        
        $response -> assertStatus(204);
    }

    /**
     * User tries to create an account with an already existing email
     */
    public function test_user_tries_to_create_user_with_existing_email(): void
    {
        $response = $this -> post('/api/signup', [
            'name' => 'Dry Dude',
            'email' => 'drydude@test.com',
            'password' => 'drydude12345'
        ]);

        $response -> assertStatus(400);
    }

    // ? User update tries to 

    /**
     * User tries to update his information but token is not sent
     */
    public function test_user_tries_to_update_without_token(): void
    {
        $response = $this -> patch('/api/update', [
            'name' => 'Real Doodrie'
        ]);

        $response -> assertStatus(403);
    }

    /**
     * User updates his information successfully
     */
    public function test_user_updates_information_successfully(): void
    {
        $response = $this -> patch('/api/update', [
            'name' => 'Real Doodrie',
            'password' => 'drydude12345'
        ], [
            'jwt' => JWT
        ]);

        $response -> assertStatus(204);
    }

    public function test_user_updates_information_with_wrong_password(): void
    {
        $response = $this -> patch('/api/update', [
            'name' => 'Real Doodrie',
            'password' => 'drydude12344'
        ], [
            'jwt' => JWT
        ]);

        $response -> assertStatus(403);
    }

    /**
     * User tries to update his email but such email is already in use
     */
    public function test_user_updates_email_already_in_use(): void
    {
        $response = $this -> patch('/api/update', [
            'email' => 'drydude@test.com',
            'password' => 'drydude12345'
        ], [
            'jwt' => JWT
        ]);

        $response -> assertStatus(400);
    }

    // ? User deletion

    /**
     *  User tries to delete account without token
     */
    public function test_user_tries_to_delete_account_without_token(): void
    {
        $response = $this -> delete('/api/delete');
        $response -> assertStatus(403);
    }

    /**
     *  User tries to delete account without token
     */
    public function test_user_deletes_account_successfully(): void
    {
        $response = $this -> delete('/api/delete', [], [
            'jwt' => JWT
        ]);
        $response -> assertStatus(204);
    }
}
