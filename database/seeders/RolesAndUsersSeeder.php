<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin = User::firstOrCreate([
            'email' => 'admin@iug.edu.ps',
        ], [
            'name' => 'Super Admin',
            'university_id' => '10000',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // 2. Support Agent / Inquiry Officer
        $supportAgentRole = Role::firstOrCreate(['name' => 'Support Agent', 'guard_name' => 'web']);
        $supportAgentRole->syncPermissions([
            'ViewAny:Ticket', 'View:Ticket', 'Update:Ticket',
            'ViewAny:Contact', 'View:Contact',
            'ViewAny:FAQ', 'View:FAQ',
            'ViewAny:User', 'View:User',
        ]);
        $supportAgent = User::firstOrCreate([
            'email' => 'support@iug.edu.ps',
        ], [
            'name' => 'Support Agent',
            'university_id' => '10001',
            'password' => Hash::make('password'),
        ]);
        $supportAgent->assignRole($supportAgentRole);

        // 3. Content Manager
        $contentManagerRole = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManagerRole->syncPermissions([
            'ViewAny:Announcement', 'View:Announcement', 'Create:Announcement', 'Update:Announcement', 'Delete:Announcement',
            'ViewAny:FAQ', 'View:FAQ', 'Create:FAQ', 'Update:FAQ', 'Delete:FAQ',
        ]);
        $contentManager = User::firstOrCreate([
            'email' => 'content@iug.edu.ps',
        ], [
            'name' => 'Content Manager',
            'university_id' => '10002',
            'password' => Hash::make('password'),
        ]);
        $contentManager->assignRole($contentManagerRole);

        // 4. Academic Supervisor
        $academicSupervisorRole = Role::firstOrCreate(['name' => 'Academic Supervisor', 'guard_name' => 'web']);
        $academicSupervisorRole->syncPermissions([
            'ViewAny:Department', 'View:Department', 'Create:Department', 'Update:Department', 'Delete:Department',
            'ViewAny:Course', 'View:Course', 'Create:Course', 'Update:Course', 'Delete:Course',
            'ViewAny:User', 'View:User',
        ]);
        $academicSupervisor = User::firstOrCreate([
            'email' => 'academic@iug.edu.ps',
        ], [
            'name' => 'Academic Supervisor',
            'university_id' => '10003',
            'password' => Hash::make('password'),
        ]);
        $academicSupervisor->assignRole($academicSupervisorRole);

        // 5. Dean
        $deanRole = Role::firstOrCreate(['name' => 'Dean', 'guard_name' => 'web']);
        $deanRole->syncPermissions([
            'ViewAny:Ticket', 'View:Ticket', 'Update:Ticket',
            'ViewAny:Department', 'View:Department',
        ]);
        $dean = User::firstOrCreate([
            'email' => 'dean@iug.edu.ps',
        ], [
            'name' => 'IT Dean',
            'university_id' => '10004',
            'password' => Hash::make('password'),
            'department_id' => 1, // Assumes IT department exists
        ]);
        $dean->assignRole($deanRole);

        // 6. Instructor
        $instructorRole = Role::firstOrCreate(['name' => 'Instructor', 'guard_name' => 'web']);
        $instructorRole->syncPermissions([
            'ViewAny:Ticket', 'View:Ticket', 'Update:Ticket',
        ]);
        $instructor = User::firstOrCreate([
            'email' => 'instructor@iug.edu.ps',
        ], [
            'name' => 'IT Instructor',
            'university_id' => '10005',
            'password' => Hash::make('password'),
            'department_id' => 1,
        ]);
        $instructor->assignRole($instructorRole);

        // 7. Admission Officer
        $admissionRole = Role::firstOrCreate(['name' => 'Admission Officer', 'guard_name' => 'web']);
        $admissionRole->syncPermissions([
            'ViewAny:Ticket', 'View:Ticket', 'Update:Ticket',
        ]);
        $admissionOfficer = User::firstOrCreate([
            'email' => 'admission@iug.edu.ps',
        ], [
            'name' => 'Admission Officer',
            'university_id' => '10006',
            'password' => Hash::make('password'),
        ]);
        $admissionOfficer->assignRole($admissionRole);

        // 8. Students
        $studentRole = Role::firstOrCreate(['name' => 'Student', 'guard_name' => 'web']);
        // Students don't need Filament panel access, they only use the front-end, but we create them here
        $student1 = User::firstOrCreate([
            'email' => 'student1@iug.edu.ps',
        ], [
            'name' => 'Ahmed Student',
            'university_id' => '120220743',
            'password' => Hash::make('password'),
        ]);
        $student1->assignRole($studentRole);

        $student2 = User::firstOrCreate([
            'email' => 'student2@iug.edu.ps',
        ], [
            'name' => 'Ali Student',
            'university_id' => '120220744',
            'password' => Hash::make('password'),
        ]);
        $student2->assignRole($studentRole);
    }
}
