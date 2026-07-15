<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {

        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin'
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager'
            ],
            [
                'name' => 'Doctor',
                'slug' => 'doctor'
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff'
            ],
        ];


        foreach ($roles as $role) {

            Roles::firstOrCreate(
                [
                    'slug' => $role['slug']
                ],
                $role
            );

        }


        $admin = User::firstOrCreate(
            [
                'username' => 'admin'
            ],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin112233'),
                'branch_id' => null,
                'active' => true,
            ]
        );


        $adminRole = Roles::where('slug','admin')->first();


        $admin->roles()->sync([
            $adminRole->id
        ]);

    }
}