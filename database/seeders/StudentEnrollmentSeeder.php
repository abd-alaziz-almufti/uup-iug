<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use App\Models\StudentEnrollment;
use Illuminate\Database\Seeder;

class StudentEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎓 Seeding student enrollments...');

        // 1. Get Departments
        $itDept = Department::where('name', 'كلية تكنولوجيا المعلومات')->first();
        $engDept = Department::where('name', 'كلية الهندسة')->first();

        if (!$itDept || !$engDept) {
            $this->command->error('Departments not found! Please run DepartmentSeeder first.');
            return;
        }

        // 2. Get Students
        $student1 = User::where('name', 'Ahmed Student')->first();
        $student2 = User::where('name', 'Ali Student')->first();

        if (!$student1 || !$student2) {
            $this->command->error('Students not found! Please run RolesAndUsersSeeder first.');
            return;
        }

        // 3. Link Students to Departments
        $student1->update(['department_id' => $itDept->id]);
        $student2->update(['department_id' => $engDept->id]);

        $this->command->info('✅ Students linked to departments.');

        // 4. Enroll Ahmed (IT Student) in IT Courses
        $itCourses = Course::where('department_id', $itDept->id)->limit(5)->get();
        foreach ($itCourses as $course) {
            StudentEnrollment::firstOrCreate([
                'student_id' => $student1->id,
                'course_id' => $course->id,
            ], [
                'grade' => null,
                'status' => 'enrolled',
            ]);
        }

        // 5. Enroll Ali (Engineering Student) in Engineering Courses
        $engCourses = Course::where('department_id', $engDept->id)->limit(5)->get();
        foreach ($engCourses as $course) {
            StudentEnrollment::firstOrCreate([
                'student_id' => $student2->id,
                'course_id' => $course->id,
            ], [
                'grade' => null,
                'status' => 'enrolled',
            ]);
        }

        $this->command->info('✅ Student enrollments created.');
    }
}
