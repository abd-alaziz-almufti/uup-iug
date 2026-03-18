<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title',
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
}
