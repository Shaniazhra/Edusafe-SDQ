<?php

namespace App\Models;

use App\Support\TahunAjaran;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'kelas',
        'nip',
        'nis',
        'jenis_kelamin',
        'email',
        'password',
        'role',
        'status',
        'tahun_ajaran',
        'angkatan',
        'no_telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'angkatan' => 'integer',
        ];
    }

    /**
     * Siswa baru otomatis dicatat angkatannya (tahun masuk)
     * kalau belum diisi, jadi register/import tidak perlu diubah.
     */
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $isSiswa = in_array($user->role, [null, 'siswa'], true);

            if ($isSiswa && empty($user->angkatan)) {
                $user->angkatan = TahunAjaran::tahunMulai();
            }
        });
    }

    public function hasilSdq()
    {
        return $this->hasMany(HasilSdq::class, 'user_id');
    }
}