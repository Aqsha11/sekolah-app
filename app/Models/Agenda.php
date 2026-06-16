<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    /**
     * Kolom yang boleh diisi (agenda/kegiatan sekolah)
     */
    protected $fillable = [
        'judul',
        'tanggal',
        'deskripsi',
    ];
}
