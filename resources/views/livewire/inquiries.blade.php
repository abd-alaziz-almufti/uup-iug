<section 
    dir="rtl" 
    class="space-y-6 text-right"
    x-data="{ showCreateModal: @entangle('showCreateModal') }"
>
    <!-- ... existing ticket list content ... -->
    @if(session()->has('message'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 font-tajawal text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="rounded-[20px] bg-white px-4 py-5 shadow-[0_10px_24px_rgba(15,23,42,0.12)]">
        <div class="flex items-center justify-between rounded-[10px] bg-[#67adfc] px-4 py-2">
            <h2 class="font-tajawal text-lg font-bold text-black">عرض التذاكر</h2>
            <div class="relative flex w-full max-w-[200px] items-center">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="query"
                    placeholder="ابحث عن تذكرة"
                    class="h-[30px] w-full rounded-[10px] border border-transparent bg-white px-9 text-xs font-bold text-black placeholder:text-black outline-none focus:border-[#007bff]"
                />
                <span class="absolute left-2 top-1/2 -translate-y-1/2 text-[#67adfc]">
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="mt-3 overflow-x-auto rounded-[10px] bg-[#b1c9ee]">
            <div class="min-w-[720px]">
                <div class="grid grid-cols-6 items-center border-b border-white px-4 py-2 text-xs font-bold text-white">
                    <div class="border-l border-white pr-2">رقم التذكرة</div>
                    <div class="border-l border-white pr-2">عنوان التذكرة</div>
                    <div class="border-l border-white pr-2">الجهة المرسل اليها</div>
                    <div class="border-l border-white pr-2">حالة التذكرة</div>
                    <div class="border-l border-white pr-2">تاريخ فتح التذكرة</div>
                    <div class="pr-2">تاريخ اغلاق التذكرة</div>
                </div>

                @forelse($filteredTickets as $ticket)
                <button 
                    type="button" 
                    wire:click="selectTicket('{{ $ticket['id'] }}')"
                    class="grid w-full grid-cols-6 items-center border-b border-white px-4 py-3 text-xs font-bold text-black transition {{ $selectedId === $ticket['id'] ? 'bg-[#c4d7f2]' : 'bg-transparent hover:bg-white/10' }}"
                >
                    <div class="border-l border-white pr-2">{{ $ticket['id'] }}</div>
                    <div class="border-l border-white pr-2">{{ $ticket['title'] }}</div>
                    <div class="border-l border-white pr-2">{{ $ticket['target'] }}</div>
                    <div class="border-l border-white pr-2">
                        <span class="inline-flex h-[30px] min-w-[95px] items-center justify-center rounded-[30px] px-3 text-xs font-semibold text-white {{ $ticket['status'] === 'قيد المتابعة' ? 'bg-[#00d300]' : 'bg-[#d30000]' }}">
                            {{ $ticket['status'] }}
                        </span>
                    </div>
                    <div class="border-l border-white pr-2">{{ $ticket['openedAt'] }}</div>
                    <div class="pr-2">{{ $ticket['closedAt'] }}</div>
                </button>
                @empty
                <div class="px-4 py-6 text-center text-sm font-tajawal text-gray-700">لا توجد تذاكر مطابقة لمطالبتك.</div>
                @endforelse
            </div>
        </div>

        <div class="flex justify-center py-4">
            <button 
                type="button" 
                wire:click="openCreateModal"
                class="rounded-[50px] bg-[#00d300] px-8 py-2 font-tajawal text-sm font-bold text-white hover:bg-green-600 transition"
            >
                إنشاء تذكرة جديدة
            </button>
        </div>
    </div>

    <!-- Ticket Details -->
    <div class="rounded-[20px] bg-white px-4 py-5 shadow-[0_10px_24px_rgba(15,23,42,0.12)]">
        <div class="flex items-center justify-between rounded-[10px] bg-[#67adfc] px-4 py-2">
            <h3 class="font-tajawal text-lg font-bold text-black">تفاصيل التذاكر</h3>
        </div>

        <div class="mt-3 overflow-x-auto rounded-[10px] bg-[#b1c9ee] px-4 py-3">
            <div class="min-w-[720px]">
                <div class="grid grid-cols-6 items-center text-xs font-bold text-black">
                    <div class="border-l border-white pr-2">{{ $selectedTicket['id'] ?? '--' }}</div>
                    <div class="border-l border-white pr-2">{{ $selectedTicket['title'] ?? '--' }}</div>
                    <div class="border-l border-white pr-2">{{ $selectedTicket['target'] ?? '--' }}</div>
                    <div class="border-l border-white pr-2">
                        <span class="inline-flex h-[30px] min-w-[95px] items-center justify-center rounded-[30px] px-3 text-xs font-semibold text-white {{ ($selectedTicket['status'] ?? '') === 'قيد المتابعة' ? 'bg-[#00d300]' : 'bg-[#d30000]' }}">
                            {{ $selectedTicket['status'] ?? '--' }}
                        </span>
                    </div>
                    <div class="border-l border-white pr-2">{{ $selectedTicket['openedAt'] ?? '--' }}</div>
                    <div class="pr-2">{{ $selectedTicket['closedAt'] ?? '--' }}</div>
                </div>
            </div>
        </div>

        <div class="mt-3 rounded-[10px] bg-[#b1c9ee] px-4 py-3">
            <p class="font-tajawal text-sm font-bold text-black">موضوع التذكرة :</p>
            <div class="mt-3 border-b border-dotted border-black pb-6 text-xs font-bold text-black">
                {{ $selectedTicket['subject'] ?? '--' }}
            </div>
        </div>

        <div class="mt-3 rounded-[10px] bg-[#b1c9ee] px-4 py-3">
            <p class="font-tajawal text-sm font-bold text-black">ملاحظات المشرف والردود :</p>
            @forelse($selectedTicket['replies'] ?? [] as $reply)
                <div class="mt-3 border-b border-white pb-3 last:border-0">
                    <p class="text-[10px] font-bold text-blue-800">{{ $reply['author'] }} - {{ $reply['created_at'] }}</p>
                    <p class="mt-1 text-xs font-medium text-black">
                        {{ $reply['message'] }}
                    </p>
                </div>
            @empty
                <p class="mt-3 text-xs font-medium text-black">
                    لم يضف المشرف اي ملاحظات بعد يرجى المراجعة لاحقاً
                </p>
            @endforelse
        </div>
    </div>

    <!-- Create Ticket Modal (Teleported to Body) -->
    <template x-teleport="body">
        <div 
            x-show="showCreateModal" 
            x-cloak
            class="fixed inset-0 z-[200] flex items-center justify-center px-4 py-6" 
            dir="rtl"
        >
            <!-- Backdrop -->
            <div 
                x-show="showCreateModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/40 backdrop-blur-sm" 
                @click="showCreateModal = false"
            ></div>
            
            <!-- Modal Content -->
            <form 
                x-show="showCreateModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                wire:submit.prevent="createTicket" 
                class="relative z-[201] w-full max-w-3xl overflow-hidden rounded-[26px] border border-[#e2e8f0] bg-white shadow-[0_20px_50px_rgba(15,23,42,0.2)]"
            >
                <div class="flex flex-row items-center justify-between bg-[#0f6ff2] px-6 py-4">
                    <h2 class="font-tajawal text-xl font-bold text-white text-center flex-1">إنشاء تذكرة جديدة</h2>
                    <button type="button" @click="showCreateModal = false" class="text-2xl font-bold text-white hover:text-gray-200 transition-colors">✕</button>
                </div>

                <div class="space-y-4 p-8 text-right overflow-y-auto max-h-[calc(100vh-10rem)]" dir="rtl">
                    @if($errors->any())
                        <div class="rounded-xl bg-red-50 p-4 text-xs font-bold text-red-700 border border-red-200 mb-4">
                            <p class="mb-2 underline">يرجى تصحيح الأخطاء التالية:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Select Department -->
                    <div class="space-y-2">
                        <div class="flex flex-row-reverse items-center justify-end gap-2 text-right">
                            <span class="font-tajawal text-sm font-bold text-[#0f172a]">اختر الجهة</span>
                            <span class="h-5 w-1 rounded-full bg-[#0f6ff2]"></span>
                        </div>
                        <div class="relative">
                            <select wire:model.live="department_id" class="w-full appearance-none rounded-xl border border-[#c9d9f5] bg-[#bcd2f3] px-10 py-2.5 text-right text-sm font-semibold text-[#0f172a] shadow-inner outline-none">
                                <option value="">اختر دائرة/قسم...</option>
                                @foreach($this->departmentsList as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[#2b6de9]">▼</span>
                        </div>
                        @error('department_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Select Category -->
                    <div class="space-y-2">
                        <div class="flex flex-row-reverse items-center justify-end gap-2 text-right">
                            <span class="font-tajawal text-sm font-bold text-[#0f172a]">التصنيف</span>
                            <span class="h-5 w-1 rounded-full bg-[#0f6ff2]"></span>
                        </div>
                        <div class="relative">
                            <select wire:model.live="category" class="w-full appearance-none rounded-xl border border-[#c9d9f5] bg-[#bcd2f3] px-10 py-2.5 text-right text-sm font-semibold text-[#0f172a] shadow-inner outline-none">
                                <option value="أخرى">أخرى</option>
                                <option value="تسجيل مواد">تسجيل مواد</option>
                                <option value="مالي">مالي</option>
                                <option value="امتحانات">امتحانات</option>
                                <option value="علامات">علامات</option>
                                <option value="تقني">تقني</option>
                                <option value="إداري">إداري</option>
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[#2b6de9]">▼</span>
                        </div>
                        @error('category') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Select Target Type -->
                    <div class="space-y-2">
                        <div class="flex flex-row-reverse items-center justify-end gap-2 text-right">
                            <span class="font-tajawal text-sm font-bold text-[#0f172a]">نوع الجهة</span>
                            <span class="h-5 w-1 rounded-full bg-[#0f6ff2]"></span>
                        </div>
                        <div class="relative">
                            <select wire:model.live="targetType" class="w-full appearance-none rounded-xl border border-[#c9d9f5] bg-[#bcd2f3] px-10 py-2.5 text-right text-sm font-semibold text-[#0f172a] shadow-inner outline-none">
                                @forelse($this->availableTargetTypes as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                                @empty
                                    <option value="">يرجى اختيار القسم أولاً</option>
                                @endforelse
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[#2b6de9]">▼</span>
                        </div>
                    </div>

                    <!-- Select Course (Visible only if target is instructor) -->
                    @if($targetType === 'instructor')
                    <div class="space-y-2" x-transition>
                        <div class="flex flex-row-reverse items-center justify-end gap-2 text-right">
                            <span class="font-tajawal text-sm font-bold text-[#0f172a]">المادة الدراسية</span>
                            <span class="h-5 w-1 rounded-full bg-[#0f6ff2]"></span>
                        </div>
                        <div class="relative">
                            <select wire:model.live="course_id" class="w-full appearance-none rounded-xl border border-[#c9d9f5] bg-[#bcd2f3] px-10 py-2.5 text-right text-sm font-semibold text-[#0f172a] shadow-inner outline-none">
                                <option value="">اختر المادة...</option>
                                @foreach($this->studentCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[#2b6de9]">▼</span>
                        </div>
                        @error('course_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <!-- Title -->
                    <div class="space-y-2">
                        <div class="flex flex-row-reverse items-center justify-end gap-2 text-right">
                            <span class="font-tajawal text-sm font-bold text-[#0f172a]">عنوان التذكرة</span>
                            <span class="h-5 w-1 rounded-full bg-[#0f6ff2]"></span>
                        </div>
                        <input type="text" wire:model.live="title" placeholder="عنوان المشكلة" class="w-full rounded-xl border border-[#c9d9f5] bg-[#bcd2f3] px-4 py-2.5 text-right text-sm font-semibold text-[#0f172a] outline-none shadow-inner" />
                        @error('title') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Subject -->
                    <div class="space-y-2">
                        <div class="flex flex-row-reverse items-center justify-end gap-2 text-right">
                            <span class="font-tajawal text-sm font-bold text-[#0f172a]">موضوع التذكرة</span>
                            <span class="h-5 w-1 rounded-full bg-[#0f6ff2]"></span>
                        </div>
                        <textarea wire:model.live="subject" rows="4" placeholder="تفاصيل الشكوى / الاستفسار / المشكلة" class="w-full rounded-xl border border-[#c9d9f5] bg-[#bcd2f3] px-4 py-2.5 text-right text-sm font-semibold text-[#0f172a] outline-none shadow-inner"></textarea>
                        @error('subject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-center gap-4 pt-6">
                        <button 
                            type="button" 
                            wire:click="createTicket"
                            wire:loading.attr="disabled" 
                            class="rounded-xl bg-[#22c55e] px-12 py-3 font-tajawal text-base font-bold text-white shadow-lg hover:bg-green-600 transition-all disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="createTicket">إرسال التذكرة</span>
                            <span wire:loading wire:target="createTicket">جاري الإرسال...</span>
                        </button>
                        <button type="button" @click="showCreateModal = false" class="rounded-xl bg-gray-400 px-8 py-3 font-tajawal text-base font-bold text-white shadow hover:bg-gray-500 transition-all">
                            إلغاء
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </template>

</section>
