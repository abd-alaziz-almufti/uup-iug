<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========================================
        // كلمة السر الموحدة للتجربة
        // ========================================
        $password = Hash::make('password');

        // ========================================
        // 1. Admin
        // ========================================
        User::create([
            'university_id' => '100000001',
            'name' => 'مدير النظام',
            'email' => 'admin@iugaza.edu.ps',
            'password' => $password, // password
            'role_id' => 4, // Admin
            'department_id' => null,
        ]);

        // ========================================
        // 2. Staff - موظفين إداريين
        // ========================================

        // موظف القبول والتسجيل
        User::create([
            'university_id' => '100000002',
            'name' => 'أحمد محمود',
            'email' => 'staff.admission@iugaza.edu.ps',
            'password' => $password, // password
            'role_id' => 2, // Staff
            'department_id' => 3, // دائرة القبول والتسجيل
        ]);

        // موظف الشؤون المالية
        User::create([
            'university_id' => '100000003',
            'name' => 'سارة أحمد',
            'email' => 'staff.finance@iugaza.edu.ps',
            'password' => $password, // password
            'role_id' => 2, // Staff
            'department_id' => 4, // دائرة الشؤون المالية
        ]);

        // موظف شؤون الطلبة
        User::create([
            'university_id' => '100000004',
            'name' => 'خالد عمر',
            'email' => 'staff.students@iugaza.edu.ps',
            'password' => $password, // password
            'role_id' => 2, // Staff
            'department_id' => 5, // دائرة شؤون الطلبة
        ]);

        // ========================================
        // 3. Advisors - مستشارين أكاديميين
        // ========================================
        User::create([
            'university_id' => '100000005',
            'name' => 'د. محمد حسن',
            'email' => 'advisor.it@iugaza.edu.ps',
            'password' => $password, // password
            'role_id' => 3, // Advisor
            'department_id' => 1, // كلية تكنولوجيا المعلومات
        ]);

        User::create([
            'university_id' => '100000006',
            'name' => 'د. فاطمة علي',
            'email' => 'advisor.eng@iugaza.edu.ps',
            'password' => $password, // password
            'role_id' => 3, // Advisor
            'department_id' => 2, // كلية الهندسة
        ]);

        // ========================================
        // 4. Students - طلاب
        // ========================================

        // طلاب تكنولوجيا المعلومات
        $itStudents = [
            [
                'university_id' => '120220743',
                'name' => 'محمد أحمد',
                'email' => 'student1@iugaza.edu.ps',
            ],
            [
                'university_id' => '120220744',
                'name' => 'أحمد محمد',
                'email' => 'student2@iugaza.edu.ps',
            ],
            [
                'university_id' => '120220745',
                'name' => 'علي حسن',
                'email' => 'student3@iugaza.edu.ps',
            ],
        ];

        foreach ($itStudents as $student) {
            User::create([
                ...$student,
                'password' => $password, // password
                'role_id' => 1, // Student
                'department_id' => 1, // IT
            ]);
        }

        // طلاب الهندسة
        $engStudents = [
            [
                'university_id' => '120220746',
                'name' => 'سارة محمود',
                'email' => 'student4@iugaza.edu.ps',
            ],
            [
                'university_id' => '120220747',
                'name' => 'ليلى عمر',
                'email' => 'student5@iugaza.edu.ps',
            ],
        ];

        foreach ($engStudents as $student) {
            User::create([
                ...$student,
                'password' => $password, // password
                'role_id' => 1, // Student
                'department_id' => 2, // Engineering
            ]);
        }

        // ========================================
        // 5. مزيد من الطلاب (عشوائي)
        // ========================================
        // User::factory()->count(20)->create([
        //     'password' => $password,
        //     'role_id' => 1,
        //     'department_id' => 1,
        // ]);
    }
}
