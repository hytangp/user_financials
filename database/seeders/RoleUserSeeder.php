<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_user_data = array(
            array(
                'role_id' => 1,
                'user_id' => 1
            ),
            array(
                'role_id' => 2,
                'user_id' => 2
            )
        );

        foreach($role_user_data as $role_user){
            RoleUser::create([
                'role_id' => $role_user['role_id'],
                'user_id' => $role_user['user_id']
            ]);
        }
    }
}
