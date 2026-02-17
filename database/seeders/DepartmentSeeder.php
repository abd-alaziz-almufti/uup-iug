<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'كلية تكنولوجيا المعلومات', 'type' => 'College'],
            ['name' => 'كلية الهندسة', 'type' => 'College'],
            ['name' => 'دائرة القبول والتسجيل', 'type' => 'Admin_Dept'],
            ['name' => 'دائرة الشؤون المالية', 'type' => 'Admin_Dept'],
            ['name' => 'دائرة شؤون الطلبة', 'type' => 'Admin_Dept'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
