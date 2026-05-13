<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Cache;
use App\Models\FAQ;

class GuidanceInformation extends Component
{
    public $activeTab = 'الكل';
    public $searchQuery = '';

    #[Locked] // ✅ يمنع التعديل من الـ frontend
    public $fixedCategory = null;

    #[Locked]
    public $title = 'المعلومات الارشادية';

    public function getFilterTabsProperty()
    {
        return array_keys(self::CATEGORY_MAP);
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

    public function mount(?string $fixedCategory = null, string $title = 'المعلومات الارشادية'): void
    {
        $this->fixedCategory = $fixedCategory;
        $this->title         = $title;

        // ✅ التحقق من أن fixedCategory موجودة في CATEGORY_MAP
        if ($fixedCategory && in_array($fixedCategory, self::CATEGORY_MAP, strict: true)) {
            $this->activeTab = $fixedCategory;
        }
    }



    public function getAllTopics()
    {
        return Cache::rememberForever('published_faqs_optimized', function () {
            return FAQ::where('status', 'published')
                ->select('id', 'question', 'answer', 'category')
                ->get()
                ->map(function ($item) {
                    $item->searchable = mb_strtolower(strip_tags($item->question . ' ' . $item['answer']));
                    return $item;
                })
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.guidance-information', [
            'topics' => $this->getAllTopics(),
            'filterTabs' => $this->filterTabs,
        ]);
    }
}
