<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StudentLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup roles
        Role::create(['name' => 'Student']);
        Role::create(['name' => 'Support Agent']);
    }

    /** @test */
    public function a_student_can_log_in_successfully()
    {
        $student = User::factory()->create([
            'university_id' => '12345678',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole('Student');

        Livewire::test(\App\Livewire\Auth\LoginModal::class)
            ->set('username', '12345678')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($student);
    }

    /** @test */
    public function a_non_student_cannot_log_in_through_student_login()
    {
        $agent = User::factory()->create([
            'university_id' => '87654321',
            'password' => bcrypt('password'),
        ]);
        $agent->assignRole('Support Agent');

        Livewire::test(\App\Livewire\Auth\LoginModal::class)
            ->set('username', '87654321')
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors(['username' => 'عذراً، هذا النظام مخصص للطلاب فقط.']);

        $this->assertGuest();
    }

    /** @test */
    public function invalid_credentials_show_error()
    {
        Livewire::test(\App\Livewire\Auth\LoginModal::class)
            ->set('username', 'invalid')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors(['username' => 'بيانات الدخول غير صحيحة']);

        $this->assertGuest();
    }
}
