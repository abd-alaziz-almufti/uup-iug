<div class="w-full max-w-4xl mx-auto rounded-[32px] bg-white/80 p-8 shadow-xl backdrop-blur-md" dir="rtl">
    <div class="flex flex-col items-center mb-8">
        <h2 class="font-tajawal text-3xl font-bold text-[#08152f]">تواصل معنا</h2>
        <p class="mt-2 font-tajawal text-gray-500 text-center">يسعدنا استقبال استفساراتكم وملاحظاتكم في أي وقت</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-6">
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-4 font-tajawal text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="space-y-1">
                <label class="block font-tajawal font-bold text-gray-700 mr-2">الاسم بالكامل</label>
                <div class="relative">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <input 
                        wire:model="name"
                        type="text" 
                        class="w-full rounded-2xl bg-[#bfdeff]/30 py-4 pl-4 pr-11 font-tajawal text-gray-800 outline-none focus:ring-2 focus:ring-blue-400/50 transition-all @error('name') ring-2 ring-red-400/50 @enderror"
                        placeholder="ادخل اسمك هنا..."
                    />
                </div>
                @error('name') <span class="text-xs text-red-500 mr-2 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1">
                <label class="block font-tajawal font-bold text-gray-700 mr-2">البريد الإلكتروني</label>
                <div class="relative">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input 
                        wire:model="email"
                        type="email" 
                        class="w-full rounded-2xl bg-[#bfdeff]/30 py-4 pl-4 pr-11 font-tajawal text-gray-800 outline-none focus:ring-2 focus:ring-blue-400/50 transition-all @error('email') ring-2 ring-red-400/50 @enderror"
                        placeholder="example@iugaza.edu.ps"
                    />
                </div>
                @error('email') <span class="text-xs text-red-500 mr-2 font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Subject -->
        <div class="space-y-1">
            <label class="block font-tajawal font-bold text-gray-700 mr-2">عنوان الرسالة</label>
            <div class="relative">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
                <input 
                    wire:model="subject"
                    type="text" 
                    class="w-full rounded-2xl bg-[#bfdeff]/30 py-4 pl-4 pr-11 font-tajawal text-gray-800 outline-none focus:ring-2 focus:ring-blue-400/50 transition-all @error('subject') ring-2 ring-red-400/50 @enderror"
                    placeholder="ما هو موضوع استفسارك؟"
                />
            </div>
            @error('subject') <span class="text-xs text-red-500 mr-2 font-bold">{{ $message }}</span> @enderror
        </div>

        <!-- Message -->
        <div class="space-y-1">
            <label class="block font-tajawal font-bold text-gray-700 mr-2">نص الرسالة</label>
            <textarea 
                wire:model="message"
                rows="5"
                class="w-full rounded-2xl bg-[#bfdeff]/30 p-4 font-tajawal text-gray-800 outline-none focus:ring-2 focus:ring-blue-400/50 transition-all @error('message') ring-2 ring-red-400/50 @enderror"
                placeholder="اكتب تفاصيل رسالتك هنا..."
            ></textarea>
            @error('message') <span class="text-xs text-red-500 mr-2 font-bold">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center pt-4">
            <button 
                type="submit" 
                class="w-full md:w-auto min-w-[200px] rounded-2xl bg-[#007BFF] py-4 px-12 font-tajawal text-lg font-bold text-white shadow-lg transition-all hover:bg-blue-600 hover:scale-105 active:scale-95 disabled:opacity-50"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="submit">إرسال الرسالة</span>
                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    جاري الإرسال...
                </span>
            </button>
        </div>
    </form>
</div>
