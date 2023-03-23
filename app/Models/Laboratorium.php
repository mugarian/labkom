<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\Kegiatan;
use App\Models\BarangHabis;
use App\Models\BarangPakai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratorium extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $table = 'laboratorium';

    protected $casts = [
        'id' => 'string'
    ];

    //aktor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //bahan
    public function barangHabis()
    {
        return $this->hasMany(BarangHabis::class);
    }
    //alat
    public function barangPakai()
    {
        return $this->hasMany(BarangPakai::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }
}
