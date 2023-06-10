<?php

namespace App\Models;

use App\Models\Alat;
use App\Traits\Uuids;
use App\Models\Pemakaian;
use App\Models\PeminjamanAlat;
use App\Models\Laboratorium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangPakai extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }

    public function peminjamanalat()
    {
        return $this->hasMany(PeminjamanAlat::class);
    }
}
