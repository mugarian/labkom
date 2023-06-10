<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Uuids;
use App\Models\BarangPakai;
use App\Models\BahanJurusan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $table = 'peminjamans';

    protected $casts = [
        'id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barangpakai()
    {
        return $this->belongsTo(BarangPakai::class);
    }

    public function bahanjurusan()
    {
        return $this->belongsTo(BahanJurusan::class);
    }
}
