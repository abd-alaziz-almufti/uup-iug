<div dir="ltr" class="mx-auto hidden w-full max-w-7xl items-center justify-between px-5 py-2 text-sm text-[#113b67] lg:flex">
    <!-- Left side: social icons -->
    <div class="flex items-center gap-4">
        <a href="mailto:{{ App\Models\Setting::get('university_email', 'public@iugaza.edu.ps') }}" aria-label="Email" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <span class="text-[15px] leading-none">✉</span>
        </a>
        <a href="{{ App\Models\Setting::get('university_youtube', '#') }}" target="_blank" aria-label="YouTube" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('youtube.png') }}" alt="YouTube" class="h-4 w-4 object-contain" />
        </a>
        <a href="{{ App\Models\Setting::get('university_instagram', '#') }}" target="_blank" aria-label="Instagram" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('instagram.png') }}" alt="Instagram" class="h-4 w-4 object-contain" />
        </a>
        <a href="{{ App\Models\Setting::get('university_facebook', '#') }}" target="_blank" aria-label="Facebook" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('facebook.png') }}" alt="Facebook" class="h-4 w-4 object-contain" />
        </a>
        <a href="{{ App\Models\Setting::get('university_twitter', '#') }}" target="_blank" aria-label="Twitter" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('twitter.png') }}" alt="Twitter" class="h-4 w-4 object-contain" />
        </a>
        <a href="{{ App\Models\Setting::get('university_telegram', '#') }}" target="_blank" aria-label="Telegram" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('telegram.png') }}" alt="Telegram" class="h-4 w-4 object-contain" />
        </a>
        <a href="{{ App\Models\Setting::get('university_broadcast', '#') }}" target="_blank" aria-label="Broadcast" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('broadcast.png') }}" alt="Broadcast" class="h-4 w-4 object-contain" />
        </a>
        <a href="{{ App\Models\Setting::get('university_box', '#') }}" target="_blank" aria-label="Box" class="flex items-center justify-center text-[#111827] transition-colors hover:text-[#01A0E2]">
            <img src="{{ asset('box.png') }}" alt="Box" class="h-4 w-4 object-contain" />
        </a>
    </div>

    <!-- Right side: language + email -->
    <div class="flex items-center gap-6 font-inter text-xs text-[#01A0E2]">
        <button type="button" class="flex items-center gap-1 font-bold transition-colors hover:text-[#0b84c6]">
            <img src="{{ asset('translate.png') }}" alt="Language" class="h-4 w-4 object-contain" />
            <span>English</span>
        </button>

        <a href="mailto:{{ App\Models\Setting::get('university_email', 'public@iugaza.edu.ps') }}" class="flex items-center gap-1 font-bold transition-colors hover:text-[#0b84c6]">
            <img src="{{ asset('mail2.png') }}" alt="Email" class="h-4 w-4 object-contain" />
            <span>{{ App\Models\Setting::get('university_email', 'public@iugaza.edu.ps') }}</span>
        </a>
    </div>
</div>
