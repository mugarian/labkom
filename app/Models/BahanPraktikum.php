<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Models\Penggunaan;
use App\Models\Laboratorium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BahanPraktikum extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $table = 'bahan_praktikums';

    protected $casts = [
        'id' => 'string'
    ];

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }

    public function bahanjurusan()
    {
        return $this->hasMany(BahanJurusan::class);
    }

    public function penggunaan()
    {
        return $this->hasMany(Penggunaan::class);
    }
}
