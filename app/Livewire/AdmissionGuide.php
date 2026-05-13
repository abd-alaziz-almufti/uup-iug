<?php

namespace App\Livewire;

use App\Models\College;
use App\Models\Major;
use Livewire\Component;

class AdmissionGuide extends Component
{
    public $search = '';
    public $degreeType = 'bachelor';
    public $viewMode = 'all'; // all, fees, rates

    protected $queryString = ['search', 'degreeType', 'viewMode'];

    protected $listeners = ['openGuide'];

    public function openGuide($mode = 'all')
    {
        $this->viewMode = $mode;
        $this->search = '';
    }

    public function setDegree($type)
    {
        $this->degreeType = $type;
    }

    public function render()
    {
        $colleges = College::with(['majors' => function ($query) {
            $query->where('degree_type', $this->degreeType)
                  ->where('name', 'like', '%' . $this->search . '%');
        }])
        ->whereHas('majors', function ($query) {
            $query->where('degree_type', $this->degreeType)
                  ->where('name', 'like', '%' . $this->search . '%');
        })
        ->get();

        return view('livewire.admission-guide', [
            'colleges' => $colleges
        ]);
    }
}
