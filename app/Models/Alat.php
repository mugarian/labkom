<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Models\BarangPakai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alat extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [''];

    protected $casts = [
        'id' => 'string'
    ];

    public function barangpakai()
    {
        return $this->hasMany(BarangPakai::class);
    }
}
