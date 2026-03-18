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
            // تحديث حالة التذكرة لتصبح "قيد المعالجة" عند إضافة رد
            if ($reply->ticket && $reply->ticket->status === 'open') {
                $reply->ticket->update(['status' => 'in_progress']);
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
