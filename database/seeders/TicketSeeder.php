<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎫 Creating tickets...');

        // جلب المستخدمين
        $students = User::where('role_id', 1)->get(); // الطلاب
        $staff = User::where('role_id', 2)->get(); // الموظفين
        $departments = Department::where('type', 'Admin_Dept')->get();

        if ($students->isEmpty() || $departments->isEmpty()) {
            $this->command->warn('⚠️  No students or departments found. Run UserSeeder and DepartmentSeeder first!');
            return;
        }

        // ========================================
        // 1. تذاكر مفتوحة (Open)
        // ========================================
        $openTickets = [
            [
                'title' => 'مشكلة في تسجيل مادة البرمجة الكائنية',
                'category' => 'تسجيل مواد',
                'priority' => 'high',
                'student_id' => $students->random()->id,
                'department_id' => $departments->firstWhere('name', 'دائرة القبول والتسجيل')->id ?? $departments->random()->id,
            ],
            [
                'title' => 'استفسار عن موعد دفع الرسوم الدراسية',
                'category' => 'مالي',
                'priority' => 'medium',
                'student_id' => $students->random()->id,
                'department_id' => $departments->firstWhere('name', 'دائرة الشؤون المالية')->id ?? $departments->random()->id,
            ],
            [
                'title' => 'طلب تأجيل امتحان نهائي',
                'category' => 'امتحانات',
                'priority' => 'urgent',
                'student_id' => $students->random()->id,
                'department_id' => $departments->firstWhere('name', 'دائرة شؤون الطلبة')->id ?? $departments->random()->id,
            ],
            [
                'title' => 'لم أستلم كشف العلامات',
                'category' => 'علامات',
                'priority' => 'medium',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
            ],
            [
                'title' => 'مشكلة في الوصول لنظام Moodle',
                'category' => 'تقني',
                'priority' => 'low',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
            ],
        ];

        foreach ($openTickets as $ticketData) {
            $ticket = Ticket::create([
                ...$ticketData,
                'status' => 'open',
                'assigned_to' => null,
            ]);

            // إضافة تاريخ
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->student_id,
                'action' => 'created',
                'details' => 'تم إنشاء التذكرة',
            ]);

            $this->command->info("  ✅ Open Ticket: {$ticket->title}");
        }

        // ========================================
        // 2. تذاكر قيد المعالجة (In Progress)
        // ========================================
        $inProgressTickets = [
            [
                'title' => 'طلب تغيير شعبة مادة قواعد البيانات',
                'category' => 'تسجيل مواد',
                'priority' => 'medium',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
                'assigned_to' => $staff->random()->id ?? null,
            ],
            [
                'title' => 'استفسار عن المنح الدراسية',
                'category' => 'مالي',
                'priority' => 'low',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
                'assigned_to' => $staff->random()->id ?? null,
            ],
            [
                'title' => 'طلب إعادة تصحيح ورقة امتحان',
                'category' => 'امتحانات',
                'priority' => 'high',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
                'assigned_to' => $staff->random()->id ?? null,
            ],
        ];

        foreach ($inProgressTickets as $ticketData) {
            $ticket = Ticket::create([
                ...$ticketData,
                'status' => 'in_progress',
            ]);

            // تاريخ: إنشاء
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->student_id,
                'action' => 'created',
                'details' => 'تم إنشاء التذكرة',
                'created_at' => now()->subDays(2),
            ]);

            // تاريخ: تعيين
            if ($ticket->assigned_to) {
                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'action' => 'assigned',
                    'details' => 'تم تعيين التذكرة للموظف',
                    'created_at' => now()->subDays(1),
                ]);
            }

            // إضافة رد من الموظف
            if ($ticket->assigned_to) {
                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'reply_text' => 'تم استلام طلبك وجاري المعالجة. سيتم الرد خلال 24 ساعة.',
                    'created_at' => now()->subHours(12),
                ]);

                // رد من الطالب
                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->student_id,
                    'reply_text' => 'شكراً لكم، بانتظار الرد.',
                    'created_at' => now()->subHours(6),
                ]);
            }

            $this->command->info("  ✅ In Progress Ticket: {$ticket->title}");
        }

        // ========================================
        // 3. تذاكر محلولة (Resolved)
        // ========================================
        $resolvedTickets = [
            [
                'title' => 'طلب كشف علامات الفصل السابق',
                'category' => 'علامات',
                'priority' => 'low',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
                'assigned_to' => $staff->random()->id ?? null,
            ],
            [
                'title' => 'مشكلة في طباعة الوصل المالي',
                'category' => 'مالي',
                'priority' => 'medium',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
                'assigned_to' => $staff->random()->id ?? null,
            ],
        ];

        foreach ($resolvedTickets as $ticketData) {
            $ticket = Ticket::create([
                ...$ticketData,
                'status' => 'resolved',
            ]);

            // تاريخ كامل
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->student_id,
                'action' => 'created',
                'details' => 'تم إنشاء التذكرة',
                'created_at' => now()->subDays(5),
            ]);

            if ($ticket->assigned_to) {
                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'action' => 'assigned',
                    'details' => 'تم تعيين التذكرة',
                    'created_at' => now()->subDays(4),
                ]);

                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'action' => 'status_changed',
                    'details' => 'تم تغيير الحالة من open إلى in_progress',
                    'created_at' => now()->subDays(3),
                ]);

                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'action' => 'status_changed',
                    'details' => 'تم تغيير الحالة من in_progress إلى resolved',
                    'created_at' => now()->subDays(1),
                ]);

                // ردود
                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'reply_text' => 'تم حل المشكلة. يرجى التحقق من بريدك الإلكتروني.',
                    'created_at' => now()->subDays(1),
                ]);
            }

            $this->command->info("  ✅ Resolved Ticket: {$ticket->title}");
        }

        // ========================================
        // 4. تذاكر مغلقة (Closed)
        // ========================================
        $closedTickets = [
            [
                'title' => 'طلب إفادة طالب',
                'category' => 'إداري',
                'priority' => 'low',
                'student_id' => $students->random()->id,
                'department_id' => $departments->random()->id,
                'assigned_to' => $staff->random()->id ?? null,
            ],
        ];

        foreach ($closedTickets as $ticketData) {
            $ticket = Ticket::create([
                ...$ticketData,
                'status' => 'closed',
            ]);

            // تاريخ كامل
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->student_id,
                'action' => 'created',
                'details' => 'تم إنشاء التذكرة',
                'created_at' => now()->subDays(10),
            ]);

            if ($ticket->assigned_to) {
                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'action' => 'closed',
                    'details' => 'تم إغلاق التذكرة',
                    'created_at' => now()->subDays(7),
                ]);

                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->assigned_to,
                    'reply_text' => 'تم إصدار الإفادة. يمكنك استلامها من دائرة شؤون الطلبة.',
                    'created_at' => now()->subDays(8),
                ]);

                TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $ticket->student_id,
                    'reply_text' => 'تم الاستلام. شكراً لكم.',
                    'created_at' => now()->subDays(7),
                ]);
            }

            $this->command->info("  ✅ Closed Ticket: {$ticket->title}");
        }

        // ========================================
        // الخلاصة
        // ========================================
        $total = Ticket::count();
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("🎉 Created {$total} tickets successfully!");
        $this->command->info("   📂 Open: " . Ticket::where('status', 'open')->count());
        $this->command->info("   ⚙️  In Progress: " . Ticket::where('status', 'in_progress')->count());
        $this->command->info("   ✅ Resolved: " . Ticket::where('status', 'resolved')->count());
        $this->command->info("   🔒 Closed: " . Ticket::where('status', 'closed')->count());
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }
}
