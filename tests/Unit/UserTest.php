<?php

namespace Tests\Unit;

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
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'pseudo' => $user->pseudo,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'address' => $user->address,
            'phone_number' => $user->phone_number,
            'image' => $user->image,
            'delivery_address' => $user->delivery_address,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'role' => $user->role,
        ]);
    }

    /**
     * Test the hasRole method of User class.
     *
     * @return void
     */
    public function testHasRole()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('user'));
        $this->assertFalse($user->hasRole('craftman'));
    }

    /**
     * Test the shops relationship of User class.
     *
     * @return void
     */
    public function testShopsRelationship()
    {
        $user = User::factory()->hasShops(2)->create();

        $this->assertCount(2, $user->shops);
    }
}
