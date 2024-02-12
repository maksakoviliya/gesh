<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function test_can_show_register_page(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_can_register()
    {
        $this->assertDatabaseCount('users', 0);

        $data = [
            'email' => 'test@mail.com',
            'name' => 'Test User',
            'phone' => '+79991234567',
        ];
        $response = $this->post('/register',
            data: array_merge($data, [
                'password' => '123123123'
            ]),
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', $data);
    }

    public function test_cant_register_only_by_email()
    {
        $this->assertDatabaseCount('users', 0);

        $data = [
            'email' => 'test@mail.com',
            'name' => 'Test User',
        ];
        $response = $this->post('/register',
            data: array_merge($data, [
                'password' => '123123123'
            ]),
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_cant_register_only_by_phone()
    {
        $this->assertDatabaseCount('users', 0);

        $data = [
            'phone' => '+79991234567',
            'name' => 'Test User',
        ];
        $response = $this->post('/register',
            data: array_merge($data, [
                'password' => '123123123'
            ]),
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_show_validation_errors()
    {
        $this->assertDatabaseCount('users', 0);

        $response = $this->post('/register',
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'phone',
            'email',
            'name',
            'password',
        ]);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_cant_register_on_duplicated_email()
    {
        User::factory(1)->create([
            'email' => 'test@mail.com'
        ]);
        $this->assertDatabaseCount('users', 1);

        $data = [
            'email' => 'test@mail.com',
            'name' => 'Test User',
            'phone' => '+79991234567',
        ];
        $response = $this->post('/register',
            data: array_merge($data, [
                'password' => '123123123'
            ]),
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
        ]);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_cant_register_on_duplicated_phone()
    {
        User::factory(1)->create([
            'phone' => '+7(987) 222 11-11'
        ]);
        $this->assertDatabaseCount('users', 1);

        $data = [
            'email' => 'test@mail.com',
            'name' => 'Test User',
            'phone' => '+79872221111',
        ];
        $response = $this->post('/register',
            data: array_merge($data, [
                'password' => '123123123'
            ]),
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'phone',
        ]);

        $this->assertDatabaseCount('users', 1);
    }
}
