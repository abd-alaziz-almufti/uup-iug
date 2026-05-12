<div 
    x-show="showLogin"
    x-transition.opacity
    x-data="{ showForgotPasswordLocal: @entangle('showForgotPassword') }"
    @keydown.escape.window="showLogin = false"
    class="fixed inset-0 z-50 overflow-y-auto bg-[#7ea6df]/30 backdrop-blur-[1px] [&::-webkit-scrollbar]:hidden [scrollbar-width:none]"
    @click="showLogin = false"
    style="display: none;"
>
    <!-- centering wrapper -->
    <div class="flex min-h-full items-center justify-center p-4">
        
        <!-- Login Modal Card -->
        <div 
            x-show="!showForgotPasswordLocal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
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
                    
                    @if(session()->has('message'))
                        <div class="rounded-lg bg-green-50 px-4 py-3 text-center text-sm font-semibold text-green-600 border border-green-100">
                            {{ session('message') }}
                        </div>
                    @endif

                    @error('username') <span class="text-sm text-red-500 font-tajawal text-center">{{ $message }}</span> @enderror
                    
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
                        @click="showForgotPasswordLocal = true"
                        class="w-full rounded-xl bg-[#5F6368] py-4 text-base font-bold text-white font-tajawal transition-colors hover:bg-gray-700"
                    >
                        نسيت كلمة المرور
                    </button>
                </div>
            </form>

            <!-- Footer Link -->
            <a href="{{ route('register') }}" class="mt-6 cursor-pointer font-tajawal font-bold text-[#008423] underline-offset-4 transition-all hover:underline">
                تسجيل دخول - طالب جديد
            </a>
        </div>

        <!-- Forgot Password Modal Card -->
        <div 
            x-show="showForgotPasswordLocal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            dir="rtl" 
            class="relative flex w-full max-w-[700px] flex-col items-center rounded-[20px] bg-[#cfe3ff] px-8 py-10 shadow-[0_0_100px_rgba(0,0,0,0.25)]"
            @click.stop
            style="display: none;"
        >
            <!-- Top Accent Line -->
            <div class="absolute left-0 right-0 top-0 h-5 rounded-t-[20px] bg-[#007BFF]"></div>

            <!-- Close Button -->
            <button 
                @click="showForgotPasswordLocal = false"
                class="absolute left-4 top-8 text-[#0d6efd] text-2xl transition-colors hover:text-blue-700"
                aria-label="إغلاق"
            >
                ×
            </button>

            <!-- University Logo -->
            <div class="flex h-32 w-32 items-center justify-center rounded-full bg-white/70 shadow-sm">
                <img src="{{ asset('logo2.png') }}" alt="IUG Logo" class="h-24 w-24 object-contain" />
            </div>

            @if($recoveryStep === 1)
                <!-- Step 1: Request Recovery -->
                <h2 class="mt-6 text-center font-tajawal text-[32px] font-bold text-black/80">
                    استعادة كلمة المرور
                </h2>

                <div class="mt-6 w-full max-w-[620px] space-y-4">
                    <!-- University ID Input -->
                    <div class="relative">
                        <input 
                            wire:model="recoveryId"
                            type="text" 
                            placeholder="الرقم الجامعي"
                            class="w-full rounded-[20px] bg-[#bfdeff] py-4 pl-4 pr-12 text-right font-tajawal text-lg text-black/70 outline-none focus:ring-2 focus:ring-blue-400/30 @error('recoveryId') border-red-400 ring-2 ring-red-400/20 @enderror"
                        />
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-black/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                    </div>
                    @error('recoveryId') <p class="mt-1 text-center text-xs font-bold text-red-500">{{ $message }}</p> @enderror

                    <!-- Recovery Method Selection -->
                    <div class="mt-4 flex w-full items-center justify-between px-2">
                        <span class="font-tajawal text-lg text-black">وسيلة التحقق</span>
                        <div class="flex items-center gap-6">
                            <label class="flex cursor-pointer items-center gap-2 font-tajawal text-base text-black">
                                <input 
                                    wire:model="recoveryMethod"
                                    type="radio" 
                                    name="method"
                                    value="email"
                                    class="h-5 w-5 border border-white bg-white accent-blue-600"
                                />
                                البريد الالكتروني
                            </label>
                            <label class="flex cursor-pointer items-center gap-2 font-tajawal text-base text-black">
                                <input 
                                    wire:model="recoveryMethod"
                                    type="radio" 
                                    name="method"
                                    value="phone"
                                    class="h-5 w-5 border border-white bg-white accent-blue-600"
                                />
                                رقم الهاتف
                            </label>
                        </div>
                    </div>

                    <button 
                        type="button" 
                        wire:click="verifyRecovery"
                        class="mt-8 w-full rounded-[20px] border border-white/50 bg-[#0d6efd] py-4 text-center font-tajawal text-xl font-bold text-white transition-colors hover:bg-blue-700 disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="verifyRecovery">قم بالتحقق</span>
                        <span wire:loading wire:target="verifyRecovery">جاري التحقق...</span>
                    </button>
                </div>

            @elseif($recoveryStep === 2)
                <!-- Step 2: Verify Code -->
                <h2 class="mt-6 text-center font-tajawal text-[32px] font-bold text-black/80">
                    أدخل رمز التحقق
                </h2>
                
                <div class="mt-6 w-full max-w-[620px] space-y-4 text-center">
                    @if(session()->has('recovery_success'))
                        <div class="rounded-xl bg-green-50 p-4 text-center font-tajawal text-sm font-bold text-green-700 border border-green-200">
                            {{ session('recovery_success') }}
                        </div>
                    @endif

                    <p class="font-tajawal text-gray-600 mb-4">يرجى إدخال الرمز المكون من 6 أرقام</p>

                    <div class="relative">
                        <input 
                            wire:model="inputCode"
                            type="text" 
                            maxlength="6"
                            placeholder="------"
                            class="w-full text-center tracking-[1rem] rounded-[20px] bg-[#bfdeff] py-4 font-tajawal text-2xl font-bold text-black outline-none focus:ring-2 focus:ring-blue-400/30"
                        />
                    </div>
                    @error('inputCode') <p class="mt-1 text-center text-xs font-bold text-red-500">{{ $message }}</p> @enderror

                    <button 
                        type="button" 
                        wire:click="verifyCode"
                        class="mt-8 w-full rounded-[20px] border border-white/50 bg-[#0d6efd] py-4 text-center font-tajawal text-xl font-bold text-white transition-colors hover:bg-blue-700"
                    >
                        تأكيد الرمز
                    </button>
                    
                    <button wire:click="$set('recoveryStep', 1)" class="mt-4 text-[#0d6efd] font-tajawal font-bold hover:underline">
                        تغيير وسيلة التحقق أو الرقم الجامعي
                    </button>
                </div>

            @elseif($recoveryStep === 3)
                <!-- Step 3: Reset Password -->
                <h2 class="mt-6 text-center font-tajawal text-[32px] font-bold text-black/80">
                    تعيين كلمة مرور جديدة
                </h2>

                <div class="mt-6 w-full max-w-[620px] space-y-4">
                    <div class="relative">
                        <input 
                            wire:model="newPassword"
                            type="password" 
                            placeholder="كلمة المرور الجديدة"
                            class="w-full rounded-[20px] bg-[#bfdeff] py-4 px-6 text-right font-tajawal text-lg text-black outline-none"
                        />
                    </div>
                    <div class="relative">
                        <input 
                            wire:model="newPassword_confirmation"
                            type="password" 
                            placeholder="تأكيد كلمة المرور"
                            class="w-full rounded-[20px] bg-[#bfdeff] py-4 px-6 text-right font-tajawal text-lg text-black outline-none"
                        />
                    </div>
                    @error('newPassword') <p class="mt-1 text-center text-xs font-bold text-red-500">{{ $message }}</p> @enderror

                    <button 
                        type="button" 
                        wire:click="resetPassword"
                        class="mt-8 w-full rounded-[20px] border border-white/50 bg-[#00d300] py-4 text-center font-tajawal text-xl font-bold text-white transition-colors hover:bg-green-600"
                    >
                        حفظ كلمة المرور الجديدة
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
