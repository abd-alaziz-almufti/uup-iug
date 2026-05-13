<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionCard extends Model
{
    protected $fillable = ['title', 'subtitle', 'icon', 'action_text', 'order'];

    public function items()
    {
        return $this->hasMany(AdmissionCardItem::class)->orderBy('order');
    }
}
