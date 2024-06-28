<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function __construct()
    {
    }

    public function createUser(array $data): User
    {
        return User::create([
            'pseudo' => $data['pseudo'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'image' => $data['image'],
            'delivery_address' => $data['delivery_address'],
            'password' => Hash::make($data['password']),
            'role' => 'user'
        ]);
    }
}
