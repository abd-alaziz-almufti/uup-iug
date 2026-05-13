<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = ['name', 'icon'];

    public function majors()
    {
        return $this->hasMany(Major::class);
    }
}
