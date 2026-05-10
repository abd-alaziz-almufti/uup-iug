<x-layouts.app>
    <div class="relative min-h-screen w-full overflow-hidden bg-gradient-to-l from-[#a3c0ec] via-[#afc9f2] to-[#b1c9ee]">
        <div class="pointer-events-none absolute inset-0">
            <img
                src="https://www.figma.com/api/mcp/asset/942fa2b3-4b32-48aa-b5bd-7b0a8f026acd"
                alt=""
                className="h-full w-full object-cover opacity-60"
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
                            <img src="https://www.figma.com/api/mcp/asset/942fa2b3-4b32-48aa-b5bd-7b0a8f026acd" alt="" class="h-full w-full object-cover" />
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
                                    class="flex items-center justify-center gap-2 rounded-[15px] border border-white/80 px-6 py-3 font-tajawal text-base font-semibold"
                                >
                                    <span>أرسل إستفساراً</span>
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true" fill="currentColor">
                                        <path d="M21 6.5 12 13l-9-6.5V5l9 6 9-6v1.5Z" />
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    class="flex items-center justify-center gap-2 rounded-[15px] bg-[#00d300] px-6 py-3 font-tajawal text-base font-semibold text-white"
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
                        $admissionCards = [
                            [
                                'title' => 'الرسوم الدراسية',
                                'subtitle' => 'تمت الدراسة الفصلية',
                                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 3c-2.761 0-5 2.239-5 5 0 2.761 2.239 5 5 5 2.761 0 5-2.239 5-5 0-2.761-2.239-5-5-5Zm0 14c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4Z"/></svg>',
                                'rows' => [
                                    ['label' => 'كلية الطب البشري', 'value' => 'JD 50'],
                                    ['label' => 'كلية الهندسة', 'value' => 'JD 35'],
                                    ['label' => 'كلية تكنولوجيا المعلومات', 'value' => 'JD 25'],
                                    ['label' => 'كلية العلوم الصحية', 'value' => 'JD 25'],
                                ],
                                'action' => 'عرض جميع التكاليف',
                            ],
                            [
                                'title' => 'معدلات القبول',
                                'subtitle' => 'العام الدراسي 2025-2027',
                                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M4 19h16v2H4v-2Zm2-8h3v6H6v-6Zm5-4h3v10h-3V7Zm5 2h3v8h-3V9Z"/></svg>',
                                'rows' => [
                                    ['label' => 'كلية الطب البشري', 'value' => '+92%'],
                                    ['label' => 'كلية الهندسة', 'value' => '+85%'],
                                    ['label' => 'كلية تكنولوجيا المعلومات', 'value' => '+75%'],
                                    ['label' => 'كلية العلوم الصحية', 'value' => '+75%'],
                                ],
                                'action' => 'عرض جميع النسب',
                            ],
                            [
                                'title' => 'الكليات والتخصصات',
                                'subtitle' => '11 كليات - +40 تخصص',
                                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 2 2 7l10 5 10-5-10-5Zm0 7L2 4v6l10 5 10-5V4l-10 5Zm0 7-7.5-3.75V18L12 21l7.5-3v-5.75L12 16Z"/></svg>',
                                'rows' => [
                                    ['label' => 'كلية الطب البشري', 'value' => '4 تخصصات'],
                                    ['label' => 'كلية الهندسة', 'value' => '4 تخصصات'],
                                    ['label' => 'كلية تكنولوجيا المعلومات', 'value' => '4 تخصصات'],
                                    ['label' => 'كلية العلوم الصحية', 'value' => '4 تخصصات'],
                                ],
                                'action' => 'عرض جميع الكليات',
                            ],
                        ];
                    @endphp

                    <div class="mt-8 grid gap-6 lg:grid-cols-3">
                        @foreach($admissionCards as $card)
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
                                    @foreach($card['rows'] as $row)
                                        <div class="flex items-center justify-between py-2 text-sm">
                                            <span class="text-[#111827]">{{ $row['label'] }}</span>
                                            <span class="font-semibold text-[#007bff]">{{ $row['value'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <button
                                    type="button"
                                    class="mt-4 w-full rounded-full border border-[#007bff] px-3 py-2 text-sm font-semibold text-[#007bff]"
                                >
                                    {{ $card['action'] }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="mx-auto mt-12 grid w-full max-w-6xl gap-6 lg:grid-cols-[1.2fr_1fr]">
                    <div class="overflow-hidden rounded-[18px] bg-white/90 shadow-md">
                        <img src="https://www.figma.com/api/mcp/asset/661f030d-1cd7-4aae-87c6-6fc3261201a9" alt="" class="h-full w-full object-cover" />
                    </div>
                    <div class="rounded-[18px] bg-white/95 p-6 shadow-md">
                        <h3 class="font-tajawal text-xl font-bold text-[#0170d7]">عن الجامعة الإسلامية</h3>
                        <p class="mt-4 text-sm leading-7 text-[#3a4b60]">
                            تأسست الجامعة الإسلامية بغزة عام 1978، وهي مؤسسة أكاديمية رائدة تقدم برامج
                            تعليمية متنوعة في العلوم والآداب، وتتميز ببيئة تعليمية محفزة للطالبات والطلاب.
                        </p>

                        <div class="mt-5 grid grid-cols-2 gap-4 text-sm">
                            @php
                                $stats = [
                                    ['label' => 'منح', 'value' => '+200k'],
                                    ['label' => 'طالب', 'value' => '+20000'],
                                    ['label' => 'مبنى', 'value' => '11'],
                                    ['label' => 'تخصص', 'value' => '+40'],
                                    ['label' => 'تاريخ التأسيس', 'value' => '1978'],
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
    </div>
</x-layouts.app>
