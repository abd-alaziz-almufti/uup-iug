<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'type',
        'icon',
        'file_path',
        'created_by',
    ];
}
