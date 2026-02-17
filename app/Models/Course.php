<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'name',
        'credit_hours',
        'department_id', // ✅ إضافة
    ];

    /**
     * القسم أو الكلية
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * الأسئلة الشائعة
     */
    public function faqs()
    {
        return $this->hasMany(FAQ::class);
    }

    /**
     * التسجيلات
     */
    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class);
    }

    /**
     * Scopes مفيدة
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeGeneral($query)
    {
        return $query->whereNull('department_id');
    }

    public function scopeWithCreditHours($query, $hours)
    {
        return $query->where('credit_hours', $hours);
    }
}
