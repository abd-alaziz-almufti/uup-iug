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
