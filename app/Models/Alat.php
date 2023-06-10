<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function barangpakai()
    {
        return $this->hasMany(BarangPakai::class);
    }

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
