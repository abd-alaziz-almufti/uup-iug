<x-layouts.app>
    <div x-data="{ showLogin: false, showMobileMenu: false }" class="flex min-h-screen w-full flex-col">
        <!-- Top Navigation Header -->
        <header class="w-full bg-white/10 backdrop-blur-[1px]">
            <x-top-bar />

            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-3 px-4 pb-4 pt-2 md:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/70 bg-white/70 p-1 shadow-sm sm:h-14 sm:w-14 lg:h-20 lg:w-20">
                        <img src="{{ asset('logo2.png') }}" alt="IUG Logo" class="h-full w-full object-contain" />
                    </div>
                    <div class="min-w-0 text-right leading-tight">
                        <p class="truncate font-tajawal text-[20px] font-black text-gray-900 sm:text-xs md:text-[16px]">
                            المنصة الجامعية الموحدة - الجامعة الإسلامية بغزة
                        </p>
                        <p class="truncate font-inter text-[10px] font-bold text-[#111827] sm:text-xs lg:text-sm">
                            UUP - Islamic University of Gaza
                        </p>
                    </div>
                </div>

                <nav class="hidden items-center gap-4 lg:flex xl:gap-6">
                    <a href="#" class="whitespace-nowrap px-6 py-8 font-tajawal text-base font-bold text-gray-900 transition-all duration-300 hover:bg-[#178BFF] hover:text-white">الرئيسية</a>
                    <a href="#" class="whitespace-nowrap px-6 py-8 font-tajawal text-base font-bold text-gray-900 transition-all duration-300 hover:bg-[#178BFF] hover:text-white">عن المنصة</a>
                    <a href="#" class="whitespace-nowrap px-6 py-8 font-tajawal text-base font-bold text-gray-900 transition-all duration-300 hover:bg-[#178BFF] hover:text-white">الاسئلة الشائعة</a>
                    <a href="#" class="whitespace-nowrap px-6 py-8 font-tajawal text-base font-bold text-gray-900 transition-all duration-300 hover:bg-[#178BFF] hover:text-white">تواصل معنا</a>
                </nav>

                <div class="flex items-center gap-3 lg:hidden">
                    <button 
                        @click="showLogin = true"
                        class="shrink-0 whitespace-nowrap rounded-xl bg-[#007BFF] px-3 py-1.5 font-tajawal text-xs font-bold text-white shadow transition-colors hover:bg-blue-600 sm:px-4 sm:py-2 sm:text-sm"
                    >
                        تسجيل دخول
                    </button>
                    <button 
                        type="button" 
                        @click="showMobileMenu = !showMobileMenu"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-gray-800 shadow-sm"
                        aria-label="فتح القائمة"
                    >
                        <svg x-show="!showMobileMenu" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M3 12h18" />
                            <path d="M3 18h18" />
                        </svg>
                        <svg x-show="showMobileMenu" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="showMobileMenu" style="display: none;" class="border-t border-white/30 bg-white/70 px-4 py-4 backdrop-blur-md lg:hidden">
                <nav class="flex flex-col items-start gap-3">
                    <a href="#" class="font-tajawal text-base font-bold text-[#178BFF]" @click="showMobileMenu = false">الرئيسية</a>
                    <a href="#" class="font-tajawal text-base text-gray-800" @click="showMobileMenu = false">عن المنصة</a>
                    <a href="#" class="font-tajawal text-base text-gray-800" @click="showMobileMenu = false">الاسئلة الشائعة</a>
                    <a href="#" class="font-tajawal text-base text-gray-800" @click="showMobileMenu = false">تواصل معنا</a>
                </nav>
            </div>
        </header>

        <main class="relative flex-1 w-full px-4 pb-8 pt-5 md:px-6 md:pt-2 lg:px-8 lg:pb-10">
            <div class="pointer-events-none absolute inset-0">
                <img src="{{ asset('background.png') }}" alt="" class="h-full w-full object-cover opacity-65" />
            </div>

            <div class="relative mx-auto flex w-full max-w-[1240px] flex-col items-center">
                <!-- Hero section -->
                <div class="max-w-4xl text-center">
                    <h2 class="mb-2 font-tajawal text-4xl font-bold leading-tight text-[#08152f] lg:text-[40px]">
                        مرحباً بكم في مركز الاتصال الجامعي الموحد
                    </h2>
                    <p class="mb-8 font-tajawal text-xl font-semibold text-[#178BFF]">
                        منصة موحّدة تجمع خدمات واستفسارات الطلبة في مكان واحد
                    </p>
                </div>

                <!-- Featured cards (دخول) -->
                <div class="mb-10 grid w-full max-w-[1080px] grid-cols-1 justify-items-center gap-6 md:grid-cols-3">
                    <!-- دخول طالب مسجل -->
                    <button 
                        type="button" 
                        @click="showLogin = true"
                        class="relative h-[230px] w-full max-w-[340px] cursor-pointer overflow-hidden rounded-[24px] shadow-lg"
                    >
                        <img src="{{ asset('دخول طالب مسجل.png') }}" alt="دخول طالب مسجل" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="pointer-events-none absolute bottom-0 left-0 flex h-[70px] w-full items-center justify-center bg-[#1f78d5]/72 backdrop-blur-sm">
                            <span class="font-tajawal text-[25px] font-bold text-white">
                                دخول طالب مسجل
                            </span>
                        </div>
                    </button>
                    <!-- دخول طالب جديد -->
                    <button type="button" class="relative h-[230px] w-full max-w-[340px] cursor-pointer overflow-hidden rounded-[24px] shadow-lg">
                        <img src="{{ asset('دخول طالب جديد.png') }}" alt="دخول طالب جديد" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="pointer-events-none absolute bottom-0 left-0 flex h-[70px] w-full items-center justify-center bg-[#1f78d5]/72 backdrop-blur-sm">
                            <span class="font-tajawal text-[25px] font-bold text-white">دخول طالب جديد</span>
                        </div>
                    </button>
                    <!-- دخول أستاذ جامعي -->
                    <button type="button" class="relative h-[230px] w-full max-w-[340px] cursor-pointer overflow-hidden rounded-[24px] shadow-lg">
                        <img src="{{ asset('دخول استاذ جامعي.png') }}" alt="دخول أستاذ جامعي" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="pointer-events-none absolute bottom-0 left-0 flex h-[70px] w-full items-center justify-center bg-[#1f78d5]/72 backdrop-blur-sm">
                            <span class="font-tajawal text-[25px] font-bold text-white">دخول أستاذ جامعي</span>
                        </div>
                    </button>
                </div>

                <!-- ماذا يقدم مركز الاتصال -->
                <h3 class="mb-6 font-tajawal text-4xl font-bold text-[#08152f]">
                    ماذا يقدم مركز الاتصال ؟
                </h3>

                <div class="mb-12 grid w-full max-w-[1120px] grid-cols-2 justify-items-center gap-6 lg:grid-cols-4">
                    <div class="relative h-[190px] w-full max-w-[250px] overflow-hidden rounded-[22px] shadow-md">
                        <img src="{{ asset('نقطة دخول موحدة.png') }}" alt="نقطة دخول موحدة" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="absolute bottom-0 left-0 flex h-14 w-full items-center justify-center bg-[#1f78d5]/70 px-2 backdrop-blur-sm">
                            <span class="text-center font-tajawal text-base font-bold text-white">نقطة دخول موحدة</span>
                        </div>
                    </div>
                    <div class="relative h-[190px] w-full max-w-[250px] overflow-hidden rounded-[22px] shadow-md">
                        <img src="{{ asset('تواصل مباشر مع الاقسام.png') }}" alt="تواصل مباشر مع الأقسام" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="absolute bottom-0 left-0 flex h-14 w-full items-center justify-center bg-[#1f78d5]/70 px-2 backdrop-blur-sm">
                            <span class="text-center font-tajawal text-base font-bold text-white">تواصل مباشر مع الأقسام</span>
                        </div>
                    </div>
                    <div class="relative h-[190px] w-full max-w-[250px] overflow-hidden rounded-[22px] shadow-md">
                        <img src="{{ asset('دعم الطلبة الجدد.png') }}" alt="دعم الطلبة الجدد" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="absolute bottom-0 left-0 flex h-14 w-full items-center justify-center bg-[#1f78d5]/70 px-2 backdrop-blur-sm">
                            <span class="text-center font-tajawal text-base font-bold text-white">دعم الطلبة الجدد</span>
                        </div>
                    </div>
                    <div class="relative h-[190px] w-full max-w-[250px] overflow-hidden rounded-[22px] shadow-md">
                        <img src="{{ asset('متابعة الطلبات.png') }}" alt="متابعة الطلبات إلكترونيا" class="absolute inset-0 h-full w-full object-cover" />
                        <div class="absolute bottom-0 left-0 flex h-14 w-full items-center justify-center bg-[#1f78d5]/70 px-2 backdrop-blur-sm">
                            <span class="text-center font-tajawal text-base font-bold text-white">متابعة الطلبات إلكترونيا</span>
                        </div>
                    </div>
                </div>

                <!-- Guidance Information Livewire Component -->
                <livewire:guidance-information />

            </div>
        </main>

        <x-footer />

        <!-- Login Modal component (with alpine state managed by parent) -->
        <livewire:auth.login-modal />
    </div>
</x-layouts.app>
