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
}
