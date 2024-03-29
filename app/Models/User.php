<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Dosen;
use App\Models\Staff;
use App\Traits\Uuids;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\Penggunaan;
use App\Models\Laboratorium;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string'
    ];

    //aktor
    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }

    public function dospem()
    {
        return $this->hasMany(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    // aktifitas
    // public function kegiatan()
    // {
    //     return $this->hasMany(Kegiatan::class);
    // }

    public function pelaksanaan()
    {
        return $this->hasMany(Pelaksanaan::class);
    }

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }

    public function penggunaan()
    {
        return $this->hasMany(Penggunaan::class);
    }

    public function peminjamanalat()
    {
        return $this->hasMany(PeminjamanAlat::class);
    }

    public function peminjamanbahan()
    {
        return $this->hasMany(PeminjamanBahan::class);
    }

    //laboratorium
    public function laboratorium()
    {
        return $this->hasMany(Laboratorium::class);
    }

    public function algoritma()
    {
        return $this->hasMany(Algoritma::class);
    }

    public function prediksi()
    {
        return $this->hasMany(Prediksi::class);
    }

    public function datamentah()
    {
        return $this->hasMany(DataMentah::class);
    }
}
