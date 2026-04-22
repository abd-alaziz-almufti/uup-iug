<?php

namespace App\Livewire;

use Livewire\Component;

class StudentDashboard extends Component
{
    public $activeSection = 'home';

    protected $listeners = ['changeSection' => 'setSection'];

    public function mount()
    {
        // This can be set via query params or default
    }

    public function setSection($section)
    {
        $this->activeSection = $section;
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.student-dashboard')
            ->layout('components.layouts.app');
    }
}
