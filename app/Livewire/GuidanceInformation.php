<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class GuidanceInformation extends Component
{
    public $activeTab = 'الكل';
    public $searchQuery = '';
    public $fixedCategory = null;
    public $title = 'المعلومات الارشادية';

    public function mount($fixedCategory = null, $title = 'المعلومات الارشادية')
    {
        $this->fixedCategory = $fixedCategory;
        $this->title = $title;
        
        if ($this->fixedCategory) {
            $this->activeTab = $this->fixedCategory;
        }
    }

    private const CATEGORY_MAP = [
        "الكل" => null,
        "التسجيل" => "التسجيل",
        "الاختبارات" => "امتحانات",
        "علامات" => "علامات",
        "مالي" => "مالي",
        "متطلبات" => "متطلبات",
        "عام" => "عام",
    ];

    #[Computed]
    public function filteredTopics()
    {
        $allFaqs = \Illuminate\Support\Facades\Cache::rememberForever('published_faqs', function () {
            return \App\Models\FAQ::where('status', 'published')
                ->select('id', 'question', 'answer', 'category')
                ->get()
                ->toArray();
        });

        $categoryValue = self::CATEGORY_MAP[$this->activeTab] ?? null;
        $q = trim(mb_strtolower($this->searchQuery));

        return array_filter($allFaqs, function($faq) use ($categoryValue, $q) {
            $matchesCategory = !$categoryValue || $faq['category'] === $categoryValue;
            if (!$q) return $matchesCategory;

            $searchable = mb_strtolower($faq['question'] . ' ' . $faq['answer']);
            return $matchesCategory && str_contains($searchable, $q);
        });
    }

    public function render()
    {
        return view('livewire.guidance-information', [
            'topics' => $this->filteredTopics(),
            'filterTabs' => array_keys(self::CATEGORY_MAP),
        ]);
    }
}
