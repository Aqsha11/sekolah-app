<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'siswa_id',
        'rfid',
        'check_in',
        'check_out',
        'status',
        'tanggal',
    ];

    /**
     * Casting tipe data otomatis
     */
    protected function casts(): array
    {
        return [
            'check_in' => 'datetime',
            'check_out' => 'datetime',
            'tanggal' => 'date',
        ];
    }

    /**
     * Relasi: satu absensi milik satu siswa
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
