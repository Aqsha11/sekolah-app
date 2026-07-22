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

    /**
     * Generate warna palette dari satu hex (mirip Tailwind blue palette)
     * Warna input = shade 500, lalu generate shade lainnya via HSL
     */
    public static function generateColorPalette(string $hex): array
    {
        $hex = strtolower(ltrim($hex, '#'));

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $rN = $r / 255;
        $gN = $g / 255;
        $bN = $b / 255;

        $max = max($rN, $gN, $bN);
        $min = min($rN, $gN, $bN);
        $delta = $max - $min;

        $h = 0.0;
        $s = 0.0;
        $l = ($max + $min) / 2;

        if ($delta > 0.001) {
            $s = $l > 0.5
                ? $delta / (2 - $max - $min)
                : $delta / ($max + $min);

            if ($max === $rN) {
                $h = (($gN - $bN) / $delta + ($gN < $bN ? 6 : 0)) / 6;
            } elseif ($max === $gN) {
                $h = (($bN - $rN) / $delta + 2) / 6;
            } else {
                $h = (($rN - $gN) / $delta + 4) / 6;
            }
        }

        $h *= 360;

        // shade 500 = warna asli user
        $lightnessMap = [
            50  => 0.97,
            100 => 0.93,
            200 => 0.86,
            300 => 0.76,
            400 => 0.64,
            500 => $l,
            600 => max(0.12, $l - 0.09),
            700 => max(0.12, $l - 0.16),
            800 => max(0.12, $l - 0.24),
            900 => max(0.10, $l - 0.30),
            950 => max(0.08, $l - 0.40),
        ];

        $satMult = [
            50  => 0.55,
            100 => 0.65,
            200 => 0.72,
            300 => 0.82,
            400 => 0.92,
            500 => 1.0,
            600 => 0.95,
            700 => 0.85,
            800 => 0.75,
            900 => 0.65,
            950 => 0.55,
        ];

        $palette = [];

        foreach ($lightnessMap as $shade => $targetL) {
            $targetS = min(1.0, $s * ($satMult[$shade] ?? 1.0));
            $palette[$shade] = self::hslToHex($h, $targetS, $targetL);
        }

        return $palette;
    }

    protected static function hslToHex(float $h, float $s, float $l): string
    {
        $h /= 360;
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h * 6, 2) - 1));
        $m = $l - $c / 2;

        $r = $g = $b = 0.0;

        if ($h < 1 / 6) { $r = $c; $g = $x; }
        elseif ($h < 2 / 6) { $r = $x; $g = $c; }
        elseif ($h < 3 / 6) { $g = $c; $b = $x; }
        elseif ($h < 4 / 6) { $g = $x; $b = $c; }
        elseif ($h < 5 / 6) { $r = $x; $b = $c; }
        else { $r = $c; $b = $x; }

        $r = (int) round(($r + $m) * 255);
        $g = (int) round(($g + $m) * 255);
        $b = (int) round(($b + $m) * 255);

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
