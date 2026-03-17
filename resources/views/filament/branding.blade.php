@if (request()->routeIs('filament.admin.auth.login'))
    <div class="flex flex-col items-center justify-center py-4">
        <img src="{{ asset('images/logo.png') }}" style="height: 6.5rem;" alt="IUG Logo">
    </div>
@else
    <div class="flex flex-col items-start px-2 py-1">
        <span class="text-lg font-black leading-none text-gray-950 dark:text-white">
            المنصة الجامعية الموحدة
        </span>
        <span class="text-[10px] font-bold uppercase tracking-wider text-[#008C4A] mt-1">
            _ الجامعة الإسلامية بغزة
        </span>
    </div>
@endif
