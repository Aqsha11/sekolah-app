<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use SoftDeletes;
    protected $table = 'fasilitas';

    /**
     * Kolom yang boleh diisi (fasilitas sekolah)
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];
}
