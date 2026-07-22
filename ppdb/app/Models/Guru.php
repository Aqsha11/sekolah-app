<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;
    protected $table = 'gurus';

    /**
     * Kolom yang boleh diisi (data guru)
     */
    protected $fillable = [
        'name',
        'nip',
        'subject',
        'position',
        'email',
        'phone',
        'photo',
        'bio',
        'is_active',
    ];

    /**
     * Relasi: satu guru punya banyak jadwal pelajaran
     */
    public function jadwalPelajarans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
}
