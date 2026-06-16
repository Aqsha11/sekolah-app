<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';

    /**
     * Kolom yang boleh diisi (pesan dari pengunjung website)
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'reply_message',
        'replied_by',
        'replied_at',
    ];
}
