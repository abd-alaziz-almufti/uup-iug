<section class="space-y-6">
    <div class="rounded-2xl bg-[#bfdeff] p-6 shadow-[0_0_10px_0_#bfdeff]">
        @if($activeFaqCard)
            <div class="mt-6">
                <div class="mb-4 flex items-center justify-between rounded-2xl bg-white/70 px-4 py-3">
                    <h3 class="font-tajawal text-lg font-bold text-[#0f172a]">
                        {{ $activeFaqCard['title'] }}
                    </h3>
                    <button
                        type="button"
                        wire:click="handleBack"
                        class="rounded-xl bg-[#0056b3] px-4 py-2 font-tajawal text-sm font-bold text-white hover:bg-[#004a99]"
                    >
                        رجوع
                    </button>
                </div>
                <livewire:guidance-information 
                    :key="'faq-'.$activeFaqCard['id']"
                    :title="$activeFaqCard['title']"
                    :fixedCategory="$activeFaqCard['faqCategory']"
                />
            </div>
        @else
            @php
                $cardData = [
                    [
                        'id' => 'guide-new-student',
                        'title' => 'دليل الطالب الجديد',
                        'description' => 'كيف تختار تخصصك',
                        'icon' => asset('figma/guide-profile.png'),
                    ],
                    [
                        'id' => 'guide-registration-steps',
                        'title' => 'خطوات التسجيل',
                        'description' => 'شرح طريقة التسجيل للفصل الدراسي',
                        'icon' => asset('figma/guide-steps.png'),
                    ],
                    [
                        'id' => 'guide-choose-major',
                        'title' => 'اختيار التخصص',
                        'description' => 'كيف تختار تخصصك',
                        'icon' => asset('figma/guide-qa.png'),
                    ],
                    [
                        'id' => 'guide-faq',
                        'title' => 'الاسئلة الشائعة',
                        'description' => 'تعرف على الاسئلة الاكثر طرحا من الطلاب',
                        'icon' => asset('figma/guide-faq.png'),
                    ],
                    [
                        'id' => 'guide-videos',
                        'title' => 'فيديوهات تعليمية',
                        'description' => 'تعرف على المحتوى المرئي',
                        'icon' => asset('figma/guide-video.png'),
                    ],
                    [
                        'id' => 'guide-info',
                        'title' => 'معلومات ارشادية',
                        'description' => 'تعرف على المزيد من الارشادات الجامعية',
                        'icon' => asset('figma/guide-info.png'),
                    ],
                ];
            @endphp

            <div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($cardData as $card)
                    <div class="flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-[0_0_8px_0_rgba(255,255,255,0.9)] transition-all duration-200">
                        <div class="flex flex-1 items-center justify-between gap-3 px-4 py-4">
                            <div class="text-right">
                                <h3 class="font-tajawal text-base font-bold text-black">
                                    {{ $card['title'] }}
                                </h3>
                                <p class="mt-1 text-xs font-medium text-black/50">
                                    {{ $card['description'] }}
                                </p>
                            </div>
                            <div class="flex h-16 w-20 items-center justify-center">
                                <img
                                    src="{{ $card['icon'] }}"
                                    alt="{{ $card['title'] }}"
                                    class="h-full w-full object-contain"
                                />
                            </div>
                        </div>
                        <button
                            type="button"
                            wire:click="handleInfoCardClick('{{ $card['id'] }}')"
                            class="flex items-center justify-center gap-2 py-2 text-sm font-bold bg-[#62abfb] text-black hover:bg-[#4a9af0] transition-colors"
                        >
                            تعرف على المزيد
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- New Student Banner -->
            <div class="mt-6 flex flex-col items-center gap-6 rounded-2xl bg-white px-6 py-5 shadow-[0_0_10px_0_#62abfb] md:flex-row">
                <div class="flex-1 text-right">
                    <h3 class="font-tajawal text-lg font-bold text-black">
                        دليل الطالب الجديد
                    </h3>
                    <div class="mt-2 space-y-2 text-sm text-black/50">
                        <p>تعرف على المزيد من الارشادات الخاصة بالطلبة الجدد</p>
                    </div>
                </div>
                <div class="relative h-32 w-48 overflow-hidden rounded-xl">
                    <img
                        src="{{ asset('figma/guide-banner.png') }}"
                        alt="دليل الطالب الجديد"
                        class="h-full w-full object-cover"
                    />
                    <div class="absolute inset-0 bg-white/50"></div>
                    <img
                        src="{{ asset('figma/guide-profile.png') }}"
                        alt="UUP"
                        class="absolute left-1/2 top-1/2 h-16 w-16 -translate-x-1/2 -translate-y-1/2 opacity-60"
                    />
                </div>
            </div>
        @endif
    </div>
</section>
