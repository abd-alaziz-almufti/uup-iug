<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentEnrollment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'grade',
        'status',
    ];

    /**
     * الطالب
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * المادة
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function booted()
    {
        static::saved(function ($enrollment) {
            \Illuminate\Support\Facades\Cache::forget('student_courses_' . $enrollment->student_id);
        });

        static::deleted(function ($enrollment) {
            \Illuminate\Support\Facades\Cache::forget('student_courses_' . $enrollment->student_id);
        });
    }
}
