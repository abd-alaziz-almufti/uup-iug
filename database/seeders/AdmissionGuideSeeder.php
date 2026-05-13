<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdmissionGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Major::truncate();
        College::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'كلية الطب البشري' => [
                ['name' => 'الطب البشري', 'type' => 'bachelor', 'rate' => 95.0, 'price' => 50.0],
            ],
            'كلية الهندسة' => [
                ['name' => 'الهندسة المدنية', 'type' => 'bachelor', 'rate' => 85.0, 'price' => 35.0],
                ['name' => 'الهندسة المعمارية', 'type' => 'bachelor', 'rate' => 85.0, 'price' => 35.0],
                ['name' => 'هندسة الحاسوب', 'type' => 'bachelor', 'rate' => 82.0, 'price' => 35.0],
                ['name' => 'الهندسة الكهربائية', 'type' => 'bachelor', 'rate' => 80.0, 'price' => 35.0],
            ],
            'كلية تكنولوجيا المعلومات' => [
                ['name' => 'تطوير البرمجيات', 'type' => 'bachelor', 'rate' => 75.0, 'price' => 25.0],
                ['name' => 'نظم المعلومات الإدارية', 'type' => 'bachelor', 'rate' => 70.0, 'price' => 25.0],
                ['name' => 'الوسائط المتعددة', 'type' => 'bachelor', 'rate' => 70.0, 'price' => 25.0],
                ['name' => 'تكنولوجيا الأجهزة المحمولة', 'type' => 'diploma', 'rate' => 60.0, 'price' => 20.0],
            ],
            'كلية العلوم الصحية' => [
                ['name' => 'التمريض', 'type' => 'bachelor', 'rate' => 80.0, 'price' => 25.0],
                ['name' => 'العلاج الطبيعي', 'type' => 'bachelor', 'rate' => 78.0, 'price' => 25.0],
                ['name' => 'التحاليل الطبية', 'type' => 'bachelor', 'rate' => 75.0, 'price' => 25.0],
            ],
        ];

        foreach ($data as $collegeName => $majors) {
            $college = College::create(['name' => $collegeName]);

            foreach ($majors as $majorData) {
                Major::create([
                    'college_id' => $college->id,
                    'name' => $majorData['name'],
                    'degree_type' => $majorData['type'],
                    'acceptance_rate' => $majorData['rate'],
                    'credit_hour_price' => $majorData['price'],
                    'total_hours' => 140, // Average hours
                ]);
            }
        }
    }
}
