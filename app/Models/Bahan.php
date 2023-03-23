<?php

namespace App\Models;

use App\Models\BarangHabis;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bahan extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function barangHabis()
    {
        return $this->hasMany(BarangHabis::class);
    }
}
