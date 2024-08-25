<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_show_login_page(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_can_login_via_email()
    {
        $user = User::factory()->create();

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ],
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(200);
    }

    public function test_can_login_via_right_phone()
    {
        $user = User::factory()->create();

        $response = $this->postJson('login', [
            'phone' => $user->phone->formatE164(),
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_cant_login_via_wrong_phone()
    {
        $response = $this->post('login', [
            'phone' => '6543',
            'password' => 'password'
        ],
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'phone'
        ]);
    }

    public function test_can_show_validation_errors()
    {
        $response = $this->post('login',
            headers: [
                'accept' => 'application/json'
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'phone',
            'email',
            'password'
        ]);
    }
}
