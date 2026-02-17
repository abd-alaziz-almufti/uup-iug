<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'department_id',
        'published_by',
    ];

    /**
     * القسم
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * الناشر
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Scopes
     */
    public function scopeGeneral($query)
    {
        return $query->whereNull('department_id');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }
}
