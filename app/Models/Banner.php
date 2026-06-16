<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /**
     * Kolom yang boleh diisi (banner hero di halaman depan)
     */
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'order',
        'is_active',
    ];

    /**
     * Casting boolean untuk is_active
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
