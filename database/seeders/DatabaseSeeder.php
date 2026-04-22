<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);

        $this->command->info('Generating Shield permissions...');
        \Illuminate\Support\Facades\Artisan::call('shield:generate', [
            '--all' => true,
            '--option' => 'policies_and_permissions',
            '--panel' => 'admin',
        ]);
        $this->command->info('Shield permissions generated!');

        $this->call([
            RolesAndUsersSeeder::class,
            DepartmentSeeder::class,
            CourseSeeder::class,
            TicketSeeder::class,
            FAQSeeder::class,
            ContactSeeder::class,
        ]);

    }
}
