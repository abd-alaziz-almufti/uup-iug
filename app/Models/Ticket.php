<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_code',
        'title',
        'content',
        'category',
        'status',
        'priority',
        'target_type',
        'course_id',
        'student_id',
        'department_id',
        'assigned_to',
    ];

    /**
     * المادة المرتبطة (في حال مراسلة المدرس)
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * الطالب صاحب التذكرة
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * القسم المسؤول
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * الموظف المعين
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * الردود على التذكرة
     */
    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    /**
     * المرفقات
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * تاريخ التذكرة
     */
    public function history()
    {
        return $this->hasMany(TicketHistory::class);
    }

    /**
     * Scopes مفيدة
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    protected static function booted()
    {
        static::creating(function ($ticket) {
            if (empty($ticket->ticket_code)) {
                $lastTicket = static::latest('id')->first();
                $nextId = $lastTicket ? $lastTicket->id + 1 : 1;
                $ticket->ticket_code = 'AA' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($ticket) {
            $usersToNotify = collect();

            if ($ticket->target_type === 'dean') {
                $usersToNotify = \App\Models\User::role('Dean')->where('department_id', $ticket->department_id)->get();
            } elseif ($ticket->target_type === 'admission') {
                $usersToNotify = \App\Models\User::role('Admission Officer')->get();
            } elseif ($ticket->target_type === 'supervisor') {
                $usersToNotify = \App\Models\User::role('Academic Supervisor')->where('department_id', $ticket->department_id)->get();
            } else {
                // Default fallback to instructors or agents
                $usersToNotify = \App\Models\User::role('Instructor')->where('department_id', $ticket->course ? $ticket->course->department_id : $ticket->department_id)->get();
            }

            if ($usersToNotify->isNotEmpty()) {
                $recipientName = $ticket->target_type === 'admission' ? 'موظفي القبول' : 'لكم';
                \Filament\Notifications\Notification::make()
                    ->title('تذكرة جديدة')
                    ->body('تم إنشاء تذكرة جديدة موجهة ' . $recipientName . ' بعنوان: ' . $ticket->title)
                    ->icon('heroicon-o-ticket')
                    ->info()
                    ->sendToDatabase($usersToNotify);
            }
        });

        static::updated(function ($ticket) {
            if ($ticket->wasChanged('assigned_to') && $ticket->assigned_to) {
                $assignedUser = \App\Models\User::find($ticket->assigned_to);
                if ($assignedUser) {
                    \Filament\Notifications\Notification::make()
                        ->title('تذكرة مسندة إليك')
                        ->body('تم تعيينك لمتابعة التذكرة: ' . $ticket->title)
                        ->icon('heroicon-o-user-plus')
                        ->success()
                        ->sendToDatabase($assignedUser);
                }
            }
        });
    }
}
