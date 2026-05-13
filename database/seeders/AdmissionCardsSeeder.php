<?php

namespace Database\Seeders;

use App\Models\AdmissionCard;
use App\Models\AdmissionCardItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdmissionCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AdmissionCardItem::truncate();
        AdmissionCard::truncate();
        Schema::enableForeignKeyConstraints();

        $cards = [
            [
                'title' => 'الرسوم الدراسية',
                'subtitle' => 'تمت الدراسة الفصلية',
                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 3c-2.761 0-5 2.239-5 5 0 2.761 2.239 5 5 5 2.761 0 5-2.239 5-5 0-2.761-2.239-5-5-5Zm0 14c-4.418 0-8 1.79-8 4v1h16v-1c0-2.21-3.582-4-8-4Z"/></svg>',
                'items' => [
                    ['label' => 'كلية الطب البشري', 'value' => 'JD 50'],
                    ['label' => 'كلية الهندسة', 'value' => 'JD 35'],
                    ['label' => 'كلية تكنولوجيا المعلومات', 'value' => 'JD 25'],
                    ['label' => 'كلية العلوم الصحية', 'value' => 'JD 25'],
                ],
                'action_text' => 'عرض جميع التكاليف',
            ],
            [
                'title' => 'معدلات القبول',
                'subtitle' => 'العام الدراسي 2025-2027',
                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M4 19h16v2H4v-2Zm2-8h3v6H6v-6Zm5-4h3v10h-3V7Zm5 2h3v8h-3V9Z"/></svg>',
                'items' => [
                    ['label' => 'كلية الطب البشري', 'value' => '+92%'],
                    ['label' => 'كلية الهندسة', 'value' => '+85%'],
                    ['label' => 'كلية تكنولوجيا المعلومات', 'value' => '+75%'],
                    ['label' => 'كلية العلوم الصحية', 'value' => '+75%'],
                ],
                'action_text' => 'عرض جميع النسب',
            ],
            [
                'title' => 'الكليات والتخصصات',
                'subtitle' => '11 كليات - +40 تخصص',
                'icon' => '<svg viewBox="0 0 24 24" class="h-7 w-7" fill="currentColor"><path d="M12 2 2 7l10 5 10-5-10-5Zm0 7L2 4v6l10 5 10-5V4l-10 5Zm0 7-7.5-3.75V18L12 21l7.5-3v-5.75L12 16Z"/></svg>',
                'items' => [
                    ['label' => 'كلية الطب البشري', 'value' => '4 تخصصات'],
                    ['label' => 'كلية الهندسة', 'value' => '4 تخصصات'],
                    ['label' => 'كلية تكنولوجيا المعلومات', 'value' => '4 تخصصات'],
                    ['label' => 'كلية العلوم الصحية', 'value' => '4 تخصصات'],
                ],
                'action_text' => 'عرض جميع الكليات',
            ],
        ];

        foreach ($cards as $index => $cardData) {
            $card = AdmissionCard::create([
                'title' => $cardData['title'],
                'subtitle' => $cardData['subtitle'],
                'icon' => $cardData['icon'],
                'action_text' => $cardData['action_text'],
                'order' => $index,
            ]);

            foreach ($cardData['items'] as $itemIndex => $itemData) {
                $card->items()->create([
                    'label' => $itemData['label'],
                    'value' => $itemData['value'],
                    'order' => $itemIndex,
                ]);
            }
        }
    }
}
