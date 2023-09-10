<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_data = [
            array(
                'name' => 'BasicUser',
                'email' => 'user@test.com',
                'password' => 'user123'
            ),
            array(
                'name' => 'AdminUser',
                'email' => 'admin@test.com',
                'password' => 'admin123'
            )
        ];        
        
        foreach($user_data as $user){
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password'])
            ]);
        }
    }
}
