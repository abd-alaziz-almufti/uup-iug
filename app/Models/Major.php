<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [
        'department_id', 
        'name', 
        'degree_type', 
        'acceptance_rate', 
        'credit_hour_price', 
        'total_hours'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
