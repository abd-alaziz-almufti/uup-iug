<div 
    x-data="{ 
        localActiveTab: '{{ $activeTab }}', 
        localSearch: '',
        categoryMap: {{ json_encode([
            'الكل' => null,
            'التسجيل' => 'التسجيل',
            'الاختبارات' => 'امتحانات',
            'علامات' => 'علامات',
            'مالي' => 'مالي',
            'متطلبات' => 'متطلبات',
            'عام' => 'عام',
        ]) }},
        shouldShow(faqCategory, searchableText) {
            const catFilter = this.categoryMap[this.localActiveTab];
            const matchesCategory = !catFilter || faqCategory === catFilter;
            
            const q = this.localSearch.toLowerCase().trim();
            if (!q) return matchesCategory;
            
            return matchesCategory && searchableText.includes(q);
        }
    }"
    dir="rtl" 
    class="w-full max-w-[1120px] rounded-2xl bg-[#bfdeff] p-6 shadow-[0_0_10px_0_#bfdeff]"
>
    <!-- Title -->
    <h3 class="mb-4 text-center font-tajawal text-2xl font-bold text-[#08152f]">
        {{ $title }}
    </h3>

    <!-- Search + Tabs -->
    <div class="rounded-2xl bg-white px-6 py-4">
        <!-- Search -->
        <div class="rounded-xl bg-[#bfdeff] px-2 py-2">
            <div class="flex items-center gap-3 rounded-xl bg-white px-4 py-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-black/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input 
                    x-model="localSearch"
                    type="text" 
                    placeholder="ابحث في المعلومات الارشادية..."
                    class="w-full bg-transparent font-tajawal text-sm font-semibold text-[#08152f] placeholder:text-black/40 focus:outline-none"
                />
                <button 
                    x-show="localSearch"
                    @click="localSearch = ''"
                    type="button"
                    class="shrink-0 text-black/40 transition-colors hover:text-black/70"
                    aria-label="مسح البحث"
                    style="display: none;"
                >
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Filter Tabs -->
        @if(!$fixedCategory)
        <div class="mt-4 flex flex-wrap justify-center gap-3">
            @foreach($filterTabs as $tab)
            <button 
                type="button" 
                @click="localActiveTab = '{{ $tab }}'"
                class="rounded-full px-5 py-1.5 font-tajawal text-sm font-extrabold shadow-[0_0_10px_0_#62abfb] transition-all duration-200"
                :class="localActiveTab === '{{ $tab }}' ? 'bg-[#1f7ce8] text-white scale-105' : 'bg-[#62abfb] text-white hover:bg-[#4a9af0]'"
            >
                {{ $tab }}
            </button>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Accordion List -->
    <div class="mt-6 space-y-3" id="faq-list">
        @foreach($topics as $item)
        <div 
            wire:key="faq-{{ $item['id'] }}"
            x-data="{ expanded: false }" 
            x-show="shouldShow('{{ $item['category'] }}', '{{ str_replace(["\r", "\n", "'", '"'], '', $item['searchable']) }}')"
            class="overflow-hidden rounded-xl border transition-all duration-200 faq-item"
            :class="expanded ? 'border-[#007bff]/30 bg-blue-50/50 shadow-sm' : 'border-gray-200 bg-white hover:bg-gray-50'"
            style="display: none;"
        >
            <button 
                type="button"
                @click="expanded = !expanded"
                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-right"
            >
                <span class="flex-1 font-tajawal text-[15px] font-bold text-[#08152f]">
                    {{ $item['question'] }}
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#007bff] transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div class="grid transition-all duration-300 ease-in-out" :class="expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                <div class="overflow-hidden">
                    <div class="border-t border-gray-200/60 px-5 pb-4 pt-3">
                        <div class="font-tajawal text-sm leading-relaxed text-[#475569]">
                            {!! $item['answer'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- No Results Message (handled by Alpine) -->
        <div 
            x-show="!$el.parentElement.querySelector('.faq-item[style*=\'display: block\'], .faq-item:not([style*=\'display: none\'])')"
            class="flex flex-col items-center gap-3 rounded-2xl bg-white/80 py-14 text-center"
            style="display: none;"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <p class="font-tajawal text-lg font-bold text-gray-400">
                لا توجد نتائج
            </p>
            <p class="font-tajawal text-sm text-gray-400">
                حاول تغيير كلمة البحث أو اختر تصنيف آخر
            </p>
        </div>
    </div>
</div>
