<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class HomepageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Hero Section
            ['key' => 'hero_title', 'value' => 'مرحباً بكم في مركز الاتصال الجامعي الموحد'],
            ['key' => 'hero_subtitle', 'value' => 'منصة موحّدة تجمع خدمات واستفسارات الطلبة في مكان واحد'],

            // Direct Contact Modal
            ['key' => 'direct_contact_title', 'value' => 'تواصل مباشرة مع الأقسام'],
            ['key' => 'direct_contact_description', 'value' => 'من خلال ميزة التواصل المباشر مع الأقسام يتيح لك الوصول السريع كطلاب للاقسام للاجابة على الاستفسارات والمشاكل التي تواجهها خلال رحلتك في الحياة الجامعية'],
            ['key' => 'direct_contact_note', 'value' => 'لتتمكن من استخدام ميزة التواصل عليك تسجيل الدخول'],

            // Track Orders Modal
            ['key' => 'track_orders_title', 'value' => 'متابعة الطلبات إلكترونياً'],
            ['key' => 'track_orders_description', 'value' => 'من خلال ميزة متابعة الطلبات إلكترونياً يتيح لك الوصول السريع كطلاب الى الطلبات والاستفسارات الخاصة بك بشكل اسهل واسرع خلال رحلتك الاكاديمية'],
            ['key' => 'track_orders_note', 'value' => 'لتتمكن من استخدام ميزة متابعة الطلبات عليك تسجيل الدخول'],

            // University Stats (Register Page)
            ['key' => 'stats_scholarships', 'value' => '+200k'],
            ['key' => 'stats_students', 'value' => '+20000'],
            ['key' => 'stats_buildings', 'value' => '11'],
            ['key' => 'stats_majors', 'value' => '+40'],
            ['key' => 'stats_founded_at', 'value' => '1978'],
            
            // About Section
            ['key' => 'about_university', 'value' => 'تأسست الجامعة الإسلامية بغزة عام 1978، وهي مؤسسة أكاديمية رائدة تقدم برامج تعليمية متنوعة في العلوم والآداب، وتتميز ببيئة تعليمية محفزة للطالبات والطلاب.'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
