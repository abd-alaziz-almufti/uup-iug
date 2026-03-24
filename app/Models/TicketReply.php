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

            // إرسال إشعار للموظف المسؤول إذا كان الرد من الطالب
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
