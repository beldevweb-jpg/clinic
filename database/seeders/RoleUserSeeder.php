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



        // Admin (เห็นทุกสาขา)
        $admin = User::updateOrCreate(
            [
                'username' => 'admin'
            ],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin112233'),
                'branch_id' => 1,
                'active' => true,
            ]
        );


        $admin->roles()->sync([
            Roles::where('slug', 'admin')->first()->id
        ]);




        // // Manager
        // $manager = User::updateOrCreate(
        //     [
        //         'username' => 'manager112233'
        //     ],
        //     [
        //         'name' => 'Manager',
        //         'password' => Hash::make('manager112233'),
        //         'branch_id' => 1,
        //         'active' => true,
        //     ]
        // );


        // $manager->roles()->sync([
        //     Roles::where('slug', 'manager')->first()->id
        // ]);




        // // Staff
        // $staff = User::updateOrCreate(
        //     [
        //         'username' => 'staff112233'
        //     ],
        //     [
        //         'name' => 'Staff',
        //         'password' => Hash::make('staff112233'),
        //         'branch_id' => 1,
        //         'active' => true,
        //     ]
        // );


        // $staff->roles()->sync([
        //     Roles::where('slug', 'staff')->first()->id
        // ]);
    }
}
