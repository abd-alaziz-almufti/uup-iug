<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📚 Creating courses...');

        // جلب الأقسام
        $itDepartment = Department::where('name', 'كلية تكنولوجيا المعلومات')->first();
        $engDepartment = Department::where('name', 'كلية الهندسة')->first();

        // ========================================
        // 1. مواد كلية تكنولوجيا المعلومات
        // ========================================
        $itCourses = [
            // السنة الأولى
            [
                'course_code' => 'CS101',
                'name' => 'مقدمة في علوم الحاسوب',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS102',
                'name' => 'البرمجة 1',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'MATH101',
                'name' => 'الرياضيات المتقطعة',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'ENG102',
                'name' => 'اللغة الإنجليزية 1',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],

            // السنة الثانية
            [
                'course_code' => 'CS201',
                'name' => 'البرمجة الكائنية',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS202',
                'name' => 'هياكل البيانات والخوارزميات',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS203',
                'name' => 'قواعد البيانات',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS204',
                'name' => 'تنظيم وبنية الحاسوب',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'MATH201',
                'name' => 'الإحصاء والاحتمالات',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],

            // السنة الثالثة
            [
                'course_code' => 'CS301',
                'name' => 'تطوير تطبيقات الويب',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS302',
                'name' => 'هندسة البرمجيات',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS303',
                'name' => 'نظم التشغيل',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS304',
                'name' => 'الشبكات الحاسوبية',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS305',
                'name' => 'أمن المعلومات',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],

            // السنة الرابعة
            [
                'course_code' => 'CS401',
                'name' => 'الذكاء الاصطناعي',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS402',
                'name' => 'تعلم الآلة',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS403',
                'name' => 'الحوسبة السحابية',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS404',
                'name' => 'تطوير تطبيقات الموبايل',
                'credit_hours' => 3,
                'department_id' => $itDepartment?->id,
            ],
            [
                'course_code' => 'CS499',
                'name' => 'مشروع التخرج',
                'credit_hours' => 6,
                'department_id' => $itDepartment?->id,
            ],
        ];

        foreach ($itCourses as $course) {
            Course::create($course);
            $this->command->info("  ✅ IT Course: {$course['course_code']} - {$course['name']}");
        }

        // ========================================
        // 2. مواد كلية الهندسة
        // ========================================
        $engCourses = [
            // السنة الأولى
            [
                'course_code' => 'ENG101',
                'name' => 'مقدمة في الهندسة',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'MATH111',
                'name' => 'الرياضيات الهندسية 1',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'PHYS101',
                'name' => 'الفيزياء العامة 1',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'CHEM101',
                'name' => 'الكيمياء العامة',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],

            // السنة الثانية
            [
                'course_code' => 'ENG201',
                'name' => 'الديناميكا الحرارية',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'ENG202',
                'name' => 'ميكانيكا الموائع',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'ENG203',
                'name' => 'نظرية الدوائر الكهربائية',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'MATH211',
                'name' => 'المعادلات التفاضلية',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],

            // السنة الثالثة
            [
                'course_code' => 'ENG301',
                'name' => 'التحكم الآلي',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'ENG302',
                'name' => 'هندسة الطاقة',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'ENG303',
                'name' => 'تصميم الآلات',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],

            // السنة الرابعة
            [
                'course_code' => 'ENG401',
                'name' => 'إدارة المشاريع الهندسية',
                'credit_hours' => 3,
                'department_id' => $engDepartment?->id,
            ],
            [
                'course_code' => 'ENG499',
                'name' => 'مشروع التخرج الهندسي',
                'credit_hours' => 6,
                'department_id' => $engDepartment?->id,
            ],
        ];

        foreach ($engCourses as $course) {
            Course::create($course);
            $this->command->info("  ✅ ENG Course: {$course['course_code']} - {$course['name']}");
        }

        // ========================================
        // 3. مواد متطلبات الجامعة (عامة)
        // ========================================
        $generalCourses = [
            [
                'course_code' => 'UNIV101',
                'name' => 'مهارات الاتصال',
                'credit_hours' => 3,
                'department_id' => null,
            ],
            [
                'course_code' => 'UNIV102',
                'name' => 'الثقافة الإسلامية',
                'credit_hours' => 3,
                'department_id' => null,
            ],
            [
                'course_code' => 'UNIV103',
                'name' => 'اللغة العربية',
                'credit_hours' => 3,
                'department_id' => null,
            ],
            [
                'course_code' => 'UNIV104',
                'name' => 'التربية الوطنية',
                'credit_hours' => 3,
                'department_id' => null,
            ],
            [
                'course_code' => 'UNIV105',
                'name' => 'مهارات التفكير الناقد',
                'credit_hours' => 3,
                'department_id' => null,
            ],
        ];

        foreach ($generalCourses as $course) {
            Course::create($course);
            $this->command->info("  ✅ General Course: {$course['course_code']} - {$course['name']}");
        }

        // ========================================
        // الخلاصة
        // ========================================
        $total = Course::count();
        $itCount = Course::where('department_id', $itDepartment?->id)->count();
        $engCount = Course::where('department_id', $engDepartment?->id)->count();
        $generalCount = Course::whereNull('department_id')->count();

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🎉 Created {$total} courses successfully!");
        $this->command->info("   💻 IT Courses: {$itCount}");
        $this->command->info("   ⚙️  Engineering Courses: {$engCount}");
        $this->command->info("   📖 General University Courses: {$generalCount}");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }
}
