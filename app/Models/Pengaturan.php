<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $fillable = ['key', 'value'];

    /** Ambil path file (nilai mentah) untuk sebuah key. */
    public static function ambil(string $key): ?string
    {
        return Cache::rememberForever("pengaturan.$key", function () use ($key) {
            return static::where('key', $key)->value('value');
        });
    }

    /** URL publik gambar dari pengaturan Super Admin. */
    public static function url(string $key, ?string $fallback = null): ?string
    {
        $path = static::ambil($key);

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return $fallback ? asset($fallback) : null;
    }

    /**
     * Daftar URL gambar beranda untuk slider di welcome page.
     *
     * Sumber data:
     * 1) key 'hero_images' -> JSON array path
     * 2) key lama hero_1..3 -> digunakan jika hero_images belum tersedia
     *
     * Jika tidak ada gambar tersimpan, hasilnya array kosong.
     */
    public static function heroSlides(): array
    {
        $paths = [];
        $raw = static::ambil('hero_images');

        if ($raw !== null && $raw !== '') {
            $decoded = json_decode($raw, true);
            $paths = is_array($decoded) ? $decoded : [];
        } else {
            foreach ([1, 2, 3] as $i) {
                $path = static::ambil("hero_$i");

                if ($path) {
                    $paths[] = $path;
                }
            }
        }

        return collect($paths)
            ->filter(fn ($path) => is_string($path)
                && $path !== ''
                && Storage::disk('public')->exists($path))
            ->map(fn ($path) => Storage::url($path))
            ->values()
            ->all();
    }
}