<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $fillable = [
        'nama',
        'icon',
        'url',
        'is_active',
        'urutan',
    ];
}
