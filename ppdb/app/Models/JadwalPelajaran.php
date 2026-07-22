<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPelajaran extends Model
{
    protected $fillable = [
        'kelas_id',
        'guru_id',
        'mata_pelajaran',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Warna background berdasarkan mata pelajaran (konsisten per mapel)
     */
    public function getWarnaAttribute(): string
    {
        $colors = [
            'bg-blue-50 border-blue-200',
            'bg-emerald-50 border-emerald-200',
            'bg-violet-50 border-violet-200',
            'bg-amber-50 border-amber-200',
            'bg-rose-50 border-rose-200',
            'bg-cyan-50 border-cyan-200',
            'bg-indigo-50 border-indigo-200',
            'bg-pink-50 border-pink-200',
            'bg-teal-50 border-teal-200',
            'bg-orange-50 border-orange-200',
        ];

        $hash = crc32($this->mata_pelajaran);
        return $colors[abs($hash) % count($colors)];
    }
}
