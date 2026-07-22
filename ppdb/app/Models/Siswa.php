<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;
    /**
     * Kolom yang boleh diisi (data siswa)
     */
    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'jurusan',
        'rfid',
    ];

    /**
     * Relasi: satu siswa punya banyak absensi
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Relasi: satu siswa punya banyak orang tua (many-to-many via pivot orang_tua_siswa)
     */
    public function orangTua(): BelongsToMany
    {
        return $this->belongsToMany(OrangTua::class, 'orang_tua_siswa', 'siswa_id', 'orang_tua_id');
    }
}
