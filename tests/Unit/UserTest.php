<?php

namespace Tests\Unit;

use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a user.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $data = [
            'pseudo' => 'toto',
            'first_name' => 'toto',
            'last_name' => 'toto',
            'email' => 'toto@toto.fr',
            'address' => 'Toto',
            'phone_number' => '0606060606',
            'image' => 'toto.jpg',
            'delivery_address' => 'Toto',
            'password' => 'password',
        ];

        $service = new UserService();
        $user = $service->createUser($data);

        $this->assertNotNull($user);

        $this->assertDatabaseHas('users', [
            'pseudo' => $data['pseudo'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'image' => $data['image'],
            'delivery_address' => $data['delivery_address'],
            'role' => $user->role,
        ]);

        $this->assertFalse($user->hasRole('admin'));
        $this->assertTrue($user->hasRole('user'));
        $this->assertFalse($user->hasRole('craftman'));
    }

}
