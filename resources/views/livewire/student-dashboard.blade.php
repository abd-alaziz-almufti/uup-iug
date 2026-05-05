<div class="relative flex min-h-screen w-full flex-col bg-[#dcebff] md:h-screen md:overflow-hidden" dir="rtl">
    <header class="border-b border-white/40 bg-white/20 px-4 py-3 backdrop-blur-sm lg:px-8">
        <div class="mx-auto w-full max-w-7xl">
            <x-top-bar />
        </div>
    </header>

    <main class="relative w-full px-4 py-4 md:flex md:h-full md:flex-1 md:flex-col md:overflow-hidden">
        <!-- Dashboard Header Row -->
        <div class="grid min-h-[20px] grid-cols-1 items-center gap-4 border border-white/40 bg-white/10 px-4 py-5 backdrop-blur-sm md:grid-cols-[auto_1fr_auto] md:gap-6" dir="ltr">
            <!-- Logo side -->
            <div class="flex items-center gap-4 justify-self-center md:justify-self-start" dir="rtl">
                <img src="{{ asset('logo2.png') }}" alt="IUG Logo" class="h-10 w-10 rounded-full object-contain sm:h-12 sm:w-12 md:h-16 md:w-16 lg:h-20 lg:w-20" />
                <div class="text-right">
                    <p class="whitespace-nowrap text-[13px] font-tajawal font-extrabold text-[#111827]">
                        المنصة الجامعية الموحدة - الجامعة الإسلامية بغزة
                    </p>
                    <p class="mt-1 whitespace-nowrap text-left text-[12px] font-inter font-bold text-[#111827]" dir="ltr">
                        UUP - Islamic University of Gaza
                    </p>
                </div>
            </div>

            <!-- Title center -->
            <div class="text-center" dir="rtl">
                <h1 class="font-tajawal text-2xl font-extrabold text-[#08152f] md:text-3xl xl:text-4xl">
                    مركز الاتصال الجامعي الموحد
                </h1>
                <p class="dashboard-subtitle mt-3 hidden font-tajawal text-base leading-loose text-[#5b6878] md:block xl:text-2xl">
                    منصة موحدة تجمع خدمات الطلبة في مكان واحد
                </p>
            </div>

            <!-- Profile side -->
            <div class="justify-self-center md:justify-self-end">
                <div class="rounded-[18px] border border-white/60 bg-white/80 px-3 py-2 shadow-sm">
                    <div class="flex items-center justify-between gap-3" dir="rtl">
                        <div class="h-[56px] w-[56px] shrink-0 rounded-full bg-[#69aaf5]"></div>
                        <div class="text-right">
                            <p class="font-tajawal text-[16px] font-semibold text-[#1f2937]">
                                {{ auth()->user()->name ?? 'محمد عبد الله احمد' }}
                            </p>
                            <p class="mt-1 font-inter text-[12px] font-medium text-[#1f2937]" dir="ltr">
                                ID: {{ auth()->user()->university_id ?? '120150454' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 flex flex-col gap-4 md:min-h-0 md:flex-1 md:flex-row md:items-start md:overflow-hidden" dir="rtl">
            
            <!-- Sidebar -->
            <div class="h-[445px] w-full shrink-0 md:h-full md:w-[320px] md:basis-[320px] md:flex-shrink-0">
                <aside class="relative h-full w-full border border-white/60 bg-white/30 p-4 shadow-[0_14px_30px_rgba(15,23,42,0.12)] backdrop-blur-md">
                    <div class="pointer-events-none absolute inset-y-6 right-0 w-[30px] rounded-bl-[24px] rounded-tl-[24px] bg-gradient-to-b from-[#2f86ff]/75 via-[#3fa2ff]/55 to-transparent"></div>

                    <div class="relative z-10 flex h-full flex-col pr-6">
                        <div class="flex-1 space-y-2">
                            @php
                                $menuItems = [
                                    ['id' => 'home', 'label' => 'الرئيسية'],
                                    ['id' => 'academic', 'label' => 'الخدمات الأكاديمية'],
                                    ['id' => 'inquiries', 'label' => 'الاستفسارات'],
                                    ['id' => 'guidance', 'label' => 'مركز الإرشاد'],
                                    ['id' => 'department', 'label' => 'التواصل مع دائرة'],
                                ];
                            @endphp

                            @foreach($menuItems as $item)
                                <button 
                                    type="button" 
                                    wire:click="setSection('{{ $item['id'] }}')"
                                    class="relative w-full rounded-[14px] px-3 py-1.5 text-right font-tajawal text-[16px] font-bold transition-all {{ $activeSection === $item['id'] ? 'bg-white text-[#111827] shadow-[0_8px_16px_rgba(15,23,42,0.12)]' : 'text-[#1f2937] hover:bg-white/70' }}"
                                >
                                    @if($activeSection === $item['id'])
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#007bff]">
                                            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M15 6l-6 6 6 6" />
                                            </svg>
                                        </span>
                                    @endif
                                    {{ $item['label'] }}
                                </button>
                            @endforeach
                        </div>

                        <div class="mb-4 mt-3">
                            <button 
                                type="button" 
                                wire:click="logout"
                                class="w-full rounded-lg border border-white/70 bg-white/90 px-3 py-2 text-right font-tajawal text-sm font-semibold text-[#374151] shadow-sm transition-colors hover:bg-gray-100"
                            >
                                تسجيل خروج
                            </button>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Left content area -->
            <section class="dashboard-content flex-1 w-full min-w-0 border border-white/40 bg-white/10 backdrop-blur-sm md:h-full md:overflow-y-auto">
                <div class="p-4 md:p-6" dir="rtl">
                    
                    @if($activeSection === 'home')
                        @php
                            $dashboardCards = [
                                ['id' => 'guidance', 'label' => 'مركز الإرشاد', 'image' => 'دخول استاذ جامعي.png'],
                                ['id' => 'inquiries', 'label' => 'الاستفسارات', 'image' => 'دخول طالب جديد.png'],
                                ['id' => 'academic', 'label' => 'الخدمات الأكاديمية', 'image' => 'دخول طالب مسجل.png'],
                                ['id' => null, 'label' => 'التواصل مع مدرس', 'image' => 'دخول استاذ جامعي.png'],
                                ['id' => null, 'label' => 'التواصل مع الكلية', 'image' => 'دخول طالب جديد.png'],
                                ['id' => 'department', 'label' => 'التواصل مع دائرة', 'image' => 'دخول طالب مسجل.png'],
                            ];
                        @endphp
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3" dir="ltr">
                            @foreach($dashboardCards as $card)
                                <button 
                                    type="button" 
                                    @if($card['id']) wire:click="setSection('{{ $card['id'] }}')" @endif
                                    class="group relative mx-auto h-[230px] w-full max-w-[440px] overflow-hidden rounded-[26px] border border-[#d8d8d8] shadow-[0_4px_10px_rgba(0,0,0,0.25)] transition-all duration-300 hover:scale-105 hover:shadow-[0_8px_25px_rgba(0,123,255,0.4)] md:h-[220px] md:max-w-none xl:h-[250px]"
                                >
                                    <img src="{{ asset($card['image']) }}" alt="{{ $card['label'] }}" class="dashboard-card-image absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                    <div class="absolute bottom-0 left-0 right-0 h-[78px] border border-[#d8d8d8] bg-[#007bff]/50 transition-colors duration-300 group-hover:bg-[#0056b3]/70 md:h-[78px] xl:h-[86px]"></div>
                                    <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1 md:bottom-5 xl:bottom-6">
                                        <span class="font-tajawal text-lg font-semibold text-white md:text-xl">{{ $card['label'] }}</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @if($activeSection === 'academic')
                        <div>
                            <div class="mb-4 flex items-center justify-between rounded-2xl bg-white/70 px-4 py-3">
                                <h2 class="font-tajawal text-lg font-bold text-[#0f172a]">الخدمات الأكاديمية</h2>
                                <button type="button" wire:click="setSection('home')" class="rounded-xl bg-[#0056b3] px-4 py-2 font-tajawal text-sm font-bold text-white hover:bg-[#004a99]">اغلاق</button>
                            </div>
                            <x-academic-services />
                        </div>
                    @endif

                    @if($activeSection === 'inquiries')
                        <div>
                            <div class="mb-4 flex items-center justify-between rounded-2xl bg-white/70 px-4 py-3">
                                <h2 class="font-tajawal text-lg font-bold text-[#0f172a]">الاستفسارات</h2>
                                <button type="button" wire:click="setSection('home')" class="rounded-xl bg-[#0056b3] px-4 py-2 font-tajawal text-sm font-bold text-white hover:bg-[#004a99]">اغلاق</button>
                            </div>
                            <livewire:inquiries wire:key="inquiries-panel" />
                        </div>
                    @endif

                    @if($activeSection === 'guidance')
                        <div>
                            <div class="mb-4 flex items-center justify-between rounded-2xl bg-white/70 px-4 py-3">
                                <h2 class="font-tajawal text-lg font-bold text-[#0f172a]">مركز الإرشاد</h2>
                                <button type="button" wire:click="setSection('home')" class="rounded-xl bg-[#0056b3] px-4 py-2 font-tajawal text-sm font-bold text-white hover:bg-[#004a99]">اغلاق</button>
                            </div>
                            <livewire:guidance-information />
                        </div>
                    @endif

                    @if($activeSection === 'department')
                        <div>
                            <div class="mb-4 flex items-center justify-between rounded-2xl bg-white/70 px-4 py-3">
                                <h2 class="font-tajawal text-lg font-bold text-[#0f172a]">التواصل مع دائرة</h2>
                                <button type="button" wire:click="setSection('home')" class="rounded-xl bg-[#0056b3] px-4 py-2 font-tajawal text-sm font-bold text-white hover:bg-[#004a99]">اغلاق</button>
                            </div>
                            <livewire:contact-department />
                        </div>
                    @endif

                </div>
            </section>
        </div>
    </main>
    <x-footer />
</div>
