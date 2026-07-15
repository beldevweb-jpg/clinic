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

        // สร้าง Role
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


        // สร้าง Admin User
        $admin = User::firstOrCreate(
            [
                'username' => 'admin'
            ],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin112233'),
                'active' => true,
            ]
        );


        // Assign Role Admin
        $adminRole = Roles::where('slug', 'admin')->first();

        $admin->roles()->sync([
            $adminRole->id
        ]);
    }
}
