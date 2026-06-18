<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'reply_text',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            // تحديث حالة التذكرة لتصبح "قيد المعالجة" عند إضافة رد مفتوح
            if ($reply->ticket && $reply->ticket->status === 'open') {
                $reply->ticket->update(['status' => 'in_progress']);
            }

            // 1. إشعار الموظف المسؤول إذا كان الرد من الطالب
            if ($reply->ticket && $reply->ticket->assigned_to && $reply->user_id !== $reply->ticket->assigned_to) {
                $assignedUser = \App\Models\User::find($reply->ticket->assigned_to);
                if ($assignedUser) {
                    \Filament\Notifications\Notification::make()
                        ->title('رد جديد على تذكرة')
                        ->body('طالب قام بالرد على التذكرة: ' . $reply->ticket->title)
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->info()
                        ->sendToDatabase($assignedUser);
                }
            }

            // 2. إشعار الطالب إذا كان الرد من موظف
            if ($reply->ticket && $reply->user_id !== $reply->ticket->student_id) {
                if ($reply->ticket->student) {
                    \Filament\Notifications\Notification::make()
                        ->title('رد جديد من الإدارة')
                        ->body('تلقيت رداً جديداً على تذكرتك: ' . $reply->ticket->title)
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->success()
                        ->sendToDatabase($reply->ticket->student);
                }
            }

            // 3. إشعار المجموعة المسؤولة إذا كانت التذكرة غير مسندة والرد من الطالب
            if ($reply->ticket && !$reply->ticket->assigned_to && $reply->user_id === $reply->ticket->student_id) {
                $ticket = $reply->ticket;
                $usersToNotify = collect();

                if ($ticket->target_type === 'dean') {
                    $usersToNotify = \App\Models\User::role('Dean')->where('department_id', $ticket->department_id)->get();
                } elseif ($ticket->target_type === 'admission') {
                    $usersToNotify = \App\Models\User::role('Admission Officer')->get();
                } elseif ($ticket->target_type === 'supervisor') {
                    $usersToNotify = \App\Models\User::role('Academic Supervisor')->where('department_id', $ticket->department_id)->get();
                } else {
                    // Fallback to instructors in the same department
                    $usersToNotify = \App\Models\User::role('Instructor')->where('department_id', $ticket->course ? $ticket->course->department_id : $ticket->department_id)->get();
                }

                if ($usersToNotify->isNotEmpty()) {
                    \Filament\Notifications\Notification::make()
                        ->title('تحديث على تذكرة غير مسندة')
                        ->body('قام الطالب بالرد على تذكرة غير مسندة بعنوان: ' . $ticket->title)
                        ->icon('heroicon-o-exclamation-circle')
                        ->warning()
                        ->sendToDatabase($usersToNotify);
                }
            }
        });

        static::saved(function ($reply) {
            if ($reply->ticket) {
                \Illuminate\Support\Facades\Cache::forget('student_tickets_' . $reply->ticket->student_id);
            }
        });

        static::deleted(function ($reply) {
            if ($reply->ticket) {
                \Illuminate\Support\Facades\Cache::forget('student_tickets_' . $reply->ticket->student_id);
            }
        });
    }

    /**
     * التذكرة
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * المستخدم اللي كتب الرد
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
