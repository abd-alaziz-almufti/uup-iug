<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'category',
        'course_id',
    ];

    /**
     * المادة الدراسية (لو السؤال خاص بمادة)
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope للأسئلة العامة
     */
    public function scopeGeneral($query)
    {
        return $query->whereNull('course_id');
    }

    /**
     * Scope لأسئلة المواد
     */
    public function scopeCourseBased($query)
    {
        return $query->whereNotNull('course_id');
    }
}
