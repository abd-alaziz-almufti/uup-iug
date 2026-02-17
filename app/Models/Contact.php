<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'position',
        'email',
        'phone',
        'office',
        'department_id',
        'user_id',
    ];

    /**
     * القسم
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * المستخدم (لو موجود)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
