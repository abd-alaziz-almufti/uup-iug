<x-layouts.app>
    <div 
        x-data="{ 
            showInquiry: false,
            showGuide: false,
            guideTitle: 'دليل القبول الشامل'
        }"
        class="relative min-h-screen w-full overflow-hidden bg-gradient-to-l from-[#a3c0ec] via-[#afc9f2] to-[#b1c9ee]"
    >
        <div class="pointer-events-none absolute inset-0">
            <img
                src="{{ asset('background.png') }}"
                alt=""
                class="h-full w-full object-cover opacity-60"
            />
        </div>

        <div class="relative flex min-h-screen flex-col">
            <header class="border-b border-white/50 bg-white/15 backdrop-blur-sm">
                <x-top-bar />
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 md:px-6">
                    <div class="flex items-center gap-3" dir="rtl">
                        <img
                            src="{{ asset('logo2.png') }}"
                            alt="IUG Logo"
                            class="h-12 w-12 rounded-full object-contain md:h-16 md:w-16"
                        />
                        <div class="text-right">
                            <p class="font-tajawal text-sm font-extrabold text-[#111827] md:text-base">
                                المنصة الجامعية الموحدة-الجامعة الإسلامية بغزة
                            </p>
                            <p class="font-inter text-xs font-bold text-[#111827]">
                                UUP - Islamic University of Gaza
                            </p>
                        </div>
                    </div>

                    <div class="text-center">
                        <h1 class="font-tajawal text-lg font-extrabold text-[#08152f] md:text-2xl">
                            مركز الاتصال الجامعي الموحد
                        </h1>
                        <p class="mt-1 font-tajawal text-xs font-semibold text-[#34495ecc] md:text-sm">
                            منصة موحّدة تجمع خدمات واستفسارات الطلبة في مكان واحد
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a
                            href="/"
                            class="rounded-full border border-white/60 bg-white/50 px-4 py-1 text-sm font-bold text-[#1e3a8a]"
                        >
                            رجوع
                        </a>
                    </div>
                </div>
            </header>

            <main class="relative flex-1 px-4 pb-10 pt-8 md:px-6 lg:px-8" dir="rtl">
                <section class="mx-auto w-full max-w-6xl">
                    <div class="relative overflow-hidden rounded-[20px] bg-[#007bff] px-6 py-8 text-white shadow-lg md:px-10 md:py-10">
                        <div class="absolute inset-0 opacity-25">
                            <img src="{{ asset('background.png') }}" alt="" class="h-full w-full object-cover" />
                        </div>

                        <div class="relative flex flex-col items-center gap-6 md:flex-row md:items-center md:justify-between">
                            <div class="text-center md:text-right">
                                <h2 class="font-tajawal text-2xl font-bold md:text-3xl">
                                    ابدأ رحلتك الاكاديمية بثقة
                                </h2>
                                <p class="mt-3 max-w-2xl font-tajawal text-base font-light md:text-lg">
                                    ستجد هنا كل ما تحتاجه كطالب جديد - معلومات القبول، الكليات، الرسوم، والمنح -في مكان واحد
                                </p>
                            </div>

                            <div class="flex flex-col items-center gap-3 sm:flex-row">
                                <button
                                    type="button"
                                    @click="showInquiry = true"
                                    class="flex items-center justify-center gap-2 rounded-[15px] border border-white/80 px-6 py-3 font-tajawal text-base font-semibold transition-transform hover:scale-105 active:scale-95"
                                >
                                    <span>أرسل إستفساراً</span>
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true" fill="currentColor">
                                        <path d="M21 6.5 12 13l-9-6.5V5l9 6 9-6v1.5Z" />
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    class="flex items-center justify-center gap-2 rounded-[15px] bg-[#00d300] px-6 py-3 font-tajawal text-base font-semibold text-white transition-transform hover:scale-105 active:scale-95"
                                >
                                    <span>قم بالتسجيل الآن</span>
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true" fill="currentColor">
                                        <path d="M12 2 4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mx-auto mt-10 w-full max-w-6xl">
                    <div class="flex items-center gap-4">
                        <h3 class="font-tajawal text-2xl font-medium text-[#111827]">
                            معلومات القبول
                        </h3>
                        <div class="h-px flex-1 bg-[#8cbcff]" />
                    </div>

                    @php
                        // جلب الكليات مع تخصصاتها لضمان مطابقة البيانات
                        $colleges = \App\Models\Department::where('type', 'College')->with('majors')->get();
                        
                        $cardsData = [
                            [
                                'id' => 'fees',
                                'title' => 'الرسوم الدراسية',
                                'subtitle' => 'ثمن الدراسة الفصلية',
                                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>',
                                'action_text' => 'عرض جميع التكاليف',
                                'items' => $colleges->map(fn($c) => [
                                    'label' => $c->name,
                                    'value' => 'JD ' . (int)($c->majors->where('degree_type', 'bachelor')->first()?->credit_hour_price ?? 0)
                                ])
                            ],
                            [
                                'id' => 'rates',
                                'title' => 'معدلات القبول',
                                'subtitle' => 'العام الدراسي 2025-2027',
                                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z"/></svg>',
                                'action_text' => 'عرض جميع النسب',
                                'items' => $colleges->map(fn($c) => [
                                    'label' => $c->name,
                                    'value' => '+' . (int)($c->majors->where('degree_type', 'bachelor')->first()?->acceptance_rate ?? 0) . '%'
                                ])
                            ],
                            [
                                'id' => 'all',
                                'title' => 'الكليات والتخصصات',
                                'subtitle' => '11 كليات - +40 تخصص',
                                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM3.89 9L12 4.58 20.11 9 12 13.42 3.89 9zM5 12.06l7 3.82 7-3.82v3.12l-7 3.82-7-3.82v-3.12z"/></svg>',
                                'action_text' => 'عرض جميع الكليات',
                                'items' => $colleges->map(fn($c) => [
                                    'label' => $c->name,
                                    'value' => $c->majors->count() . ' تخصصات'
                                ])
                            ],
                        ];
                    @endphp

                    <div class="mt-8 grid gap-6 lg:grid-cols-3">
                        @foreach($cardsData as $card)
                            <div class="rounded-[15px] border border-[#007bff] bg-white/90 p-5 shadow-sm">
                                <div class="flex items-center gap-3 text-[#007bff]">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#e7f1ff]">
                                        {!! $card['icon'] !!}
                                    </div>
                                    <div>
                                        <h4 class="font-tajawal text-lg font-semibold text-[#111827]">
                                            {{ $card['title'] }}
                                        </h4>
                                        <p class="text-xs text-[#61708a]">{{ $card['subtitle'] }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 divide-y divide-[#cfe1ff]">
                                    @foreach($card['items'] as $row)
                                        <div class="flex items-center justify-between py-2 text-sm">
                                            <span class="text-[#111827]">{{ $row['label'] }}</span>
                                            <span class="font-semibold text-[#007bff]">{{ $row['value'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <button
                                    type="button"
                                    @click="
                                        showGuide = true; 
                                        guideTitle = '{{ $card['title'] }} الشامل';
                                        $dispatch('openGuide', { mode: '{{ $card['id'] }}' })
                                    "
                                    class="mt-4 w-full rounded-full border border-[#007bff] px-3 py-2 text-sm font-semibold text-[#007bff] transition-colors hover:bg-[#007bff] hover:text-white"
                                >
                                    {{ $card['action_text'] }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="mx-auto mt-12 grid w-full max-w-6xl gap-6 lg:grid-cols-[1.2fr_1fr]">
                    <div class="overflow-hidden rounded-[18px] bg-white/90 shadow-md">
                        <img src="{{ asset('background.png') }}" alt="" class="h-full w-full object-cover" />
                    </div>
                    <div class="rounded-[18px] bg-white/95 p-6 shadow-md">
                        <h3 class="font-tajawal text-xl font-bold text-[#0170d7]">عن الجامعة الإسلامية</h3>
                        <p class="mt-4 text-sm leading-7 text-[#3a4b60]">
                            {{ App\Models\Setting::get('about_university', 'تأسست الجامعة الإسلامية بغزة عام 1978...') }}
                        </p>

                        <div class="mt-5 grid grid-cols-2 gap-4 text-sm">
                            @php
                                $stats = [
                                    ['label' => 'منح', 'value' => App\Models\Setting::get('stats_scholarships', '+200k')],
                                    ['label' => 'طالب', 'value' => App\Models\Setting::get('stats_students', '+20000')],
                                    ['label' => 'مبنى', 'value' => App\Models\Setting::get('stats_buildings', '11')],
                                    ['label' => 'تخصص', 'value' => App\Models\Setting::get('stats_majors', '+40')],
                                    ['label' => 'تاريخ التأسيس', 'value' => App\Models\Setting::get('stats_founded_at', '1978')],
                                ];
                            @endphp
                            @foreach($stats as $item)
                                <div class="flex items-center justify-between rounded-lg bg-[#f4f8ff] px-3 py-2">
                                    <span class="text-[#5b6b82]">{{ $item['label'] }}</span>
                                    <span class="font-bold text-[#111827]">{{ $item['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </main>

            <x-footer />
        </div>

        <!-- Inquiry Modal -->
        <div 
            x-show="showInquiry" 
            x-transition.opacity
            style="display: none;"
            class="fixed inset-0 z-[150] flex items-center justify-center px-4 py-8 bg-[#0f172a]/50 backdrop-blur-sm"
            @click="showInquiry = false"
        >
            <div 
                class="relative w-full max-w-4xl overflow-hidden rounded-[32px] bg-white shadow-2xl"
                @click.stop
            >
                <!-- Close Button -->
                <button 
                    @click="showInquiry = false"
                    class="absolute left-6 top-6 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-2xl font-bold text-gray-500 transition-colors hover:bg-gray-200 hover:text-gray-800"
                >
                    ×
                </button>

                <!-- Scrollable Content -->
                <div class="max-h-[90vh] overflow-y-auto p-2">
                    <livewire:contact-form />
                </div>
            </div>
        </div>

        <!-- Admission Guide Modal -->
        <div 
            x-show="showGuide" 
            x-transition.opacity
            style="display: none;"
            class="fixed inset-0 z-[150] flex items-center justify-center px-4 py-8 bg-[#0f172a]/50 backdrop-blur-sm"
            @click="showGuide = false"
        >
            <div 
                class="relative w-full max-w-5xl overflow-hidden rounded-[32px] bg-white shadow-2xl"
                @click.stop
            >
                <!-- Header -->
                <div class="border-b border-gray-100 px-8 py-6 flex items-center justify-between">
                    <div>
                        <h3 class="font-tajawal text-2xl font-bold text-[#08152f]" x-text="guideTitle"></h3>
                        <p class="text-sm text-gray-500 font-tajawal">استكشف التخصصات، نسب القبول، وسعر الساعة الدراسية</p>
                    </div>
                    <button 
                        @click="showGuide = false"
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-2xl font-bold text-gray-500 transition-colors hover:bg-gray-200 hover:text-gray-800"
                    >
                        ×
                    </button>
                </div>

                <!-- Scrollable Content -->
                <div class="max-h-[75vh] overflow-y-auto p-8 pt-4">
                    <livewire:admission-guide />
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-100 px-8 py-4 bg-gray-50 flex justify-end">
                    <button 
                        @click="showGuide = false"
                        class="rounded-xl bg-gray-200 px-6 py-2 font-tajawal text-sm font-bold text-gray-700 transition-colors hover:bg-gray-300"
                    >
                        إغلاق
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
