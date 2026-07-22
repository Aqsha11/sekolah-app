<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    /**
     * Kolom yang boleh diisi (daftar kelas)
     */
    protected $fillable = [
        'nama_kelas',
    ];

    /**
     * Relasi: satu kelas punya banyak jadwal pelajaran
     */
    public function jadwalPelajarans(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
}
