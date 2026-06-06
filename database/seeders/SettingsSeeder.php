<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'university_email' => 'public@iugaza.edu.ps',
            'university_facebook' => 'https://www.facebook.com/IUGaza/',
            'university_twitter' => 'https://twitter.com/IUGaza',
            'university_instagram' => 'https://www.instagram.com/iugaza/',
            'university_youtube' => 'https://www.youtube.com/user/IUGAZA',
            'university_telegram' => 'https://t.me/iugaza',
            'university_broadcast' => '#',
            'university_box' => '#',
            'about_university' => 'تأسست الجامعة الإسلامية بغزة عام 1978، وهي مؤسسة أكاديمية مستقلة من مؤسسات التعليم العالي في فلسطين، تعمل تحت إشراف وزارة التربية والتعليم العالي، وهي عضو في كل من اتحاد الجامعات العربية، واتحاد جامعات العالم الإسلامي، ورابطة الجامعات الإسلامية، والاتحاد الدولي للجامعات، ورابطة جامعات حوض البحر المتوسط.',
            'stats_scholarships' => '+200k',
            'stats_students' => '+20000',
            'stats_buildings' => '11',
            'stats_majors' => '+40',
            'stats_founded_at' => '1978',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
