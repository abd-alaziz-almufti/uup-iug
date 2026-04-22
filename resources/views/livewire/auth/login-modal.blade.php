<div 
    x-show="showLogin"
    x-transition.opacity
    class="fixed inset-0 z-50 overflow-y-auto bg-[#7ea6df]/30 backdrop-blur-[1px] [&::-webkit-scrollbar]:hidden [scrollbar-width:none]"
    @click="showLogin = false"
    style="display: none;"
>
    <!-- centering wrapper -->
    <div class="flex min-h-full items-center justify-center p-4">
        
        <!-- Modal Card -->
        <div 
            dir="rtl" 
            class="relative flex w-full max-w-[520px] flex-col items-center rounded-[32px] bg-[#EAF2FC] px-8 py-10 shadow-2xl"
            @click.stop
        >
            <!-- Close Button -->
            <button 
                @click="showLogin = false"
                class="absolute left-4 top-4 text-gray-400 transition-colors hover:text-gray-600"
                aria-label="إغلاق"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- University Logo -->
            <div class="flex h-20 w-20 items-center justify-center rounded-full border-4 border-[#D2E3FC] bg-white shadow-lg">
                <img src="{{ asset('logo2.png') }}" alt="IUG Logo" class="h-full w-full object-contain" />
            </div>

            <!-- Title -->
            <h2 class="mb-8 mt-4 text-center font-tajawal text-2xl font-bold text-gray-800">
                تسجيل دخول - طالب مسجل
            </h2>

            <!-- Form -->
            <form wire:submit="login" class="w-full">
                <div class="flex w-full flex-col gap-5 px-4">
                    
                    @error('username') <span class="text-sm text-red-500 font-tajawal">{{ $message }}</span> @enderror
                    
                    <!-- Username Input -->
                    <div class="relative">
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </span>
                        <input 
                            wire:model="username" 
                            type="text" 
                            placeholder="الرقم الجامعي / الايميل"
                            class="w-full rounded-xl border border-transparent bg-[#D2E3FC] py-4 pl-4 pr-10 text-right text-gray-800 outline-none transition-colors placeholder:text-gray-500 focus:border-blue-400"
                        />
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                            </svg>
                        </span>
                        <input 
                            wire:model="password" 
                            type="password" 
                            placeholder="كلمة المرور"
                            class="w-full rounded-xl border border-transparent bg-[#D2E3FC] py-4 pl-4 pr-10 text-right text-gray-800 outline-none transition-colors placeholder:text-gray-500 focus:border-blue-400"
                        />
                    </div>

                    <!-- Remember Me + Help -->
                    <div class="flex w-full items-center justify-between text-sm text-gray-600">
                        <label class="flex cursor-pointer select-none items-center gap-2">
                            <input 
                                wire:model="remember" 
                                type="checkbox" 
                                class="h-4 w-4 cursor-pointer rounded accent-[#007BFF]"
                            />
                            <span class="font-tajawal">تذكر كلمة المرور</span>
                        </label>
                        <button 
                            type="button" 
                            class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-gray-400 text-sm font-bold text-gray-500 transition-colors hover:border-blue-400 hover:text-blue-500" 
                            aria-label="مساعدة"
                        >
                            ?
                        </button>
                    </div>

                    <!-- Primary Button -->
                    <button 
                        type="submit" 
                        class="w-full rounded-xl bg-[#007BFF] py-4 text-base font-bold text-white font-tajawal transition-colors hover:bg-blue-600"
                    >
                        <span wire:loading.remove wire:target="login">تسجيل دخول</span>
                        <span wire:loading wire:target="login">جاري التحقق...</span>
                    </button>

                    <!-- Secondary Button -->
                    <button 
                        type="button" 
                        class="w-full rounded-xl bg-[#5F6368] py-4 text-base font-bold text-white font-tajawal transition-colors hover:bg-gray-700"
                    >
                        نسيت كلمة المرور
                    </button>
                </div>
            </form>

            <!-- Footer Link -->
            <button type="button" class="mt-6 cursor-pointer font-tajawal font-bold text-[#008423] underline-offset-4 transition-all hover:underline">
                تسجيل دخول - طالب جديد
            </button>
        </div>
    </div>
</div>
