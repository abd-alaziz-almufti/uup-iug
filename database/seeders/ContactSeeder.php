<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Department;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dept = Department::where('name', 'دائرة الشؤون المالية')->first();

        if (!$dept) {
            $dept = Department::create(['name' => 'دائرة الشؤون المالية', 'type' => 'Admin_Dept']);
        }

        $contacts = [
            [
                'name' => 'محمد عبد الكريم',
                'position' => 'محاسب',
                'email' => 'public5@iugaza.edu.ps',
                'phone' => '00970-59XXXXXXX',
                'department_id' => $dept->id,
            ],
            [
                'name' => 'احمد المنسي',
                'position' => 'محاسب',
                'email' => 'public5@iugaza.edu.ps',
                'phone' => '00970-59XXXXXXX',
                'department_id' => $dept->id,
            ],
            [
                'name' => 'ايمن عاشور',
                'position' => 'محاسب',
                'email' => 'public5@iugaza.edu.ps',
                'phone' => '00970-59XXXXXXX',
                'department_id' => $dept->id,
            ],
            [
                'name' => 'خالد الخطيب',
                'position' => 'محاسب',
                'email' => 'public5@iugaza.edu.ps',
                'phone' => '00970-59XXXXXXX',
                'department_id' => $dept->id,
            ],
            [
                'name' => 'احمد ابو بكر',
                'position' => 'محاسب',
                'email' => 'public5@iugaza.edu.ps',
                'phone' => '00970-59XXXXXXX',
                'department_id' => $dept->id,
            ],
            [
                'name' => 'سارة عبد الغني',
                'position' => 'محاسب',
                'email' => 'public5@iugaza.edu.ps',
                'phone' => '00970-59XXXXXXX',
                'department_id' => $dept->id,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
