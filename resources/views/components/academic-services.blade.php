@php
$services = [
    [
        "title" => "الاختبارات",
        "description" => "مواعيد الاختبارات",
        "button" => "عرض الاختبارات",
        "image" => "exames.png",
        "badge" => null,
    ],
    [
        "title" => "الدرجات",
        "description" => "متابعة نتائج الاختبارات",
        "button" => "عرض الدرجات",
        "image" => "grades.png",
        "badge" => null,
    ],
    [
        "title" => "الجدول الدراسي",
        "description" => "عرض المحاضرات الاسبوعية",
        "button" => "عرض الجدول",
        "image" => "Study schedule.png",
        "badge" => null,
    ],
    [
        "title" => "التسجيل",
        "description" => "التسجيل للفصل الجديد",
        "button" => "التسجيل للفصل",
        "image" => "registration.png",
        "badge" => null,
    ],
    [
        "title" => "الاشعارات",
        "description" => "التنبيهات الاكاديمية",
        "button" => "عرض الاشعارات",
        "image" => "notifications.png",
        "badge" => "3",
    ],
    [
        "title" => "الملف المالي",
        "description" => "متابعة الرسوم الجامعية",
        "button" => "فحص الملف المالي",
        "image" => "finance-file.png",
        "badge" => null,
    ],
];
@endphp

<section class="w-full">
    <div class="grid grid-cols-1 justify-items-center gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($services as $service)
        <div class="relative flex h-[300px] w-full max-w-[318px] flex-col items-center justify-between rounded-[32px] border border-[#d8d8d8] bg-white/60 p-5 text-center shadow-[0_4px_10px_rgba(0,123,255,0.25)]">
            <div class="absolute inset-0 rounded-[32px] bg-white/40"></div>

            <div class="relative mt-2 flex w-full flex-col items-center">
                <div class="relative mb-4 flex h-24 w-24 items-center justify-center rounded-[24px] bg-white/60">
                    <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" class="h-16 w-16 object-contain" />
                    @if($service['badge'])
                    <span class="absolute -right-2 -top-2 flex h-8 w-8 items-center justify-center rounded-full bg-[#ef4444] text-xs font-bold text-white">
                        {{ $service['badge'] }}
                    </span>
                    @endif
                </div>
                <h3 class="font-tajawal text-2xl font-bold text-[#007bff]">
                    {{ $service['title'] }}
                </h3>
                <p class="mt-2 text-sm font-medium text-black/60">{{ $service['description'] }}</p>
            </div>

            <button type="button" class="relative mb-2 h-[45px] w-[246px] rounded-[16px] bg-[#007bff] font-tajawal text-lg font-semibold text-white shadow-[0_0_10px_rgba(0,123,255,0.5)]">
                {{ $service['button'] }}
            </button>
        </div>
        @endforeach
    </div>
</section>
