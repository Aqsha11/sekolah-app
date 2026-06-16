<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /**
     * Kolom yang boleh diisi (daftar kelas)
     */
    protected $fillable = [
        'nama_kelas',
    ];
}
