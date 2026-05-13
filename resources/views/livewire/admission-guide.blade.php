<div 
    class="w-full" 
    dir="rtl"
    x-data="{ 
        localSearch: '', 
        localDegree: 'bachelor',
        shouldShowMajor(name, type) {
            const matchesSearch = name.toLowerCase().includes(this.localSearch.toLowerCase());
            const matchesDegree = type === this.localDegree;
            return matchesSearch && matchesDegree;
        },
        shouldShowCollege(majors) {
            return majors.some(m => this.shouldShowMajor(m.name, m.degree_type));
        }
    }"
>
    <!-- Header with Search and Tabs -->
    <div class="mb-6 flex flex-col items-center justify-between gap-4 md:flex-row">
        <!-- Degree Tabs -->
        <div class="flex rounded-2xl bg-gray-100 p-1">
            <button 
                @click="localDegree = 'bachelor'"
                :class="localDegree === 'bachelor' ? 'bg-white text-[#007BFF] shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="rounded-xl px-6 py-2 font-tajawal text-sm font-bold transition-all"
            >
                درجة البكالوريوس
            </button>
            <button 
                @click="localDegree = 'diploma'"
                :class="localDegree === 'diploma' ? 'bg-white text-[#007BFF] shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="rounded-xl px-6 py-2 font-tajawal text-sm font-bold transition-all"
            >
                درجة الدبلوم
            </button>
        </div>

        <!-- Search Bar -->
        <div class="relative w-full md:w-80">
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input 
                x-model="localSearch"
                type="text" 
                placeholder="ابحث عن تخصص..."
                class="w-full rounded-2xl border-none bg-gray-100 py-3 pl-4 pr-11 font-tajawal text-sm text-gray-800 outline-none focus:ring-2 focus:ring-blue-400/50"
            />
        </div>
    </div>

    <!-- Results Table -->
    <div class="overflow-hidden rounded-[24px] border border-gray-100 bg-white shadow-sm">
        <table class="w-full text-right font-tajawal">
            <thead>
                <tr class="bg-[#f8fbff] text-[#007BFF]">
                    <th class="px-6 py-4 font-bold">اسم التخصص</th>
                    <th class="px-6 py-4 font-bold text-center {{ $viewMode === 'rates' ? 'bg-[#007BFF]/10 text-[#007BFF]' : '' }}">نسبة القبول</th>
                    <th class="px-6 py-4 font-bold text-center {{ $viewMode === 'fees' ? 'bg-[#007BFF]/10 text-[#007BFF]' : '' }}">سعر الساعة</th>
                    <th class="px-6 py-4 font-bold text-center">الإجمالي (ساعة)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($colleges as $college)
                    <!-- College Header Row -->
                    <tr class="bg-gray-50/50" x-show="shouldShowCollege({{ $college->majors->toJson() }})">
                        <td colspan="4" class="px-6 py-3 font-black text-[#08152f] text-sm">
                            <span class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-[#007BFF]"></span>
                                {{ $college->name }}
                            </span>
                        </td>
                    </tr>

                    @foreach($college->majors as $major)
                        <tr 
                            class="transition-colors hover:bg-blue-50/30"
                            x-show="shouldShowMajor('{{ $major->name }}', '{{ $major->degree_type }}')"
                        >
                            <td class="px-8 py-4 text-gray-700 font-medium">{{ $major->name }}</td>
                            <td class="px-6 py-4 text-center {{ $viewMode === 'rates' ? 'bg-[#007BFF]/5' : '' }}">
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-[#007BFF]">
                                    +{{ number_format($major->acceptance_rate, 1) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-800 {{ $viewMode === 'fees' ? 'bg-[#007BFF]/5' : '' }}">
                                {{ number_format($major->credit_hour_price, 0) }} دينار
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 text-sm">
                                {{ $major->total_hours }} ساعة
                            </td>
                        </tr>
                    @endforeach
                @endforeach

                <!-- No Results Message (Alpine.js) -->
                <tr x-show="!$el.parentElement.querySelector('tr[x-show*=\'shouldShowMajor\']:not([style*=\'display: none\'])')">
                    <td colspan="4" class="px-6 py-20 text-center text-gray-400 font-tajawal">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            لا توجد تخصصات تطابق بحثك حالياً
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer Stats -->
    <div class="mt-6 flex justify-between items-center px-4 text-xs text-gray-400 font-tajawal">
        <p>* قد تختلف النسب والرسوم بناءً على القرارات الأكاديمية السنوية.</p>
        <p>إجمالي النتائج: {{ $colleges->sum(fn($c) => $c->majors->count()) }} تخصص</p>
    </div>
</div>
