<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     * Require email and password for login
     *
     * @return void
     */
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    /**
     * Test user login successfully
     *
     * @return void
     */
    public function testUserLoginsSuccessfully()
    {
        $user = User::factory()->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('donutboygirl'),
        ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => 'donutboygirl'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
}
