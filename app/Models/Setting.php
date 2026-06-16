<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Kolom yang boleh diisi (pengaturan key-value)
     */
    protected $fillable = ['key', 'value'];

    /**
     * Ambil semua setting jadi array key => value
     */
    public static function allKeyValue()
    {
        return self::pluck('value', 'key');
    }

    /**
     * Ambil satu setting berdasarkan key
     */
    public static function get($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Simpan atau update setting
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
