<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('❓ Creating FAQs...');

        // ========================================
        // 1. أسئلة عامة
        // ========================================
        $generalFAQs = [
            [
                'question' => 'كيف أسجل في المواد الدراسية؟',
                'answer' => 'ادخل على نظام التسجيل من خلال الموقع الإلكتروني للجامعة، اختر "تسجيل مواد"، ثم اختر المواد والشعب المتاحة.',
                'category' => 'التسجيل',
                'course_id' => null,
            ],
            [
                'question' => 'كيف أدفع الرسوم الدراسية؟',
                'answer' => 'يمكنك الدفع من خلال البنوك المعتمدة أو من خلال الصراف في الجامعة.',
                'category' => 'مالي',
                'course_id' => null,
            ],
            [
                'question' => 'متى تبدأ الامتحانات النهائية؟',
                'answer' => 'تبدأ الامتحانات النهائية في الأسبوع الأخير من الفصل الدراسي حسب الجدول المعلن.',
                'category' => 'امتحانات',
                'course_id' => null,
            ],
            [
                'question' => 'كيف أحصل على كشف علامات؟',
                'answer' => 'يمكنك طباعة كشف العلامات من خلال نظام الطالب الإلكتروني أو طلبه من دائرة القبول والتسجيل.',
                'category' => 'علامات',
                'course_id' => null,
            ],
        ];

        foreach ($generalFAQs as $faq) {
            FAQ::create($faq);
        }

        $this->command->info('  ✅ Created ' . count($generalFAQs) . ' general FAQs');

        // ========================================
        // 2. أسئلة خاصة بالمواد
        // ========================================
        $courseFAQs = [
            // CS101
            [
                'course_code' => 'CS101',
                'question' => 'ما هي المتطلبات السابقة لهذه المادة؟',
                'answer' => 'لا يوجد متطلبات سابقة. هذه مادة تمهيدية.',
                'category' => 'متطلبات',
            ],
            [
                'course_code' => 'CS101',
                'question' => 'هل يوجد مختبر عملي؟',
                'answer' => 'نعم، يوجد مختبر عملي ساعتين أسبوعياً.',
                'category' => 'عام',
            ],

            // CS201
            [
                'course_code' => 'CS201',
                'question' => 'ما هي المتطلبات السابقة لمادة البرمجة الكائنية؟',
                'answer' => 'يجب إنهاء مادة البرمجة 1 (CS102) بنجاح.',
                'category' => 'متطلبات',
            ],
            [
                'course_code' => 'CS201',
                'question' => 'ما هي لغة البرمجة المستخدمة؟',
                'answer' => 'نستخدم لغة Java في هذه المادة.',
                'category' => 'عام',
            ],

            // CS203
            [
                'course_code' => 'CS203',
                'question' => 'ما هي أنظمة قواعد البيانات التي نتعلمها؟',
                'answer' => 'نتعلم MySQL و PostgreSQL بشكل أساسي.',
                'category' => 'عام',
            ],

            // CS301
            [
                'course_code' => 'CS301',
                'question' => 'ما هي التقنيات المستخدمة في تطوير تطبيقات الويب؟',
                'answer' => 'نستخدم HTML, CSS, JavaScript, وإطار عمل Laravel أو React.',
                'category' => 'عام',
            ],

            // CS499
            [
                'course_code' => 'CS499',
                'question' => 'متى يجب التسجيل في مشروع التخرج؟',
                'answer' => 'يجب التسجيل في مشروع التخرج بعد إنهاء 90 ساعة معتمدة على الأقل.',
                'category' => 'متطلبات',
            ],
            [
                'course_code' => 'CS499',
                'question' => 'هل يمكن العمل على المشروع بشكل فردي؟',
                'answer' => 'يفضل العمل ضمن مجموعة من 2-3 طلاب، ولكن يمكن العمل فردياً بموافقة المشرف.',
                'category' => 'عام',
            ],
        ];

        foreach ($courseFAQs as $faqData) {
            $course = Course::where('course_code', $faqData['course_code'])->first();
            
            if ($course) {
                FAQ::create([
                    'question' => $faqData['question'],
                    'answer' => $faqData['answer'],
                    'category' => $faqData['category'],
                    'course_id' => $course->id,
                ]);
            }
        }

        $this->command->info('  ✅ Created ' . count($courseFAQs) . ' course-specific FAQs');

        // ========================================
        // الخلاصة
        // ========================================
        $total = FAQ::count();
        $general = FAQ::whereNull('course_id')->count();
        $courseBased = FAQ::whereNotNull('course_id')->count();

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🎉 Created {$total} FAQs successfully!");
        $this->command->info("   📖 General FAQs: {$general}");
        $this->command->info("   📚 Course-based FAQs: {$courseBased}");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }
}
