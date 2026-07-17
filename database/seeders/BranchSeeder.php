<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Branchs\Models\Branchs;


class BranchSeeder extends Seeder
{

    public function run(): void
    {
        Branchs::create([
            'id' => 1,
            'code' => 'BR00001',
            'name' => 'บีจี คลินิกแพทย์แผนไทย',
            'phone' => '0123456789',
            'address' => '146/99 ซอยลาดพร้าว 122',
            'license' => 'CL-00001',
            'active' => 1,
        ]);
    }
}
