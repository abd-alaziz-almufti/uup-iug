<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileEditRequest extends Model
{
    protected $fillable = [
        'student_id',
        'requested_by',
        'requested_data',
        'status',
    ];

    protected $casts = [
        'requested_data' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
