<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Models\Peminjaman;
use App\Models\BahanPraktikum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BahanJurusan extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }

    public function bahanpraktikum()
    {
        return $this->belongsTo(BahanPraktikum::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
