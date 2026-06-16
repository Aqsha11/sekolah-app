<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrangTua extends Model
{
    protected $table = 'orang_tua';

    /**
     * Kolom yang boleh diisi (data orang tua)
     */
    protected $fillable = [
        'nama',
        'email',
        'phone',
    ];

    /**
     * Relasi: satu orang tua punya banyak anak (siswa) via pivot orang_tua_siswa
     */
    public function anakSiswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'orang_tua_siswa', 'orang_tua_id', 'siswa_id');
    }
}
