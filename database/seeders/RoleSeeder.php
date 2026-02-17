<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Student',
                'permissions' => ['create_ticket', 'view_own_tickets', 'reply_ticket']
            ],
            [
                'role_name' => 'Staff',
                'permissions' => ['view_all_tickets', 'assign_ticket', 'reply_ticket', 'close_ticket']
            ],
            [
                'role_name' => 'Advisor',
                'permissions' => ['view_all_tickets', 'reply_ticket', 'create_announcement']
            ],
            [
                'role_name' => 'Admin',
                'permissions' => ['full_access']
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
