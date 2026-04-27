<section 
    class="rounded-2xl bg-[#e1efff] p-6 shadow-[0_0_10px_5px_#bfdeff]"
    x-data="{ 
        showModal: false, 
        activeDept: null, 
        departments: @js($departmentsData) 
    }"
>
    <!-- Department Cards Grid -->
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
        <template x-for="dept in departments" :key="dept.id">
            <button 
                type="button" 
                @click="activeDept = dept; showModal = true"
                class="relative flex h-36 w-full items-center justify-between overflow-hidden rounded-2xl bg-white px-4 text-right shadow-[0_0_8px_0_rgba(255,255,255,0.9)] transition-transform hover:scale-[1.02] duration-200"
            >
                <div class="text-right">
                    <h3 class="font-tajawal text-base font-bold text-black" x-text="dept.title"></h3>
                </div>
                <div class="relative flex h-full w-32 items-center justify-center">
                    <div class="absolute inset-y-1 left-0 right-0 rounded-[22px] bg-[#bfdeff]"></div>
                    <img :src="'{{ asset('') }}' + dept.image" :alt="dept.title"
                        class="relative h-24 w-24 object-contain" />
                </div>
            </button>
        </template>
    </div>

    <!-- Dynamic Department Contact Modal (Teleported to Body) -->
    <template x-teleport="body">
        <div 
            x-show="showModal" 
            x-cloak
            class="fixed inset-0 z-[200] flex items-center justify-center px-4 py-8"
            role="dialog"
            aria-modal="true"
        >
            <!-- Backdrop -->
            <div 
                x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="showModal = false"
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"
            ></div>

            <!-- Modal Content -->
            <div 
                x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative z-[201] flex max-h-[calc(100vh-4rem)] w-full max-w-4xl flex-col overflow-hidden rounded-[28px] border border-white/60 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.3)]"
            >
                <!-- Header -->
                <div class="flex items-center justify-between bg-[#63a9fb] px-6 py-4 border-b border-white/60">
                    <div class="flex h-9 w-9 items-center justify-center">
                        <button type="button" @click="showModal = false"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-white/70 text-black hover:bg-white transition-colors"
                            aria-label="إغلاق">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <h2 class="font-tajawal text-2xl font-bold text-black" x-text="activeDept ? activeDept.title : ''"></h2>
                    <div class="w-9"></div> <!-- Spacer for symmetry -->
                </div>
                
                <div class="bg-[#63a9fb] px-6 pb-4 text-right text-sm font-semibold text-black/80">
                    يمكنك التواصل مع أحد أعضاء <span x-text="activeDept ? activeDept.title : ''"></span> عبر المعلومات الخاصة بكل موظف
                </div>

                <!-- Contacts Grid -->
                <div class="flex-1 overflow-y-auto bg-[#cfe4ff] p-6 custom-scrollbar">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <template x-for="contact in (activeDept ? activeDept.contacts : [])" :key="contact.id">
                            <div
                                class="rounded-[22px] border border-white/60 bg-[#c7ddf9] p-5 shadow-[0_8px_16px_rgba(0,0,0,0.05)] transition-all hover:shadow-[0_12px_24px_rgba(0,0,0,0.08)]"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="text-right">
                                        <p class="font-tajawal text-lg font-bold text-[#0f172a]" x-text="contact.name"></p>
                                        <p class="text-xs font-bold text-black/50" x-text="contact.title"></p>
                                    </div>
                                    <div
                                        class="flex h-14 w-14 items-center justify-center rounded-full bg-[#1976ff] text-base font-bold text-white shadow-lg"
                                        x-text="contact.initials"
                                    ></div>
                                </div>

                                <div class="mt-5 space-y-3">
                                    <div
                                        class="flex items-center justify-between rounded-full bg-white/70 px-4 py-2.5 text-xs font-bold text-black/70 shadow-sm"
                                    >
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#22c55e]" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span dir="ltr" x-text="contact.phone"></span>
                                        </div>
                                        <span class="text-[#22c55e]">موبايل</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between rounded-full bg-white/70 px-4 py-2.5 text-xs font-bold text-black/70 shadow-sm"
                                    >
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0ea5e9]" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span dir="ltr" x-text="contact.email"></span>
                                        </div>
                                        <span class="text-[#0ea5e9]">البريد الالكتروني</span>
                                    </div>
                                </div>

                                <div class="mt-5 flex items-center gap-3">
                                    <a :href="'https://wa.me/' + contact.phone" target="_blank"
                                        class="flex-1 text-center rounded-full border-2 border-[#22c55e] bg-white py-2 text-xs font-bold text-[#22c55e] transition-colors hover:bg-green-50">
                                        الواتساب
                                    </a>
                                    <a :href="'mailto:' + contact.email"
                                        class="flex-1 text-center rounded-full border-2 border-[#60a5fa] bg-white py-2 text-xs font-bold text-[#1d4ed8] transition-colors hover:bg-blue-50">
                                        البريد الالكتروني
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.2);
        }
    </style>
</section>