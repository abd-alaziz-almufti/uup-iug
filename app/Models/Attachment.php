<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['ticket_id', 'file_name', 'file_type', 'file_size', 'uploaded_at'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
