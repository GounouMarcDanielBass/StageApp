<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $google2fa;

    protected function setUp(): void
    {
        parent::setUp();
        $this->google2fa = new Google2FA();

        // Create a default role for testing
        Role::firstOrCreate(['name' => 'student']);
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => 1, // Assuming role_id 1 is a valid role
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
                 ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user']);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user']);
    }

    /**
     * Test account lockout after multiple failed login attempts.
     *
     * @return void
     */
    public function test_account_locks_after_failed_attempts()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);

        // Simulate multiple failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(403)
                 ->assertJson(['message' => 'Your account has been locked due to too many failed login attempts. Please try again later.']);

        $this->assertNotNull(User::find($user->id)->locked_until);
    }

    /**
     * Test 2FA secret generation.
     *
     * @return void
     */
    public function test_user_can_generate_2fa_secret()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/2fa/generate-secret');

        $response->assertStatus(200)
                 ->assertJsonStructure(['secret', 'qrcode_svg']);

        $this->assertNotNull(User::find($user->id)->google2fa_secret);
    }

    /**
     * Test enabling 2FA.
     *
     * @return void
     */
    public function test_user_can_enable_2fa()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        // Generate secret first
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/2fa/generate-secret');

        $user = User::find($user->id);
        $oneTimePassword = $this->google2fa->getCurrentOtp($user->google2fa_secret);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/2fa/enable', [
            'one_time_password' => $oneTimePassword,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Two-factor authentication enabled successfully.']);

        $this->assertTrue(User::find($user->id)->google2fa_enabled);
    }

    /**
     * Test disabling 2FA.
     *
     * @return void
     */
    public function test_user_can_disable_2fa()
    {
        $user = User::factory()->create([
            'google2fa_enabled' => true,
            'google2fa_secret' => $this->google2fa->generateSecretKey(),
        ]);
        $token = auth()->login($user);

        $oneTimePassword = $this->google2fa->getCurrentOtp($user->google2fa_secret);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/2fa/disable', [
            'one_time_password' => $oneTimePassword,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Two-factor authentication disabled successfully.']);

        $this->assertFalse(User::find($user->id)->google2fa_enabled);
        $this->assertNull(User::find($user->id)->google2fa_secret);
    }

    /**
     * Test 2FA verification during login.
     *
     * @return void
     */
    public function test_user_requires_2fa_during_login()
    {
        $user = User::factory()->create([
            'google2fa_enabled' => true,
            'google2fa_secret' => $this->google2fa->generateSecretKey(),
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(403)
                 ->assertJson(['message' => 'Two-factor authentication required.']);
    }

    /**
     * Test 2FA verification with correct code.
     *
     * @return void
     */
    public function test_user_can_verify_2fa_code()
    {
        $user = User::factory()->create([
            'google2fa_enabled' => true,
            'google2fa_secret' => $this->google2fa->generateSecretKey(),
            'password' => Hash::make('password'),
        ]);

        // Simulate login attempt that requires 2FA
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $oneTimePassword = $this->google2fa->getCurrentOtp($user->google2fa_secret);

        $response = $this->postJson('/api/auth/2fa/verify', [
            'email' => $user->email,
            'one_time_password' => $oneTimePassword,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user']);
    }

    /**
     * Test 2FA verification with incorrect code.
     *
     * @return void
     */
    // public function test_user_cannot_verify_2fa_with_incorrect_code()
    // {
    //     $user = User::factory()->create([
    //         'google2fa_enabled' => true,
    //         'google2fa_secret' => $this->google2fa->generateSecretKey(),
    //         'password' => Hash::make('password'),
    //     ]);

    //     // Simulate login attempt that requires 2FA
    //     $this->postJson('/api/login', [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ]);

    //     $response = $this->postJson('/api/auth/2fa/verify', [
    //         'email' => $user->email,
    //         'one_time_password' => 'incorrect-code',
    //     ]);

    //     $response->assertStatus(403)
    //              ->assertJson(['message' => 'Invalid two-factor authentication code.']);
    // }
}