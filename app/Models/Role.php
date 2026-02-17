<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array', // ✅ تحويل JSON تلقائياً
    ];

    /**
     * المستخدمين اللي عندهم هذا الدور
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
