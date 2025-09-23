<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nik' => '1234567890123456',
            'address' => 'Test Address',
            'phone' => '081234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        
        // Verify that the client was created with the user's name as client_name
        $this->assertDatabaseHas('clients', [
            'client_name' => 'Test User',
            'nik' => '1234567890123456',
            'address' => 'Test Address',
            'phone' => '081234567890',
        ]);
        
        // Verify that the user has the correct client_id and role
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'client',
        ]);
    }
}
