<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles_data = array('user', 'admin');

        foreach($roles_data as $role){
            Role::create([
                'name' => $role
            ]);
        }
    }
}
