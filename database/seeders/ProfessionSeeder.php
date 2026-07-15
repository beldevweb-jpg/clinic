<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    public function run(): void
    {
        $professions = [
            'เวชกรรม',
            'แพทย์แผนไทย',
            'แพทย์แผนไทยประยุกต์',
            'ทันตกรรม',
            'เภสัชกรรม',
            'ผู้ประกอบโรคศิลปะ สาขาการแพทย์แผนจีน',
            'หมอพื้นบ้าน',
        ];


        foreach ($professions as $profession) {

            Profession::firstOrCreate([
                'name' => $profession
            ]);

        }
    }
}