<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    /**
     * Kolom yang boleh diisi (data alumni)
     */
    protected $fillable = [
        'nama',
        'tahun_lulus',
        'pekerjaan',
    ];
}
