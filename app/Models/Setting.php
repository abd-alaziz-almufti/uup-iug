<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Helper to get setting value by key
     */
    public static function get($key, $default = null)
    {
        return self::where('key', $key)->first()?->value ?? $default;
    }
}
