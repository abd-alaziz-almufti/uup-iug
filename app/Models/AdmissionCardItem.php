<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionCardItem extends Model
{
    protected $fillable = ['admission_card_id', 'label', 'value', 'order'];

    public function card()
    {
        return $this->belongsTo(AdmissionCard::class);
    }
}
