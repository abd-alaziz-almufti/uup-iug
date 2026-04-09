<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'type',
        'icon',
    ];

    /**
     * المستخدمين في هذا القسم
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * التذاكر الموجهة لهذا القسم
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * جهات الاتصال في هذا القسم
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * الإعلانات الخاصة بهذا القسم
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * الخدمات الأكاديمية لهذا القسم
     */
    public function academicServices()
    {
        return $this->hasMany(AcademicService::class);
    }

    /**
     * المواد الدراسية لهذا القسم
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
