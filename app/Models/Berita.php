<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'berita';

    /**
     * Kolom yang boleh diisi (berita/artikel)
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'image',
        'published_at',
        'is_published',
        'user_id',
        'views',
        'date',
    ];
}
