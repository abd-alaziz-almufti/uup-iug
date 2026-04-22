<?php

namespace App\Livewire;

use Livewire\Component;

class ContactDepartment extends Component
{
    #[Computed]
    public function getDepartmentsData()
    {
        // Eager load contacts to avoid N+1 and get all data for dynamic Alpine modal
        return \App\Models\Department::with('contacts')->get()->map(function ($dept) {
            return [
                "id" => $dept->id,
                "title" => $dept->name,
                "image" => $dept->icon ?? 'dep-finance.png',
                "contacts" => $dept->contacts->map(function ($contact) {
                    return [
                        "name" => $contact->name,
                        "initials" => mb_substr($contact->name, 0, 2),
                        "title" => $contact->position ?? "موظف",
                        "phone" => $contact->phone ?? "00970-59XXXXXXX",
                        "email" => $contact->email ?? "public5@iugaza.edu.ps",
                    ];
                })->toArray(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.contact-department', [
            'departmentsData' => $this->getDepartmentsData(),
        ]);
    }
}
