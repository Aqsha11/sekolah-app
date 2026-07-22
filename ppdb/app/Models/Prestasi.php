<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use SoftDeletes;
    protected $table = 'prestasis';

    /**
     * Kolom yang boleh diisi (prestasi sekolah)
     */
    protected $fillable = [
        'title',
        'category',
        'level',
        'year',
        'description',
        'image',
    ];
}
